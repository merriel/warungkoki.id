<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Users;
use App\Follow;
use App\Wilayah;
use App\Posts;
use App\Regency;
use App\Product;
use App\Kategori;
use App\Transaksi;
use App\WSTransaksi;
use App\Tours;
use App\UpdateStocks;
use App\Services;
use App\TransaksiDetails;
use App\Keranjang;
use App\PostDetails;
use Auth;
use DB;
use Mail;
use Uuid;

class BazaarController extends Controller
{
    public function index()
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d');

        $user = Auth::user();

        $iduser = $user->id;

        $wilayahid = $user->wilayah_id;

        $roles = Users::select("role_id")
        ->where("id", $user->id)
        ->first();

        $ada = Follow::where("user_id", $iduser)
        ->count();

        // === KATEGORI BBM ===

        $kategori = Kategori::all();

        $reedems = Transaksi::where([
            ['type', '=', 'out'],
            ['user_id', '=', $user->id],
            ['status', '=', 'REEDEM'],
        ])
        ->orderBy("transactions.id","desc")
        ->get();

        $toko = Users::select("wilayah.*","company.photo","regencies.name as regency_name")
        ->join("wilayah", "users.wilayah_id", "=", "wilayah.id")
        ->join("company", "wilayah.company_id", "=", "company.id")
        ->join("regencies", "wilayah.regency_id", "=", "regencies.id")
        ->where("users.id", $user->id)
        ->first();

        $sudahtour = Tours::where("user_id", $user->id)
        ->first();

        if(!$sudahtour){

            $tour = new Tours();
            $tour->user_id = $user->id;
            $tour->home = '1';
            $tour->save();

        }

        $cekout = Transaksi::where([
            ["user_id", '=', $user->id],
            ['type', '=', 'out'],
            ['status', '=', 'APPROVED'],
        ])
        ->first();

        $service = Services::first();

        return view('bazaar.home.index', compact('date','iduser','wilayahid','kategori','reedems','toko','sudahtour','cekout','service'));

    }

    public function keranjang()
    {
    	date_default_timezone_set('Asia/Jakarta');
		$date = date('Y-m-d');

		$user = Auth::user();

		$kranjangs = Keranjang::select("posts.name","posts.harga_act","keranjang.qty","keranjang.id","product.img as img_name","wilayah.name as wilayah_name","product.name as prod_name","posts.img")
		->leftJoin("posts", "keranjang.post_id", "=", "posts.id")
        ->leftJoin("users", "posts.user_id", "=", "users.id")
        ->leftJoin("wilayah", "users.wilayah_id", "=", "wilayah.id")
        ->leftJoin("product", "posts.product_id", "=", "product.id")
        ->where([
            ['keranjang.user_id', '=', $user->id],
            ['voucherdet_id', '=', NULL],
            ['posts.type', '=', 'Bazaar'],
        ])
		->get();

        $userdetails = Users::where('id', $user->id)
        ->first();

        $adatrans = Transaksi::where("user_id", $user->id)
        ->first();

		$ada = Keranjang::leftJoin("posts", "keranjang.post_id", "=", "posts.id")
		->where([
            ['keranjang.user_id', '=', $user->id],
            ['posts.type', '=', 'Bazaar'],
        ])
		->count();

        $service = Services::first();

		return view('bazaar.keranjang.index', compact('date','kranjangs','ada','userdetails','adatrans','service'));

    }

    public function detail($id)
    {
        date_default_timezone_set('Asia/Jakarta');

    	$postnews = Posts::select("posts.*","company.photo","wilayah.name as wilayah_name","regencies.name as regency_name","wilayah.id as wilayah_id","wilayah.alamat","wilayah.uuid","product.name as prod_name","product.id as prod_id","product.img")
		// ->join("post_images", "posts.id", "=", "post_images.post_id")
		// ->join("imgpost", "post_images.img_id", "=", "imgpost.id")
        ->join("users", "posts.user_id", "=", "users.id")
        ->join("wilayah", "users.wilayah_id", "=", "wilayah.id")
        ->join("regencies", "wilayah.regency_id", "=", "regencies.id")
        ->join("company", "wilayah.company_id", "=", "company.id")
        ->join("product", "posts.product_id", "=", "product.id")
		->where("posts.id", $id)
		->first();

        $user = Auth::user();

        $userid = $user->id;

		$postproducts = PostDetails::select("product.name","post_details.qty")
		->join("product", "post_details.product_id", "=", "product.id")
		->where("post_details.post_id", $id)
		->get();

        $postid = $id;


        $tour = Tours::where("user_id", $user->id)
        ->first();

        $sudahtour = Tours::where(['user_id'=>$user->id])
        ->update(['detailprod'=>'1']);

        $service = Services::first();

		return view('bazaar.home.detail', compact('postnews','postproducts','userid','postid','tour','service'));

    }

    public function count(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');

        $user = Auth::user();

		$ada = Keranjang::leftJoin("posts", "keranjang.post_id", "=", "posts.id")
		->where([
            ['keranjang.user_id', '=', $user->id],
            ['posts.type', '=', 'Bazaar'],
        ])
		->count();
        
        return response()->json($ada);
    }

    public function bayar()
    {
    	date_default_timezone_set('Asia/Jakarta');
		$date = date('Y-m-d');

		$user = Auth::user();

		$keranjangs = Keranjang::select("posts.*","keranjang.qty","wilayah.name as wilayah_name","product.name as prod_name")
		->leftJoin("posts", "keranjang.post_id", "=", "posts.id")
        ->leftJoin("product", "posts.product_id", "=", "product.id")
        ->leftJoin("users", "posts.user_id", "=", "users.id")
        ->leftJoin("wilayah", "users.wilayah_id", "=", "wilayah.id")
		->where("keranjang.user_id", $user->id)
		->where([
            ['keranjang.user_id', '=', $user->id],
            ['posts.type', '=', 'Bazaar'],
        ])
		->get();

        $adatrans = Transaksi::where("user_id", $user->id)
        ->first();

		return view('content.pembayaran.bazaar', compact('date','keranjangs','adatrans'));

    }

    public function transaksi()
    {
        date_default_timezone_set('Asia/Jakarta');
        $user = Auth::user();

        $transaksins = Transaksi::select("transactions.*")
        ->leftJoin("transaction_details", "transactions.id", "=", "transaction_details.transaction_id")
        ->leftJoin("posts", "transaction_details.post_id", "=", "posts.id")
        ->where([
            ['transactions.type', '=', 'in'],
            ['transactions.user_id', '=', $user->id],
            ['posts.type', '=', 'Bazaar'],
        ])
        ->distinct()
        ->orderBy("transactions.id","desc")
        ->get();

        $transaksouts = Transaksi::select("transactions.*")
        ->leftJoin("transaction_details", "transactions.id", "=", "transaction_details.transaction_id")
        ->leftJoin("posts", "transaction_details.post_id", "=", "posts.id")
        ->where([
            ['transactions.type', '=', 'out'],
            ['transactions.user_id', '=', $user->id],
            ['posts.type', '=', 'Bazaar'],
        ])
        ->distinct()
        ->orderBy("transactions.id","desc")
        ->get();

        $sumin = Transaksi::select("transactions.*")
        ->leftJoin("transaction_details", "transactions.id", "=", "transaction_details.transaction_id")
        ->leftJoin("posts", "transaction_details.post_id", "=", "posts.id")
        ->where([
            ['transactions.type', '=', 'in'],
            ['transactions.user_id', '=', $user->id],
            ['posts.type', '=', 'Bazaar'],
        ])
        ->count();

        $sumout = Transaksi::select("transactions.*")
        ->leftJoin("transaction_details", "transactions.id", "=", "transaction_details.transaction_id")
        ->leftJoin("posts", "transaction_details.post_id", "=", "posts.id")
        ->where([
            ['transactions.type', '=', 'out'],
            ['transactions.user_id', '=', $user->id],
            ['posts.type', '=', 'Bazaar'],
        ])
        ->count();

        $tour = Tours::where("user_id", $user->id)
        ->first();

        if($transaksins->count() >= 1){

            $sudahtour = Tours::where(['user_id'=>$user->id])
            ->update(['transaksi'=>'1']);

        }

        return view('content.transaksi.bazaar', compact('transaksins','transaksouts','sumin','sumout','tour'));

    }

    public function transaksidetail(Request $request)
    {   
        $trans = Transaksi::select("transactions.*","orders.type_bayar")
        ->leftJoin("orders", "transactions.id", "=", "orders.transaction_id")
        ->where("transactions.uuid", $request->uuid)
        ->first();

        date_default_timezone_set('Asia/Jakarta');
        $user = Auth::user();

        $service = Services::first();

        $wilayah = TransaksiDetails::select("wilayah.name")
        ->leftJoin("transactions", "transaction_details.transaction_id", "=", "transactions.id")
        ->leftJoin("posts", "transaction_details.post_id", "=", "posts.id")
        ->leftJoin("users", "posts.user_id", "=", "users.id")
        ->leftJoin("wilayah", "users.wilayah_id", "=", "wilayah.id")
        ->where("transactions.uuid", $request->uuid)
        ->distinct()
        ->get();

        if($trans->type == "in"){

            $jenis = 'Pembelian';

            $saldos = OrderDetails::select("posts.*","order_details.qty","order_details.amount","transactions.id as trans_id","orders.amount as total","transactions.status","product.name as prod_name")
            ->leftJoin("orders", "order_details.order_id", "=", "orders.id")
            ->leftJoin("transactions", "orders.transaction_id", "=", "transactions.id")
            ->leftJoin("posts", "order_details.post_id", "=", "posts.id")
            ->leftJoin("product", "posts.product_id", "=", "product.id")
            ->where("transactions.uuid", $request->uuid)
            ->get();

        } else {

            $jenis = 'Reedem Saldo';

            $saldos = TransaksiDetails::select("posts.*","transaction_details.qty","transactions.id as trans_id","product.name as prod_name","transactions.status","transaction_details.status as detail_status")
            ->leftJoin("transactions", "transaction_details.transaction_id", "=", "transactions.id")
            ->leftJoin("posts", "transaction_details.post_id", "=", "posts.id")
            ->leftJoin("product", "transaction_details.product_id", "=", "product.id")
            ->where("transactions.uuid", $request->uuid)
            ->get();

        }

        $tour = Tours::where("user_id", $user->id)
        ->first();


        $sudahtour = Tours::where(['user_id'=>$user->id])
        ->update(['transdetail'=>'1']);


        return view('content.transaksi.detailbazaar', compact('saldos','jenis','trans','wilayah','tour','service'));

    }
}
