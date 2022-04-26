<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ImagesPost;
use App\UserCompany;
use App\Product;
use App\Wilayah;
use App\Posts;
use App\PostAreas;
use App\PostDetails;
use App\PostRewards;
use App\PostImages;
use App\Saldo;
use App\Order;
use App\UserPost;
use App\SendNotif;
use App\Users;
use App\Favorite;
use App\Kategori;
use App\Follow;
use App\Company;
use App\Diskusi;
use App\Province;
use App\Regency;
use App\Komentar;
use App\Transaksi;
use App\TransaksiDetails;
use App\ChallangeJoins;
use App\ChallangeProses;
use App\SaldoRewards;
use App\UserDaerah;
use App\ReedemKeranjang;
use App\WSTransaksi;
use App\Tours;
use App\UpdateStocks;
use App\Services;
use App\SaldoTrans;
use App\SaldoUang;
use App\TransactionRetur;
use App\OrderDetails;
use App\Banners;
use Auth;
use DB;
use DataTables;
use Uuid;

class UserHomeController extends Controller
{
	public function index()
    {
	    date_default_timezone_set('Asia/Jakarta');
		$date = date('Y-m-d');

        $user = Auth::user();

        $iduser = $user->id;

        $ada = Follow::where("user_id", $iduser)
        ->count();

        $daerah2 = UserDaerah::select("regencies.*")
        ->join("regencies", "users_daerah.regency_id", "=", "regencies.id")
        ->where("user_id", $user->id)
        ->get();

        $wilayah = '';

        foreach($daerah2 as $d){

            $wilayah .= $d->id.',';
        }

        $potong = substr($wilayah,0,-1);
        $arraywilayah = explode(",",$potong);

        $companies = Wilayah::select("wilayah.*", "company.photo","regencies.name as regency_name")
        ->join("company", "wilayah.company_id", "=", "company.id")
        ->join("regencies", "wilayah.regency_id", "=", "regencies.id")
        // ->whereIn("wilayah.regency_id", $arraywilayah)
        ->where("wilayah.active", "Y")
        ->orderBy('id', 'desc')
        ->limit(6)
        ->get();

        $productnews = Posts::select("posts.id")
        ->leftJoin("post_images", "posts.id", "=", "post_images.post_id")
        ->leftJoin("imgpost", "post_images.img_id", "=", "imgpost.id")
        ->leftJoin("users", "posts.user_id", "=", "users.id")
        ->leftJoin("wilayah", "users.wilayah_id", "=", "wilayah.id")
        ->leftJoin("regencies", "wilayah.regency_id", "=", "regencies.id")
        // ->whereIn("wilayah.regency_id", $arraywilayah)
        ->where([
                ["wilayah.id", $user->wilayah_id],
                ["posts.active", "Y"],
                ['wilayah.active', '=', "Y"],
            ])
        ->orderBy('posts.id', 'desc')
        ->limit(16)
        ->get();


        $daerah = UserDaerah::select("regencies.name")
        ->join("regencies", "users_daerah.regency_id", "=", "regencies.id")
        ->where("user_id", $user->id)
        ->limit(3)
        ->get();

        $regencies = Regency::where("regencies.province_id", '31')
        ->orWhere("province_id", '36')
        ->orWhere("province_id", '32')
        ->get();

        $testing = Regency::all();

        $reedems = Transaksi::where([
            ['type', '=', 'out'],
            ['user_id', '=', $user->id],
            ['status', '=', 'REEDEM'],
        ])
        ->orderBy("transactions.id","desc")
        ->get();

        $workingspaces = WSTransaksi::select("ws-transaksi.*","users.name as username","users.email","ws-orders.amount","wilayah.alamat","ws-room.room_name","ws-desk.desk_code","regencies.name as regency_name")
        ->leftJoin("ws-orders", "ws-transaksi.id", "=", "ws-orders.transaction_id")
        ->leftJoin("ws-desk", "ws-transaksi.desk_id", "=", "ws-desk.id")
        ->leftJoin("ws-room", "ws-desk.room_id", "=", "ws-room.id")
        ->leftJoin("wilayah", "ws-room.wilayah_id", "=", "wilayah.id")
        ->leftJoin("regencies", "wilayah.regency_id", "=", "regencies.id")
        ->leftJoin("users", "ws-transaksi.user_id", "=", "users.id")
        ->where("ws-transaksi.user_id", $user->id)
        ->where([
            ["ws-transaksi.user_id", '=', $user->id],
            ['ws-transaksi.status', '=', 'SUDAH BAYAR'],
        ])
        ->orderBy("ws-transaksi.id", "desc")
        ->get();

        $toko = Users::select("wilayah.*","company.photo","regencies.name as regency_name")
        ->join("wilayah", "users.wilayah_id", "=", "wilayah.id")
        ->join("company", "wilayah.company_id", "=", "company.id")
        ->join("regencies", "wilayah.regency_id", "=", "regencies.id")
        ->where("users.id", $user->id)
        ->first();

		return view('content.home.users.index', compact('date','postnews','iduser','companies','productnews','daerah','regencies','daerah2','testing','toko','reedems','workingspaces'));

	}

    

    public function pilihdaerah(Request $request) {

        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d');

        $user = Auth::user();

        if($request->status == 'checked'){

            $details = new UserDaerah();
            $details->user_id = $user->id;
            $details->regency_id= $request->regency_id;
            $details->save();

        }else {

            $details = UserDaerah::where([
                ['user_id', '=', $user->id],
                ['regency_id', '=', $request->regency_id],
            ])
            ->delete();

        }


        return response()->json($details);
    }

    public function otherapps()
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d');

        return view('content.home.users.otherapps', compact('date'));

    }

    public function search(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d');

        $provinces = Wilayah::select("provinces.*")
        ->join("company", "wilayah.company_id", "=", "company.id")
        ->join("regencies", "wilayah.regency_id", "=", "regencies.id")
        ->join("provinces", "regencies.province_id", "=", "provinces.id")
        ->where("active", "Y")
        ->orderBy("id", "desc")
        ->distinct()
        ->get();

        $request_from = '';

        if($request->request_from == 'reedem_point_product')
        {
            return view('content.reedem_point.produk.users.search', compact('date','provinces','request_from'));
        }

        return view('content.home.users.search', compact('date','provinces','request_from'));

    }

    public function petugas()
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d');

        $user = Auth::user();

        $reedemhariini = Transaksi::where([
            ['type', '=', 'in'],
            ['status', '=', 'APPROVED'],
            ['wilayah_id', '=', $user->wilayah_id],
        ])
        ->whereDate('transactions.created_at', $date)
        ->count();

        $prodreedems = TransaksiDetails::select("transaction_details.qty","transactions.updated_at","product.name as prod_name","posts.name as post_name","transactions.uuid")
        ->join("transactions", "transaction_details.transaction_id", "=", "transactions.id")
        ->join("users", "transactions.petugas_id", "=", "users.id")
        ->join("posts", "transaction_details.post_id", "=", "posts.id")
        ->join("product", "posts.product_id", "=", "product.id")
        ->where([
            ['transactions.type', '=', 'out'],
            ['transactions.status', '=', 'APPROVED'],
            ['users.wilayah_id', '=', $user->wilayah_id],
        ])
        ->whereDate('transactions.created_at', $date)
        ->count();

        $transaksihariini = Transaksi::join("orders", "transactions.id", "=", "orders.transaction_id")
        ->where([
            ['transactions.type', '=', 'in'],
            ['transactions.status', '=', 'APPROVED'],
            ['type_bayar', '=', 'CASH'],
            ['petugas_id', '=', $user->id],
        ])
        ->whereDate('transactions.created_at', $date)
        ->count();

        $transaksirupiah = DB::table('transactions')
        ->join("orders", "transactions.id", "=", "orders.transaction_id")
        ->where([
            ['transactions.type', '=', 'in'],
            ['transactions.status', '=', 'APPROVED'],
            ['transactions.wilayah_id', '=', $user->wilayah_id],
        ])
        ->whereDate('transactions.created_at', $date)
        ->sum('orders.amount');

        $stocks = UpdateStocks::where([
            ['user_id', '=', $user->id],
            ['date', '=', $date],
            ['status', '=', 'selesai'],
        ])
        ->first();

        $reedems = TransaksiDetails::select("transaction_details.qty","transactions.updated_at","product.name as prod_name","posts.name as post_name","transactions.uuid")
        ->join("transactions", "transaction_details.transaction_id", "=", "transactions.id")
        ->join("users", "transactions.petugas_id", "=", "users.id")
        ->join("posts", "transaction_details.post_id", "=", "posts.id")
        ->join("product", "posts.product_id", "=", "product.id")
        ->where([
            ['transactions.type', '=', 'out'],
            ['transactions.status', '=', 'APPROVED'],
            ['users.wilayah_id', '=', $user->wilayah_id],
        ])
        ->whereDate('transactions.created_at', $date)
        ->get();

        return view('content.home.petugas.index', compact('date','reedemhariini','transaksihariini','transaksirupiah','stocks','user','reedems','prodreedems'));

    }

	public function detail($id)
    {
        date_default_timezone_set('Asia/Jakarta');

    	$postnews = Posts::select("posts.*","company.photo","wilayah.name as wilayah_name","regencies.name as regency_name","wilayah.id as wilayah_id","wilayah.alamat","wilayah.uuid","product.name as prod_name","product.id as prod_id","product.img as prod_img")
        ->leftJoin("users", "posts.user_id", "=", "users.id")
        ->leftJoin("wilayah", "users.wilayah_id", "=", "wilayah.id")
        ->leftJoin("regencies", "wilayah.regency_id", "=", "regencies.id")
        ->leftJoin("company", "wilayah.company_id", "=", "company.id")
        ->leftJoin("product", "posts.product_id", "=", "product.id")
		->where("posts.id", $id)
		->first();

        $user = Auth::user();

        $userid = $user->id;

        $cekfav = Favorite::where([
            ['user_id', '=', $user->id],
            ['post_id', '=', $id],
        ])
        ->first();

        $postid = $id;

        $tour = Tours::where("user_id", $user->id)
        ->first();

        $sudahtour = Tours::where(['user_id'=>$user->id])
        ->update(['detailprod'=>'1']);

        $service = Services::where('type', 'midtrans')
            ->first();

        if($user->pemegangsaham == 'yes'){

            $pemegangsaham = Services::where('type', 'pemegangsaham')
            ->first();

            $diskon = $pemegangsaham->biaya;

        } else {

            $diskon = 0;

        }

        $toko = Posts::select("wilayah.*")
        ->join("users", "posts.user_id", "=", "users.id")
        ->join("wilayah", "users.wilayah_id", "=", "wilayah.id")
        ->where("posts.id", $id)
        ->first();

		return view('content.home.users.detail', compact('postnews','cekfav','userid','postid','tour','service','diskon','toko'));

    }

    public function kategori(Request $request)
    {

        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d');

        $user = Auth::user();

          $products = Posts::select("posts.product_id")
          ->leftJoin("users", "posts.user_id", "=", "users.id")
          ->leftJoin("wilayah", "users.wilayah_id", "=", "wilayah.id")
          ->leftJoin("regencies", "wilayah.regency_id", "=", "regencies.id")
          ->leftJoin("product", "posts.product_id", "=", "product.id")
          ->where([
              ["wilayah.id", $user->wilayah_id],
              ["posts.active", "Y"],
              ['wilayah.active', '=', "Y"],
              ['posts.kategori_id', '=', $request->id],
              ['posts.type', '=', 'Products'],
          ])
          ->orderBy('posts.id', 'desc')
          ->groupBy("posts.product_id")
          ->get();

        // $cekfav = Favorite::where([
        //     ['user_id', '=', $user->id],
        //     ['post_id', '=', $id],
        // ])
        // ->first();

        $kategori = Kategori::where("id", $request->id)
        ->first();

        $iduser = $user->id;

        $wilayahid = $user->wilayah_id;

        $service = Services::first();

        return view('content.kategori.users', compact('products','kategori','iduser','wilayahid','service'));

    }

    public function deals()
    {
    	date_default_timezone_set('Asia/Jakarta');
		$date = date('Y-m-d');

		$user = Auth::user();

        $postdeals = Saldo::select("posts.name","posts.id","posts.sampai","imgpost.name as imgname","wilayah.name as wilayah_name")
        ->join("posts", "posts.id", "=", "saldo.post_id")
        ->join("post_images", "posts.id", "=", "post_images.post_id")
        ->join("imgpost", "post_images.img_id", "=", "imgpost.id")
        ->join("users", "posts.user_id", "=", "users.id")
        ->join("wilayah", "users.wilayah_id", "=", "wilayah.id")
        ->groupBy("posts.name","posts.id","posts.sampai","imgpost.name","wilayah.name")
        ->where([
            ['saldo.user_id', '=', $user->id],
            ['posts.type', '=', 'Deals'],
            ['posts.sampai', '>=', $date],
        ])
        ->orderBy("saldo.id", "desc")
        ->get();

        $userID = $user->id;

        $pastdeals = Saldo::select("posts.name","posts.id","posts.sampai")
        ->join("posts", "posts.id", "=", "saldo.post_id")
        ->groupBy("posts.name","posts.id","posts.sampai")
        ->where([
            ['saldo.user_id', '=', $user->id],
            ['posts.type', '=', 'Deals'],
            ['posts.sampai', '<=', $date],
        ])
        ->orderBy("saldo.id", "desc")
        ->get();

        $saldosum = DB::table('saldo')
        ->leftJoin("posts", "posts.id", "=", "saldo.post_id")
        ->where([
            ['saldo.user_id', '=', $user->id],
            ['posts.type', '=', 'Deals'],
            ['posts.sampai', '>=', $date],
        ])
        ->sum('saldo.sisa');

		return view('content.deals.index', compact('date','postdeals','pastdeals','userID','saldosum'));
    }

    public function myproducts()
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d');

        $user = Auth::user();

        $postings = Saldo::select("posts.name","posts.id","wilayah.name as wilayah_name","posts.harga_act","posts.deliver","posts.po","product.name as prod_name")
        ->join("posts", "posts.id", "=", "saldo.post_id")
        ->join("product", "posts.product_id", "=", "product.id")
        ->join("users", "posts.user_id", "=", "users.id")
        ->join("wilayah", "users.wilayah_id", "=", "wilayah.id")
        ->distinct()
        ->where([
            ['saldo.user_id', '=', $user->id],
            ['saldo.status', '=', null],
        ])
        ->orderBy("saldo.id", "desc")
        ->get();

        foreach ($postings as $posting) {

            $saldos = DB::table('saldo')
            ->where([
                ['user_id', '=', $user->id],
                ['post_id', '=', $posting->id]
            ])
            ->orderBy('id', 'desc')
            ->first();
            
            $tanggals = date('Y-m-d', strtotime('+15 day', strtotime($saldos->created_at)));
            $tgl = strtotime($tanggals);
            $hariini = time();

            $diff   = $tgl - $hariini;

            if(floor($diff / (60 * 60 * 24)) < 0){

                $tokens = Saldo::where(['post_id'=>$posting->id])
                ->update(['status'=>'KADALUARSA']);

                $keranjangreedem = ReedemKeranjang::where('saldo_id', $saldos->id)
                ->delete();

            }

        }

        $postdeals = Saldo::select("posts.name","posts.id","posts.img as imgname","wilayah.name as wilayah_name","posts.harga_act","posts.deliver","posts.po","product.name as prod_name")
        ->leftJoin("posts", "posts.id", "=", "saldo.post_id")
        ->leftJoin("product", "posts.product_id", "=", "product.id")
        ->leftJoin("users", "posts.user_id", "=", "users.id")
        ->leftJoin("wilayah", "users.wilayah_id", "=", "wilayah.id")
        ->distinct()
        ->where([
            ['saldo.user_id', '=', $user->id],
            ['saldo.status', '=', null],

        ])
        ->orderBy("saldo.id", "desc")
        ->get();

        $saldosum = DB::table('saldo')
        ->leftJoin("posts", "posts.id", "=", "saldo.post_id")
        ->where([
            ['saldo.user_id', '=', $user->id],
            
        ])
        ->sum('saldo.sisa');


        $userID = $user->id;

        $service = Services::first();

        return view('content.myproducts.index', compact('date','postdeals','userID','saldosum','service'));
    }

    public function challanges()
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d');

        $user = Auth::user();

        $postchallanges = Posts::select("posts.*","imgpost.name as imgname","wilayah.name as wilayah_name","regencies.name as regency_name")
        ->join("post_images", "posts.id", "=", "post_images.post_id")
        ->join("imgpost", "post_images.img_id", "=", "imgpost.id")
        ->join("users", "posts.user_id", "=", "users.id")
        ->join("wilayah", "users.wilayah_id", "=", "wilayah.id")
        ->join("regencies", "wilayah.regency_id", "=", "regencies.id")
        ->where([
            ['sampai', '>=', $date],
            ['type', '=', 'Challange']
        ])
        ->orderBy('posts.id', 'desc')
        ->get();

        $postberjalans = ChallangeJoins::select("posts.*","imgpost.name as imgname","challange_joins.id as join_id")
        ->leftJoin("posts", "challange_joins.post_id", "=", "posts.id")
        ->leftJoin("post_images", "posts.id", "=", "post_images.post_id")
        ->leftJoin("imgpost", "post_images.img_id", "=", "imgpost.id")
        ->where([
            ['sampai', '>=', $date],
            ['type', '=', 'Challange'],
            ['challange_joins.user_id', '=', $user->id],
            ['challange_joins.status', '=', NULL]

        ])
        ->orderBy('posts.id', 'desc')
        ->get();

        $userid = $user->id;

        $rewards = SaldoRewards::select("saldo_rewards.product_id","product.name")
        ->leftJoin("challange_joins", "saldo_rewards.join_id", "=", "challange_joins.id")
        ->leftJoin("product", "saldo_rewards.product_id", "=", "product.id")
        ->groupBy("saldo_rewards.product_id","product.name")
        ->where("saldo_rewards.user_id", $user->id)
        ->get();

        return view('content.challange.index', compact('date','postchallanges','postberjalans','rewards','userid'));
    }

    public function challangedetails($id)
    {

        $postnews = Posts::select("posts.*","imgpost.name as imgname","company.photo","wilayah.name as wilayah_name","regencies.name as regency_name","wilayah.id as wilayah_id")
        ->join("post_images", "posts.id", "=", "post_images.post_id")
        ->join("imgpost", "post_images.img_id", "=", "imgpost.id")
        ->join("users", "posts.user_id", "=", "users.id")
        ->join("wilayah", "users.wilayah_id", "=", "wilayah.id")
        ->join("regencies", "wilayah.regency_id", "=", "regencies.id")
        ->join("company", "wilayah.company_id", "=", "company.id")
        ->where("posts.id", $id)
        ->first();

        $user = Auth::user();

        $userid = $user->id;

        $postproducts = PostDetails::select("product.name","post_details.qty")
        ->join("product", "post_details.product_id", "=", "product.id")
        ->where("post_details.post_id", $id)
        ->get();

        $postareas = PostAreas::select("wilayah.*")
        ->join("wilayah", "post_areas.wilayah_id", "=", "wilayah.id")
        ->where("post_areas.post_id", $id)
        ->get();

        $postrewards = PostRewards::select("product.name","post_rewards.qty")
        ->join("product", "post_rewards.product_id", "=", "product.id")
        ->where("post_rewards.post_id", $id)
        ->get();

        $postid = $id;

        return view('content.challange.detail', compact('postnews','postareas','postproducts','postareas','userid','postid','postrewards'));

    }

    public function ikutchallanges(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d');

        $user = Auth::user();

        $ada = ChallangeJoins::where([
            ['user_id', '=', $user->id],
            ['post_id', '=', $request->id],
            ['status', '=', NULL],
        ])
        ->first();

        if(!$ada){

            $challanges = new ChallangeJoins();
            $challanges->user_id = $user->id;
            $challanges->post_id = $request->id;
            $challanges->save();

            $details = PostDetails::where("post_id", $request->id)
            ->get();

            foreach($details as $detail){

                $proses = new ChallangeProses();
                $proses->join_id = $challanges->id;
                $proses->product_id = $detail->product_id;
                $proses->amount = '0';
                $proses->target = $detail->qty;
                $proses->save();

            }    

            $data = '0';

        } else {

            $data = '1';
        }

        return response()->json($data);

    }

    public function dealdetails($id)
    {
    	date_default_timezone_set('Asia/Jakarta');
		$date = date('Y-m-d');

    	$user = Auth::user();

    	$paket = Posts::select("posts.*", "wilayah.name as wilayah_name")
        ->join("users", "posts.user_id", "=", "users.id")
        ->join("wilayah", "users.wilayah_id", "=", "wilayah.id")
        ->where("posts.id", $id)
    	->first();

    	$saldos = Saldo::select("saldo.user_id","saldo.post_id","saldo.product_id")
    	->where([
            ['saldo.user_id', '=', $user->id],
            ['saldo.post_id', '=', $id],
        ])
        ->distinct()
        ->get();

        return view('content.deals.detail', compact('date','saldos','paket'));

    }

    public function gettoken(Request $request)
    { 

    	$user = Auth::user();

        $tokens = Users::where(['id'=>$user->id])
        ->update(['fcm_token'=>$request->fcmtoken]);

        $arrayNames = array(    
            'actions' => 'Berhasil',
        );

        return response()->json($arrayNames);

    }

    public function validasitoken(Request $request)
    { 

        $user = Auth::user();

        $token = Users::where("id", $user->id)
        ->first();

        if($token->token != null){

            if($token->token == $request->token){
                $data = '1';
            } else {
                $data = '2';
            }
        } else {

            $data = '0';

        }


        return response()->json($data);

    }

    public function getcountmessages(Request $request)
    { 

    	$user = Auth::user();

        $msg = SendNotif::where([
            ['user_id', '=', $user->id],
            ['flag', '=', 'd'],
        ])
        ->count();

        return response()->json($msg);

    }

    public function home()
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d');

        $productnews = Posts::select("posts.*","imgpost.name as imgname","regencies.name as regency_name", "wilayah.name as wilayah_name","wilayah.id as wilayah_id")
        ->leftJoin("post_images", "posts.id", "=", "post_images.post_id")
        ->leftJoin("imgpost", "post_images.img_id", "=", "imgpost.id")
        ->leftJoin("users", "posts.user_id", "=", "users.id")
        ->leftJoin("wilayah", "users.wilayah_id", "=", "wilayah.id")
        ->leftJoin("regencies", "wilayah.regency_id", "=", "regencies.id")
        ->where('type', '=', 'Products')
        ->orWhere([
            ['sampai', '>=', $date],
            ['type', '=', 'Deals'],
        ])
        ->orderBy('posts.id', 'desc')
        ->get();

        $companies = Wilayah::select("wilayah.*", "company.photo","regencies.name as regency_name")
        ->join("company", "wilayah.company_id", "=", "company.id")
        ->join("regencies", "wilayah.regency_id", "=", "regencies.id")
        ->orderBy('id', 'desc')
        ->limit(8)
        ->get();

        $provinces = Province::all();

        return view('content.home.index', compact('date','companies','productnews','provinces'));

    }

    public function homedetail($id)
    {

        $postnews = Posts::select("posts.*","imgpost.name as imgname","company.photo","wilayah.name as wilayah_name","regencies.name as regency_name","wilayah.id as wilayah_id","wilayah.alamat")
        ->join("post_images", "posts.id", "=", "post_images.post_id")
        ->join("imgpost", "post_images.img_id", "=", "imgpost.id")
        ->join("users", "posts.user_id", "=", "users.id")
        ->join("wilayah", "users.wilayah_id", "=", "wilayah.id")
        ->join("regencies", "wilayah.regency_id", "=", "regencies.id")
        ->join("company", "wilayah.company_id", "=", "company.id")
        ->where("posts.id", $id)
        ->first();

        $postproducts = PostDetails::select("product.name","post_details.qty")
        ->join("product", "post_details.product_id", "=", "product.id")
        ->where("post_details.post_id", $id)
        ->get();

        $postid = $id;

        $diskusis = Diskusi::select("diskusi.*","users.name as user_name")
        ->join("users", "diskusi.user_id", "=", "users.id")
        ->where("post_id", $id)
        ->orderBy("diskusi.id", "desc")
        ->limit(5)
        ->get();

        return view('content.home.detail', compact('postnews','postproducts','cekfav','postareas','userid','postid','diskusis'));

    }

    public function homekategori($id)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d');
        
        $postnews = Posts::select("posts.id")
        ->select("posts.*","imgpost.name as imgname","regencies.name as regency_name", "wilayah.name as wilayah_name","wilayah.id as wilayah_id")
        ->leftJoin("post_images", "posts.id", "=", "post_images.post_id")
        ->leftJoin("imgpost", "post_images.img_id", "=", "imgpost.id")
        ->leftJoin("users", "posts.user_id", "=", "users.id")
        ->leftJoin("wilayah", "users.wilayah_id", "=", "wilayah.id")
        ->leftJoin("regencies", "wilayah.regency_id", "=", "regencies.id")
        ->where([
            ['type', '=', 'Products'],
            ['kategori_id', '=', $id],
        ])
        ->orWhere([
            ['sampai', '>=', $date],
            ['type', '=', 'Deals'],
            ['kategori_id', '=', $id],
        ])
        ->orderBy('posts.id', 'desc')
        ->get();

        $kategori = Kategori::where('id', $id)
        ->first();

        $postproducts = PostDetails::select("product.name","post_details.qty")
        ->join("product", "post_details.product_id", "=", "product.id")
        ->where("post_details.post_id", $id)
        ->get();

        return view('content.kategori.home', compact('postnews','postproducts','kategori'));

    }

    public function followcompany(Request $request)
    { 
        date_default_timezone_set('Asia/Jakarta');

        $user = Auth::user();

        $follow = new Follow();
        $follow->user_id = $user->id;
        $follow->wilayah_id = $request->id;
        $follow->save();

        return response()->json($follow);

    }

    public function unfollowcompany(Request $request)
    { 
        date_default_timezone_set('Asia/Jakarta');

        $user = Auth::user();

        $del = Follow::where([
            ['user_id', '=', $user->id],
            ['wilayah_id', '=', $request->id],
        ])
        ->delete();

        return response()->json($del);

    }

    public function tambahdiskusi(Request $request)
    { 
        date_default_timezone_set('Asia/Jakarta');
        $user = Auth::user();

        $nambah = new Diskusi();
        $nambah->user_id = $user->id;
        $nambah->post_id = $request->post_id;
        $nambah->desc = $request->desc;
        $nambah->read = '0';
        $nambah->save();

        $getuser = Users::where("id", $user->id)
        ->first();

        $getprinciple = Users::select("fcm_token")
        ->join("posts", "users.id", "=", "posts.user_id")
        ->where([
            ['posts.id', '=', $request->post_id],
        ])
        ->first();

        $getpost = Posts::where("id", $request->post_id)
        ->first();

        $arrayNames = array(    
            'actions' => 'Berhasil',
            'namauser' => $getuser->name,
            'namapost' => $getpost->name,
            'tokenprinciple' => $getprinciple->fcm_token
        );

        return response()->json($arrayNames);

    }

    public function balasdiskusi(Request $request)
    { 
        date_default_timezone_set('Asia/Jakarta');
        $user = Auth::user();

        $balasan = new Komentar();
        $balasan->user_id = $user->id;
        $balasan->diskusi_id = $request->diskusi_id;
        $balasan->desc = $request->desc;
        $balasan->read = '0';
        $balasan->save();

        $updatereads = Diskusi::where(['id'=>$request->diskusi_id])
        ->update(['read'=>'0']);

        $getuser = Users::where("id", $user->id)
        ->first();

        $getdiskusi = Diskusi::where("id", $request->diskusi_id)
        ->first();

        if($getuser->role_id == '4'){

            // $getprinciple = Users::select("fcm_token")
            // ->join("user_companies", "users.id", "=", "user_companies.user_id")
            // ->join("posts", "user_companies.company_id", "=", "posts.company_id")
            // ->where([
            //     ['posts.id', '=', $getdiskusi->post_id],
            //     ['users.role_id', '=', '2'],
            // ])
            // ->first();

            $getprinciple = Users::select("fcm_token")
            ->join("posts", "users.id", "=", "posts.user_id")
            ->where([
                ['posts.id', '=', $getdiskusi->post_id],
            ])
            ->first();

        } else {

            $getprinciple = Users::select("fcm_token")
            ->join("diskusi", "users.id", "=", "diskusi.user_id")
            ->where("diskusi.post_id", $getdiskusi->post_id)
            ->first();
        }


        $getpost = Posts::where("id", $getdiskusi->post_id)
        ->first();

        $arrayNames = array(    
            'actions' => 'Berhasil',
            'namauser' => $getuser->name,
            'namapost' => $getpost->name,
            'tokenprinciple' => $getprinciple->fcm_token
        );

        return response()->json($arrayNames);

    }


    public function rewards()
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d');

        $user = Auth::user();

        return view('content.rewards.index', compact('date'));
    }

    public function countsaldo()
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d');

        $user = Auth::user();

        $postings = Saldo::select('saldo.user_id','post_id','saldo.product_id')
        ->join("posts", "posts.id", "=", "saldo.post_id")
        ->distinct()
        ->where([
            ['saldo.user_id', '=', $user->id],
            ['saldo.status', '=', null],
        ])
        ->orderBy("saldo.id", "desc")
        ->get();

        $numb = 0;
        $tes = null;
        foreach($postings as $posting){

            $saldos = Saldo::where([
                ['user_id', '=', $user->id],
                ['post_id', '=', $posting->post_id],
                ['status', '=', null]
            ])
            ->orderBy('id', 'desc')
            ->first();

            $reedemss = ReedemKeranjang::where('saldo_id', $saldos->id)
            ->first();

            if(!$reedemss){

                if($saldos->sisa == 0){
                    $numb += 0;

                } else {
                    $numb += 1;

                }

            } else {
                $numb += 0;
            }

            
        }

        return response()->json($numb);
    }

    public function counthome()
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d');

        $user = Auth::user();

        $reedems = Transaksi::where([
            ['user_id', '=', $user->id],
            ['status', '=', 'REEDEM'],
        ])
        ->orderBy("transactions.id","desc")
        ->count();

        return response()->json($reedems);
    }

    public function guides()
    {
        $user = Auth::user()->guide;

        return response()->json($user);

    }

    public function guideselesai()
    {
        date_default_timezone_set('Asia/Jakarta');
        $user = Auth::user();

        $profileupdates = Users::findOrFail($user->id);
        $profileupdates->guide = '1';
        $profileupdates->save();

        return response()->json($profileupdates);

    }

    public function pengaturanselesai(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $user = Auth::user();

        $profileupdates = Users::findOrFail($user->id);
        $profileupdates->ktp = $request->ktp;
        $profileupdates->token = $request->pin;
        $profileupdates->no_hp = $request->nohp;
        $profileupdates->save();

        return response()->json($profileupdates);

    }

    public function listpengambilan(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d');

        $user = Auth::user();

        $wilayah = Wilayah::where("id", $user->wilayah_id)
        ->first();

        $ambillokasi = Transaksi::select("transactions.*","orders.amount") 
        ->join("orders", "transactions.id", "=", "orders.transaction_id")
        ->where([
            ['type', '=', 'in'],
            ['alamat_id', '=', null],
            ['transactions.status', '=', 'APPROVED'],
            ['transactions.wilayah_id', '=', $user->wilayah_id],
        ])
        ->whereDate('transactions.created_at', '>=', $request->dari)
        ->whereDate('transactions.created_at', '<=', $request->sampai)
        ->get();

        $delivery = Transaksi::select("transactions.*","orders.amount")
        ->join("orders", "transactions.id", "=", "orders.transaction_id")
        ->where([
            ['type', '=', 'in'],
            ['alamat_id', '!=', null],
            ['transactions.status', '=', 'APPROVED'],
            ['transactions.wilayah_id', '=', $user->wilayah_id],
        ])
        ->whereDate('transactions.created_at', '>=', $request->dari)
        ->whereDate('transactions.created_at', '<=', $request->sampai)
        ->get();

        $dari = $request->dari;
        $sampai = $request->sampai;

        return view('content.home.petugas.list', compact('wilayah','ambillokasi','dari','sampai','delivery'));

    }

    public function saldoadd()
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d');

        $user = Auth::user();

        $saldos = SaldoTrans::select("saldo_trans.*","users.name as user_name")
        ->join("users", "saldo_trans.user_id", "=", "users.id")
        ->where('saldo_trans.type', '=', 'in')
        ->get();

        return view('content.saldo.add', compact('date','saldos'));
    }

    public function saldousers(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $user = Auth::user();

        if ($request->has('q')) {
            $cari = $request->q;
            $data = Users::select('id', 'name','email')
            ->where([
                ['role_id', '=', 4],
                ['name', 'LIKE', '%'.$cari.'%'],
            ])
            ->get();

            return response()->json($data);
        }

    }

    public function saldostore(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $user = Auth::user();
        $dates = date('d');

        $uuid = Uuid::generate();
        $code = substr($uuid,0,8);

        $trans = new SaldoTrans();
        $trans->uuid = $code.$dates;
        $trans->user_id = $request->users;
        $trans->petugas_id = $user->id;
        $trans->type = 'in';
        $trans->amount = $request->nominal;
        $trans->save();

        $adasaldo = SaldoUang::where("user_id", $request->users)
        ->orderBy("id", "desc")
        ->first();

        $sald = new SaldoUang();
        $sald->user_id = $request->users;
        $sald->saldotrans_id = $trans->id;
        
        if(!$adasaldo){

            $sald->before = '0';
            $sald->sisa = $request->nominal;

        } else {

            $sald->before = $adasaldo->sisa;
            $sald->sisa = $request->nominal + $adasaldo->sisa;

        }
        
        $sald->save();

        $cekusers = Users::where("id",$request->users)
        ->first();

        $validas = array(    
            'fcm_token' => $cekusers->fcm_token,
            'nama' => $cekusers->name,
        );

        return response()->json($validas);
    }

    public function saldohistory()
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d');

        $user = Auth::user();

        $adasaldo = SaldoUang::where("user_id", $user->id)
        ->orderBy("id", "desc")
        ->first();

        $saldos = SaldoUang::select("saldo_uang.*","saldo_trans.amount","saldo_trans.type")
        ->join("saldo_trans", "saldo_uang.saldotrans_id", "=", "saldo_trans.id")
        ->where('saldo_uang.user_id', '=', $user->id)
        ->orderBy("saldo_uang.id","desc")
        ->get();

        return view('content.saldo.history', compact('date','saldos','adasaldo'));
    }

    public function scanner()
    {

        return view('content.scanner.index');
    }

    public function scannerusers(Request $request)
    {
        $prod = $request->id;
        return view('content.scanner.users',compact('prod'));
    }

    public function petugastransaksihariini()
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d');

        $user = Auth::user();

        $ambillokasi = Transaksi::select("transactions.*","orders.amount","orders.type_bayar") 
        ->join("orders", "transactions.id", "=", "orders.transaction_id")
        ->where([
            ['type', '=', 'in'],
            ['alamat_id', '=', null],
            ['transactions.status', '=', 'APPROVED'],
            ['transactions.cash', '=', NULL],
            ['transactions.wilayah_id', '=', $user->wilayah_id],
        ])
        ->whereDate('transactions.updated_at', $date)
        ->get();

        $delivery = Transaksi::select("transactions.*","orders.amount","orders.type_bayar")
        ->join("orders", "transactions.id", "=", "orders.transaction_id")
        ->where([
            ['type', '=', 'in'],
            ['alamat_id', '!=', null],
            ['transactions.status', '=', 'APPROVED'],
            ['transactions.wilayah_id', '=', $user->wilayah_id],
        ])
        ->whereDate('transactions.updated_at', $date)
        ->get();

        return view('content.home.petugas.transaksi', compact('date','ambillokasi','delivery'));

    }

    public function petugastransaksihariinirupiah()
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d');

        $user = Auth::user();

        $trans = Transaksi::select("transactions.*","orders.amount") 
        ->join("orders", "transactions.id", "=", "orders.transaction_id")
        ->where([
            ['type', '=', 'in'],
            ['transactions.status', '=', 'APPROVED'],
            ['transactions.wilayah_id', '=', $user->wilayah_id],
        ])
        ->whereDate('transactions.updated_at', $date)
        ->get();

        return view('content.home.petugas.transaksirupiah', compact('date','trans'));

    }

    public function petugaslihattransaksi(Request $request)
    {
        $trans = Transaksi::select("transactions.*","users.name as username","orders.delivery","orders.delivery_name","orders.delivery_type","alamat.penerima","alamat.alamat","alamat.judul","orders.amount")
        ->join("users", "transactions.user_id", "=", "users.id")  
        ->join("orders", "transactions.id", "=", "orders.transaction_id") 
        ->leftJoin("alamat", "transactions.alamat_id", "=", "alamat.id") 
        ->where("transaction_id", $request->id)
        ->first();

        $details = TransaksiDetails::select("posts.name as post_name","product.name as prod_name","transaction_details.qty","posts.id as post_id")
        ->join("transactions", "transaction_details.transaction_id", "=", "transactions.id") 
        ->join("posts", "transaction_details.post_id", "=", "posts.id")  
        ->join("product", "posts.product_id", "=", "product.id")
        ->where("transaction_id", $request->id)
        ->get();

        $potongan = Order::select("vouchers.amount","vouchers.percent")
        ->leftJoin("voucher_details", "orders.voucherdet_id", "=", "voucher_details.id")
        ->leftJoin("vouchers", "voucher_details.voucher_id", "=", "vouchers.id")
        ->where("transaction_id", $request->id)
        ->where("voucherdet_id", '!=', NULL)
        ->first();

         return view('content.home.petugas.detail', compact('trans','details','potongan'));

    }

    public function petugasretur()
    {
        $user = Auth::user();

        $trans = TransactionRetur::select("transactions.uuid","transactions.created_at","transaction_retur.status","transactions.id")
        ->join("transactions", "transaction_retur.transaction_id", "=", "transactions.id") 
        ->where([
            
            ['transactions.wilayah_id', '=', $user->wilayah_id],
        ])
        ->get();

        return view('content.home.petugas.retur', compact('trans'));
    }

    public function petugasreturdetail(Request $request)
    {   
        $trans = Transaksi::select("transactions.*","orders.type_bayar","regencies.name as regency_name","provinces.name as prov_name","regencies.postal_code","districts.name as district_name","alamat.penerima","alamat.nohp","alamat.alamat","orders.jam","orders.delivery_name","orders.delivery_type")
        ->leftJoin("orders", "transactions.id", "=", "orders.transaction_id")
        ->leftJoin("alamat", "transactions.alamat_id", "=", "alamat.id")
        ->leftJoin("districts", "alamat.district_id", "=", "districts.id")
        ->leftJoin("regencies", "districts.regency_id", "=", "regencies.id")
        ->leftJoin("provinces", "regencies.province_id", "=", "provinces.id")
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

        $jenis = 'Pembelian';

        $saldos = OrderDetails::select("posts.*","order_details.qty","order_details.amount","transactions.id as trans_id","orders.amount as total","transactions.status","product.name as prod_name","orders.delivery as delivery","orders.delivery_name","orders.delivery_type")
        ->leftJoin("orders", "order_details.order_id", "=", "orders.id")
        ->leftJoin("transactions", "orders.transaction_id", "=", "transactions.id")
        ->leftJoin("posts", "order_details.post_id", "=", "posts.id")
        ->leftJoin("product", "posts.product_id", "=", "product.id")
        ->where("transactions.uuid", $request->uuid)
        ->get();

        $tour = Tours::where("user_id", $user->id)
        ->first();

        $sudahtour = Tours::where(['user_id'=>$user->id])
        ->update(['transdetail'=>'1']);

        $retur = TransactionRetur::where("transaction_id", $trans->id)
        ->first();

        return view('content.home.petugas.returdetail', compact('saldos','jenis','trans','wilayah','tour','service','retur'));

    }

    public function petugasreturupdate(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $user = Auth::user();

        if($request->type == "tolak"){
            $status = "DITOLAK";
        } else {
            $status = "SETUJU";
        }

        $sudahtour = TransactionRetur::where(['transaction_id'=>$request->id])
        ->update(['status'=>$status, 'ketadmin'=>$request->ket]);

        return response()->json($sudahtour);
    }

    public function bannerdetail(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $usernyah = Auth::user();


        if(!$usernyah){
            $user = Users::where("email", substr(csrf_token(),0,7).'@gmail.com')
            ->first();
        } else {
            $user = Auth::user();
        }

        $banner = Banners::where("id", $request->id)
        ->first();

        return view('content.banner.index', compact('banner','user'));
    }

}
