<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Favorite;
use App\Users;
use App\Follow;
use App\UserDaerah;
use App\Wilayah;
use App\Company;
use App\Posts;
use App\Services;
use App\Product;
use App\PostDetails;
use App\Kategori;
use App\Transaksi;
use App\WSTransaksi;
use App\Tours;
use App\Alamat;
use App\SaldoUang;
use App\Keranjang;
use App\Delivery;
use App\Order;
use App\Jarak;
use App\Shipper;
use App\OrderDetails;
use App\TransaksiDetails;
use App\SaldoTrans;
use App\TransactionDelivery;
use App\Temporary;
use App\Verifikasi;
use App\DiskonDetails;
use App\KurirLocal;
use App\VoucherDetails;
use Auth;
use DB;
use Mail;
use Uuid;
use Image;
use Validator;
use GuzzleHttp\Client;


class XhomeController extends Controller
{
    private static $hostUrl = 'https://api.biteship.com';
    private static $client;

    public function __construct(){
        self::$client = new \GuzzleHttp\Client;
    }

    public function index()
    {
    	$user = Auth::user();

        $iduser = $user->id;

        $wilayahid = $user->wilayah_id;

        $roles = Users::select("role_id")
        ->where("id", $user->id)
        ->first();

        $ada = Follow::where("user_id", $iduser)
        ->count();

        $kategori = Kategori::where("type","delivery")
        ->get();

        $saldouang = SaldoUang::where("user_id", $user->id)
        ->orderBy("id", "desc")
        ->first();

        $service = Services::first();

        $wilayahs = Wilayah::where("active", "Y")
        ->limit(6)
        ->get();

        $cekada = Temporary::where('session_id', csrf_token())
        ->first();

        if($cekada){
            $hapus = Temporary::where('id', $cekada->id)
            ->delete();
        }

        return view('xhome.home.index', compact('iduser','wilayahid','kategori','service','saldouang','wilayahs'));

	}

	public function wilayah(Request $request)
    {
    	date_default_timezone_set('Asia/Jakarta');
		$date = date('Y-m-d');

		$companyproducts = Posts::select("posts.*","wilayah.name as wilayah_name","regencies.name as regency_name","wilayah.id as wilayah_id","wilayah.uuid","product.name as prod_name","product.img as prod_img")
        ->join("users", "posts.user_id", "=", "users.id")
        ->join("wilayah", "users.wilayah_id", "=", "wilayah.id")
        ->join("regencies", "wilayah.regency_id", "=", "regencies.id")
         ->join("product", "posts.product_id", "=", "product.id")
        ->where([
            ['posts.type', '=', 'Delivery'],
            ['wilayah.uuid', '=', $request->id],
            ['posts.active', '=', 'Y'],
        ])
		->get();

		$user = Auth::user();

		$iduser = $user->id;

        $wilayah = Wilayah::where('uuid',$request->id)
        ->first();

		$wilayah_id = $wilayah->id;

		$companies = Company::select("wilayah.alamat","wilayah.name","company.photo","regencies.name as regency_name")
		->join("wilayah", "company.id", "=", "wilayah.company_id")
		->join("regencies", "wilayah.regency_id", "=", "regencies.id")
		->where("wilayah.uuid", $request->id)
		->first();

		$countfollow = Follow::join("wilayah", "follow.wilayah_id", "=", "wilayah.id")
        ->where("wilayah.uuid", $request->id)
		->count();

		$countprod = Posts::select("product.id")
		->join("users", "posts.user_id", "=", "users.id")
        ->join("wilayah", "users.wilayah_id", "=", "wilayah.id")
        ->join("product", "posts.product_id", "=", "product.id")
		->where([
            ['type', '=', 'Delivery'],
            ['wilayah.uuid', '=', $request->id],
            ['posts.active', '=', 'Y'],
        ])
        ->distinct()
		->get();

		$kategori = Kategori::where("type", "delivery")->get();

		return view('xhome.wilayah.index', compact('companyproducts','companies','iduser','countfollow','countprod','wilayah_id','kategori','wilayah'));

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
              ["wilayah.uuid", $request->wilayah],
              ["posts.active", "Y"],
              ['wilayah.active', '=', "Y"],
              ['posts.kategori_id', '=', $request->id],
              ['posts.type', '=', 'Delivery'],
          ])
          ->orderBy('posts.id', 'desc')
          ->distinct()
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

        // $postproducts = PostDetails::select("product.name","post_details.qty")
        // ->join("product", "post_details.product_id", "=", "product.id")
        // ->where("post_details.post_id", $id)
        // ->get();

        $service = Services::first();

        return view('xhome.wilayah.kategori', compact('products','kategori','iduser','wilayahid','service'));

    }

    public function cari(Request $request)
    {

        $produk = Posts::select("posts.*","wilayah.name as wilayah_name","regencies.name as regency_name","wilayah.id as wilayah_id","wilayah.uuid","product.name as prod_name","product.img as prod_img")
        ->join("users", "posts.user_id", "=", "users.id")
        ->join("wilayah", "users.wilayah_id", "=", "wilayah.id")
        ->join("regencies", "wilayah.regency_id", "=", "regencies.id")
        ->join("product", "posts.product_id", "=", "product.id")
        ->where([
            ['posts.type', '=', 'Delivery'],
            ['wilayah.id', '=', $request->outletid],
            ['product.name', 'like', '%'.$request->produk.'%'],
            ['posts.active', '=', 'Y'],
        ])
        ->get();

        return response()->json($produk);


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

        $cekfav = Favorite::where([
            ['user_id', '=', $user->id],
            ['post_id', '=', $id],
        ])
        ->first();

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

		return view('xhome.home.detail', compact('postnews','postproducts','cekfav','userid','postid','tour','service'));

    }

    public function masukkeranjang(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');

        $user = Auth::user();

        $ada = Keranjang::where([
            ['user_id', '=', $user->id],
            ['post_id', '=', $request->post_id],
        ])
        ->first();

        if(!$ada){
        	$qty = '1';

        	$keranjang = new Keranjang();
	        $keranjang->user_id = $user->id;
	        $keranjang->post_id = $request->post_id;
	        $keranjang->qty = $qty;
	        $keranjang->save();

        } else {
        	$qty = $ada->qty + 1;

        	 $keranjang = Keranjang::where(['user_id'=>$user->id,'post_id'=>$request->post_id])
                ->update(['qty'=>$qty]);
        }

        $keranjangnow = Keranjang::leftJoin("posts", "keranjang.post_id", "=", "posts.id")
        ->where([
            ['keranjang.user_id', '=', $user->id],
            ['posts.type', '=', 'Delivery'],
        ])
        ->count();
        
        return response()->json($keranjangnow);
    }

    public function deletekeranjang(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');

        $user = Auth::user();

        $ada = Keranjang::where("id", $request->id)
        ->delete();
        
        return response()->json($ada);
    }

    public function countkeranjang(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');

        $user = Auth::user();

		$ada = Keranjang::leftJoin("posts", "keranjang.post_id", "=", "posts.id")
        ->where([
            ['keranjang.user_id', '=', $user->id],
            ['posts.type', '=', 'Products'],
        ])
        ->count();
        
        return response()->json($ada);
    }

    public function counthistory(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');

        $user = Auth::user();

        $ada = Transaksi::where([
            ['user_id', '=', $user->id],
            ['alamat_id', '!=', NULL],
            ['status', '=', 'DIPROSES'],
        ])
        ->count();

        return response()->json($ada);
    }

    public function keranjang()
    {
    	date_default_timezone_set('Asia/Jakarta');
		$date = date('Y-m-d');

		$user = Auth::user();

		$kranjangs = Keranjang::select("wilayah.id","wilayah.name","regencies.name as regency_name")
		->leftJoin("posts", "keranjang.post_id", "=", "posts.id")
        ->leftJoin("users", "posts.user_id", "=", "users.id")
        ->leftJoin("wilayah", "users.wilayah_id", "=", "wilayah.id")
        ->leftJoin("regencies", "wilayah.regency_id", "=", "regencies.id")
        ->where([
            ['keranjang.user_id', '=', $user->id],
            ['voucherdet_id', '=', NULL],
            ['posts.type', '=', 'Delivery'],
        ])
        ->distinct()
		->get();

        $userdetails = Users::where('id', $user->id)
        ->first();

        $adatrans = Transaksi::where("user_id", $user->id)
        ->first();

		$ada = Keranjang::leftJoin("posts", "keranjang.post_id", "=", "posts.id")
        ->where([
            ['keranjang.user_id', '=', $user->id],
            ['posts.type', '=', 'Delivery'],
        ])
        ->count();

        $service = Services::first();

        $potongan = Keranjang::select('vouchers.*','voucher_details.kode','keranjang.id as kranjang_id')
        ->leftJoin("voucher_details", "keranjang.voucherdet_id", "=", "voucher_details.id")
        ->leftJoin("vouchers", "voucher_details.voucher_id", "=", "vouchers.id")
        ->where("user_id", $user->id)
        ->where([
            ['keranjang.user_id', '=', $user->id],
            ['voucherdet_id', '!=', NULL],
        ])
        ->first();

        $userid = $user->id;

		return view('xhome.keranjang.index', compact('date','kranjangs','ada','userdetails','adatrans','service','potongan','userid'));

    }

    public function checklist(Request $request)
    {
    	date_default_timezone_set('Asia/Jakarta');
		$date = date('Y-m-d');

		$prods = Keranjang::findOrFail($request->id);
        $prods->delivery = 'Y';
        $prods->save();

        return response()->json($prods);

    }

    public function nochecklist(Request $request)
    {
    	date_default_timezone_set('Asia/Jakarta');
		$date = date('Y-m-d');

		$prods = Keranjang::findOrFail($request->id);
        $prods->delivery = NULL;
        $prods->save();

        return response()->json($prods);

    }

    public function checklistall(Request $request)
    {
    	date_default_timezone_set('Asia/Jakarta');
		$date = date('Y-m-d');

		$countss = count($request->id);

        for($i=0; $i < $countss; $i++){

            $postdet = Keranjang::findOrFail($request->id[$i]);
            $postdet->delivery = 'Y';
            $postdet->save();

        }

        return response()->json($countss);

    }

    public function nochecklistall(Request $request)
    {
    	date_default_timezone_set('Asia/Jakarta');
		$date = date('Y-m-d');

		$countss = count($request->id);

        for($i=0; $i < $countss; $i++){

            $postdet = Keranjang::findOrFail($request->id[$i]);
            $postdet->delivery = NULL;
            $postdet->save();

        }

        return response()->json($countss);

    }

    public function totalkeranjang()
    {
    	date_default_timezone_set('Asia/Jakarta');
		$date = date('Y-m-d');
		$user = Auth::user();

		$totalnyas = Keranjang::select("keranjang.qty","posts.harga_act")
	    ->leftJoin("posts", "keranjang.post_id", "=", "posts.id")
	    ->leftJoin("users", "posts.user_id", "=", "users.id")
	    ->leftJoin("wilayah", "users.wilayah_id", "=", "wilayah.id")
	    ->leftJoin("regencies", "wilayah.regency_id", "=", "regencies.id")
	    ->leftJoin("product", "posts.product_id", "=", "product.id")
	    ->where([
	          ['keranjang.user_id', '=', $user->id],
	          ['voucherdet_id', '=', NULL],
	          ['posts.type', '=', 'Delivery'],
	          ['keranjang.delivery', '=', 'Y'],
	      ])
	      ->get();

	    $total=0;

	    foreach ($totalnyas as $t) {
	    	$total += $t->qty * $t->harga_act;
	    }

	    return response()->json($total);

    }

    public function delivery()
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d');

        $user = Auth::user();

        $alamat = Alamat::select("alamat.*","regencies.name as regency_name","regencies.postal_code","provinces.name as prov_name","districts.name as district_name")
        ->leftJoin("districts", "alamat.district_id", "=", "districts.id")
        ->leftJoin("regencies", "districts.regency_id", "=", "regencies.id")
        ->leftJoin("provinces", "regencies.province_id", "=", "provinces.id")
        ->where([
            ['user_id', '=', $user->id],
            ['utama', '=', 'yes'],
        ])
        ->first();

        $kranjangs = Keranjang::select("wilayah.*","wilayah.name","regencies.name as regency_name")
        ->leftJoin("posts", "keranjang.post_id", "=", "posts.id")
        ->leftJoin("users", "posts.user_id", "=", "users.id")
        ->leftJoin("wilayah", "users.wilayah_id", "=", "wilayah.id")
        ->leftJoin("regencies", "wilayah.regency_id", "=", "regencies.id")
        ->where([
            ['keranjang.user_id', '=', $user->id],
            ['voucherdet_id', '=', NULL],
            ['keranjang.delivery', '=', 'Y'],
        ])
        ->distinct()
        ->get();


        $userdetails = Users::where('id', $user->id)
        ->first();

        $adatrans = Transaksi::where("user_id", $user->id)
        ->first();

        $ada = Keranjang::leftJoin("posts", "keranjang.post_id", "=", "posts.id")
        ->where([
            ['keranjang.user_id', '=', $user->id],
        ])
        ->count();

        $service = Services::first();

        $potongan = Keranjang::select('vouchers.*','voucher_details.kode','keranjang.id as kranjang_id')
        ->leftJoin("voucher_details", "keranjang.voucherdet_id", "=", "voucher_details.id")
        ->leftJoin("vouchers", "voucher_details.voucher_id", "=", "vouchers.id")
        ->where("user_id", $user->id)
        ->where([
            ['keranjang.user_id', '=', $user->id],
            ['voucherdet_id', '!=', NULL],
        ])
        ->first();

        $userid = $user->id;

        $getharga = Keranjang::select("wilayah.*")
        ->leftJoin("posts", "keranjang.post_id", "=", "posts.id")
        ->leftJoin("users", "posts.user_id", "=", "users.id")
        ->leftJoin("wilayah", "users.wilayah_id", "=", "wilayah.id")
        ->leftJoin("regencies", "wilayah.regency_id", "=", "regencies.id")
        ->where([
            ['keranjang.user_id', '=', $user->id],
            ['voucherdet_id', '=', NULL],
            ['keranjang.delivery', '=', 'Y'],
        ])
        ->first();

        if($user->pemegangsaham == 'yes'){

            $pemegangsaham = Services::where('type', 'pemegangsaham')
            ->first();

            $diskon = $pemegangsaham->biaya;

        } else {

            $diskon = 0;

        }

        $kranjang22 = Keranjang::select("product.name as name", "posts.name as description","posts.harga_act as value","posts.length","posts.width","posts.height","posts.weight","keranjang.qty as quantity")
        ->leftJoin("posts", "keranjang.post_id", "=", "posts.id")
        ->leftJoin("product", "posts.product_id", "=", "product.id")
        ->where([
            ['keranjang.user_id', '=', $user->id],
            ['voucherdet_id', '=', NULL],
            ['keranjang.delivery', '=', 'Y'],
        ])
        ->get();

        $totalberat = 0;
        foreach($kranjang22 as $duadua){

            $totalberat += $duadua->weight;

        }

        if($totalberat > 20000){

            $banyak = 0;

        } else {

            $jayParsedAry2 = [
                "origin_latitude" => $getharga->lat, 
                "origin_longitude" =>  $getharga->long, 
                "destination_latitude" => $alamat->lat, 
                "destination_longitude" => $alamat->long, 
                "couriers" => "grab,gojek", 
                "items" =>
                    json_decode($kranjang22)
             ]; 


            $output = self::$client->request('POST', self::$hostUrl . '/v1/rates/couriers', [
                'headers' => [
                     'Content-Type'  => 'application/json',
                     'Authorization' => 'biteship_live.eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJuYW1lIjoiV2FydW5na29raSIsInVzZXJJZCI6IjYxMDc4ZmJjZmI3ZjM5NTYyZDI3ZTc5ZCIsImlhdCI6MTYzMDMwNzYwOX0.BcQMP-V3tWhXsytld67HxFrKgMOhm_4TeRVxTntyY1U',
                ],
                'json' => $jayParsedAry2,
            ]);

            $output = json_decode($output->getBody(), true);

            $banyak = count($output['pricing']);

        }

        return view('content.delivery.index', compact('date','kranjangs','ada','userdetails','adatrans','service','potongan','userid','alamat','output','diskon','banyak'));

    }

    public function kurirtoko()
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d');

        $user = Auth::user();

        $alamat = Alamat::select("alamat.*","regencies.name as regency_name","regencies.postal_code","provinces.name as prov_name","districts.name as district_name")
        ->leftJoin("districts", "alamat.district_id", "=", "districts.id")
        ->leftJoin("regencies", "districts.regency_id", "=", "regencies.id")
        ->leftJoin("provinces", "regencies.province_id", "=", "provinces.id")
        ->where([
            ['user_id', '=', $user->id],
            ['utama', '=', 'yes'],
        ])
        ->first();

        $kranjangs = Keranjang::select("wilayah.*","wilayah.name","regencies.name as regency_name")
        ->leftJoin("posts", "keranjang.post_id", "=", "posts.id")
        ->leftJoin("users", "posts.user_id", "=", "users.id")
        ->leftJoin("wilayah", "users.wilayah_id", "=", "wilayah.id")
        ->leftJoin("regencies", "wilayah.regency_id", "=", "regencies.id")
        ->where([
            ['keranjang.user_id', '=', $user->id],
            ['voucherdet_id', '=', NULL],
            ['keranjang.delivery', '=', 'Y'],
        ])
        ->distinct()
        ->get();


        $userdetails = Users::where('id', $user->id)
        ->first();

        $adatrans = Transaksi::where("user_id", $user->id)
        ->first();

        $ada = Keranjang::leftJoin("posts", "keranjang.post_id", "=", "posts.id")
        ->where([
            ['keranjang.user_id', '=', $user->id],
        ])
        ->count();

        $service = Services::first();

        $potongan = Keranjang::select('vouchers.*','voucher_details.kode','keranjang.id as kranjang_id')
        ->leftJoin("voucher_details", "keranjang.voucherdet_id", "=", "voucher_details.id")
        ->leftJoin("vouchers", "voucher_details.voucher_id", "=", "vouchers.id")
        ->where("user_id", $user->id)
        ->where([
            ['keranjang.user_id', '=', $user->id],
            ['voucherdet_id', '!=', NULL],
        ])
        ->first();

        $userid = $user->id;

        $getharga = Keranjang::select("wilayah.*")
        ->leftJoin("posts", "keranjang.post_id", "=", "posts.id")
        ->leftJoin("users", "posts.user_id", "=", "users.id")
        ->leftJoin("wilayah", "users.wilayah_id", "=", "wilayah.id")
        ->leftJoin("regencies", "wilayah.regency_id", "=", "regencies.id")
        ->where([
            ['keranjang.user_id', '=', $user->id],
            ['voucherdet_id', '=', NULL],
            ['keranjang.delivery', '=', 'Y'],
        ])
        ->first();

        if($user->pemegangsaham == 'yes'){

            $pemegangsaham = Services::where('type', 'pemegangsaham')
            ->first();

            $diskon = $pemegangsaham->biaya;

        } else {

            $diskon = 0;

        }

        $kranjang22 = Keranjang::select("product.name as name", "posts.name as description","posts.harga_act as value","posts.length","posts.width","posts.height","posts.weight","keranjang.qty as quantity")
        ->leftJoin("posts", "keranjang.post_id", "=", "posts.id")
        ->leftJoin("product", "posts.product_id", "=", "product.id")
        ->where([
            ['keranjang.user_id', '=', $user->id],
            ['voucherdet_id', '=', NULL],
            ['keranjang.delivery', '=', 'Y'],
        ])
        ->get();


        return view('content.delivery.kurirtoko', compact('date','kranjangs','ada','userdetails','adatrans','service','potongan','userid','alamat','diskon'));

    }

    public function favorite()
    {
    	date_default_timezone_set('Asia/Jakarta');
		$date = date('Y-m-d');

		$user = Auth::user();

        $iduser = $user->id;

		$favs = Favorite::select("posts.*","product.name as prod_name","wilayah.name as wilayah_name","regencies.name as regency_name","product.img as prod_img","wilayah.uuid")
		->leftJoin("posts", "favorite.post_id", "=", "posts.id")
        ->leftJoin("users", "posts.user_id", "=", "users.id")
        ->leftJoin("wilayah", "users.wilayah_id", "=", "wilayah.id")
        ->leftJoin("regencies", "wilayah.regency_id", "=", "regencies.id")
        ->leftJoin("product", "posts.product_id", "=", "product.id")
        ->where([
            ['favorite.user_id', '=', $user->id],
            ['posts.active', '=', 'Y'],
            ['posts.type', '=', 'Delivery'],
        ])
		->get();

		$ada = Favorite::leftJoin("posts", "favorite.post_id", "=", "posts.id")
		->where([
            ['favorite.user_id', '=', $user->id],
            ['posts.active', '=', 'Y'],
            ['posts.type', '=', 'Delivery'],
        ])
		->count();

        $service = Services::first();

		return view('xhome.favorite.index', compact('date','favs','ada','iduser','service'));

    }

    public function deliveryharga(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');

        $user = Auth::user();

        $keranjang = Keranjang::select("keranjang.id")
        ->leftJoin("posts", "keranjang.post_id", "=", "posts.id")
        ->leftJoin("users", "posts.user_id", "=", "users.id")
        ->leftJoin("wilayah", "users.wilayah_id", "=", "wilayah.id")
        ->where([
            ['keranjang.user_id', '=', $user->id],
            ['voucherdet_id', '=', NULL],
            ['posts.type', '=', 'Products'],
            ['keranjang.delivery', '=', 'Y'],
            ['wilayah.id', '=', $request->id],
        ])
        ->first();

        $sudahtour = Keranjang::where(['id'=>$keranjang->id])
        ->update(['delivery_amount'=>$request->harga, 'delivery_name'=>$request->name, 'delivery_type' => $request->type]);

        return response()->json($keranjang);

    }

    public function deliveryjam(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');

        $user = Auth::user();

        $keranjang = Keranjang::select("keranjang.id")
        ->leftJoin("posts", "keranjang.post_id", "=", "posts.id")
        ->leftJoin("users", "posts.user_id", "=", "users.id")
        ->leftJoin("wilayah", "users.wilayah_id", "=", "wilayah.id")
        ->where([
            ['keranjang.user_id', '=', $user->id],
            ['voucherdet_id', '=', NULL],
            ['posts.type', '=', 'Delivery'],
            ['keranjang.delivery', '=', 'Y'],
            ['wilayah.id', '=', $request->id],
        ])
        ->first();

        $sudahtour = Keranjang::where(['id'=>$keranjang->id])
        ->update(['jam'=>$request->name]);

        return response()->json($keranjang);

    }

    public function deliverytanggal(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');

        $user = Auth::user();

        $keranjang = Keranjang::select("keranjang.id")
        ->leftJoin("posts", "keranjang.post_id", "=", "posts.id")
        ->leftJoin("users", "posts.user_id", "=", "users.id")
        ->leftJoin("wilayah", "users.wilayah_id", "=", "wilayah.id")
        ->where([
            ['keranjang.user_id', '=', $user->id],
            ['voucherdet_id', '=', NULL],
            ['posts.type', '=', 'Delivery'],
            ['keranjang.delivery', '=', 'Y'],
            ['wilayah.id', '=', $request->id],
        ])
        ->first();

        $sudahtour = Keranjang::where(['id'=>$keranjang->id])
        ->update(['plan'=>$request->tanggal]);

        return response()->json($keranjang);

    }

    public function bayar(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d');

        $user = Auth::user();

        if($user->pemegangsaham == 'yes'){

            $pemegangsaham = Services::where('type', 'pemegangsaham')
            ->first();

            $diskon = $pemegangsaham->biaya;

        } else {

            $diskon = 0;

        }

        $keranjangs = Keranjang::select("posts.*","keranjang.qty","wilayah.name as wilayah_name","product.name as prod_name","keranjang.delivery_amount")
        ->leftJoin("posts", "keranjang.post_id", "=", "posts.id")
        ->leftJoin("product", "posts.product_id", "=", "product.id")
        ->leftJoin("users", "posts.user_id", "=", "users.id")
        ->leftJoin("wilayah", "users.wilayah_id", "=", "wilayah.id")
        ->where([
            ['keranjang.user_id', '=', $user->id],
            ['voucherdet_id', '=', null],
            ['posts.type', '=', 'Products'],
            ['keranjang.delivery', '=', 'Y'],
        ])
        ->get();

        $saldouang = SaldoUang::where("user_id", $user->id)
        ->orderBy("id", "desc")
        ->first();

        $adatrans = Transaksi::where("user_id", $user->id)
        ->first();

        $potongan = Keranjang::select('vouchers.*','voucher_details.kode','keranjang.id as kranjang_id')
        ->leftJoin("voucher_details", "keranjang.voucherdet_id", "=", "voucher_details.id")
        ->leftJoin("vouchers", "voucher_details.voucher_id", "=", "vouchers.id")
        ->where("user_id", $user->id)
        ->where([
            ['keranjang.user_id', '=', $user->id],
            ['voucherdet_id', '!=', NULL],
        ])
        ->first();

        $plan = $request->plan;

        return view('xhome.bayar.index', compact('date','keranjangs','adatrans','saldouang','diskon','potongan','plan'));

    }

    public function bayardelivery(Request $request)
    {

        date_default_timezone_set('Asia/Jakarta');
        $user = Auth::user();
        $dates = date('d');
        $hariini = date('Y-m-d');
        $jam = date('H:i');
        $service = Services::first();

        $kranjs = Keranjang::select("wilayah.*","regencies.name as regency_name")
        ->leftJoin("posts", "keranjang.post_id", "=", "posts.id")
        ->leftJoin("users", "posts.user_id", "=", "users.id")
        ->leftJoin("wilayah", "users.wilayah_id", "=", "wilayah.id")
        ->leftJoin("regencies", "wilayah.regency_id", "=", "regencies.id")
        ->where([
            ['keranjang.user_id', '=', $user->id],
            ['voucherdet_id', '=', NULL],
            ['posts.type', '=', 'Products'],
            ['keranjang.delivery', '=', 'Y'],
        ])
        ->distinct()
        ->get();

        foreach ($kranjs as $k) {
            
            $keranjangs = Keranjang::select("posts.*","keranjang.qty","keranjang.delivery_amount")
            ->leftJoin("posts", "keranjang.post_id", "=", "posts.id")
            ->leftJoin("users", "posts.user_id", "=", "users.id")
            ->leftJoin("wilayah", "users.wilayah_id", "=", "wilayah.id")
            ->leftJoin("regencies", "wilayah.regency_id", "=", "regencies.id")
            ->leftJoin("product", "posts.product_id", "=", "product.id")
            ->where([
                ['keranjang.user_id', '=', $user->id],
                ['voucherdet_id', '=', NULL],
                ['posts.type', '=', 'Products'],
                ['wilayah.id', '=', $k->id],
                ['keranjang.delivery', '=', 'Y'],
            ])
            ->get();

            $kranjang22 = Keranjang::select("posts.id as id","product.name as name","posts.img as image", "posts.name as description","posts.harga_act as value","posts.length","posts.width","posts.height","posts.width","keranjang.qty as quantity")
            ->leftJoin("posts", "keranjang.post_id", "=", "posts.id")
            ->leftJoin("product", "posts.product_id", "=", "product.id")
            ->leftJoin("users", "posts.user_id", "=", "users.id")
            ->leftJoin("wilayah", "users.wilayah_id", "=", "wilayah.id")
            ->where([
                ['keranjang.user_id', '=', $user->id],
                ['voucherdet_id', '=', NULL],
                ['posts.type', '=', 'Products'],
                ['wilayah.id', '=', $k->id],
                ['keranjang.delivery', '=', 'Y'],
            ])
            ->get();

            $iddelivery = Keranjang::select("keranjang.*")
            ->leftJoin("posts", "keranjang.post_id", "=", "posts.id")
            ->leftJoin("users", "posts.user_id", "=", "users.id")
            ->leftJoin("wilayah", "users.wilayah_id", "=", "wilayah.id")
            ->where([
                ['keranjang.user_id', '=', $user->id],
                ['voucherdet_id', '=', NULL],
                ['posts.type', '=', 'Products'],
                ['keranjang.delivery', '=', 'Y'],
                ['wilayah.id', '=', $k->id],
                ['keranjang.delivery_name', '!=', NULL],
            ])
            ->first();

            $alamat = Alamat::select("alamat.*","users.email")
             ->leftJoin("users", "alamat.user_id", "=", "users.id")
             ->where([
                ['alamat.user_id', '=', $user->id],
                ['utama', '=', 'yes'],
            ])
            ->first();

            $uuid = Uuid::generate();
            $code = substr($uuid,0,8);

            $trans = new Transaksi();
            $trans->uuid = $code.$dates;
            $trans->user_id = $user->id;
            $trans->wilayah_id = $k->id;
            $trans->type = 'in';
            $trans->status = 'DIPROSES';
            $trans->alamat_id = $alamat->id;
            $trans->save();

            $total = 0;
            $delivery = 0;

            foreach ($keranjangs as $keranjang) {

                $totalss = $keranjang->harga_act;

                $total += $keranjang->qty * $totalss;
                $delivery += $keranjang->delivery_amount;

            }

            $adavoucher = Keranjang::select("vouchers.amount","keranjang.voucherdet_id")
            ->leftJoin("voucher_details", "keranjang.voucherdet_id", "=", "voucher_details.id")
            ->leftJoin("vouchers", "voucher_details.voucher_id", "=", "vouchers.id")
            ->where("voucherdet_id","!=",NULL)
            ->where("user_id", $user->id)
            ->first();

            if($adavoucher){

                $voucher = $adavoucher->amount;

            } else {

                $voucher = 0;

            }

            $donation = new Order();
            $donation->uuid = $uuid;
            $donation->transaction_id = $trans->id;
            $donation->user_id = $user->id;
            $donation->type_bayar = 'SALDO Warungkoki';
            $donation->status = 'selesai';
            $donation->order_type = 'Pembelian Delivery';
            $donation->amount = floatval($total+$delivery-$voucher);
            $donation->delivery = floatval($delivery);
            $donation->delivery_name = $iddelivery->delivery_name;
            $donation->delivery_type = $iddelivery->delivery_type;
            $donation->jam = $iddelivery->jam;
            if($adavoucher){
                $donation->voucherdet_id = $adavoucher->voucherdet_id;
            }
            $donation->save();

            if($adavoucher){
                $updates = VoucherDetails::where(['id'=>$adavoucher->voucherdet_id])
                ->update(['status'=> 'selesai']);
            }

            foreach ($keranjangs as $keranjang) {

                $totalx = $keranjang->harga_act;

                $transorder = new OrderDetails();
                $transorder->order_id = $donation->id;
                $transorder->post_id = $keranjang->id;
                $transorder->qty = $keranjang->qty;
                $transorder->amount = $keranjang->qty * $totalx;
                $transorder->save();

                $transdet = new TransaksiDetails();
                $transdet->transaction_id = $trans->id;
                $transdet->post_id = $keranjang->id;
                $transdet->product_id = $keranjang->product_id;
                $transdet->qty = $keranjang->qty;
                $transdet->save();
                
            }

            $orderan = Order::select("orders.*","users.email","users.fcm_token","users.name as username")
            ->leftJoin("transactions", "orders.transaction_id", "=", "transactions.id")
            ->leftJoin("users", "transactions.user_id", "=", "users.id")
            ->where("transaction_id", $trans->id)
            ->first();

            // ====== KIRIM EMAIL ======

            $transaksis = OrderDetails::select("posts.*","order_details.qty","order_details.amount","product.name as prod_name")
            ->leftJoin("posts", "order_details.post_id", "=", "posts.id")
            ->leftJoin("product", "posts.product_id", "=", "product.id")
            ->where("order_details.order_id", $orderan->id)
            ->get();

            // $emails = $orderan->email;

            // try{
            //     Mail::send('email.bayaronline', ['nama' => $orderan->username, 'amount' => $orderan->amount, 'transaksis' => $transaksis, 'delivery' => $orderan->delivery, 'delivery_name' => $orderan->delivery_name, 'delivery_type' => $orderan->delivery_type], function ($message) use ($emails)
            //     {
            //         $message->subject('Terimakasih sudah melakukan transaksi Delivery!');
            //         $message->from('admin@tomxperience.id', 'Admin Tomxperience.id');
            //         $message->to($emails);
            //     });

            // }
            // catch (Exception $e){
            //     return response (['status' => false,'errors' => $e->getMessage()]);
            // }

            $uuid2 = Uuid::generate();
            $code2 = substr($uuid2,0,8);

            $saldox = new SaldoTrans();
            $saldox->uuid = $code2;
            $saldox->user_id = $user->id;
            $saldox->transaction_id = $trans->id;
            $saldox->type = 'out';
            $saldox->amount = floatval($total+$delivery);
            $saldox->save();

            $adasaldo = SaldoUang::where("user_id", $user->id)
            ->orderBy("id", "desc")
            ->first();

            $sald = new SaldoUang();
            $sald->user_id = $user->id;
            $sald->saldotrans_id = $saldox->id;
            $sald->before = $adasaldo->sisa;
            $sald->sisa = $adasaldo->sisa - $total - $delivery;
            $sald->save();


            // ===== MAKE ORDER DELIVERY =====

            // $shipper = Shipper::where('wilayah_id', $k->id)
            // ->first();

            // $jayParsedAry = [
            //    "shipper_contact_name" => $shipper->name, 
            //    "shipper_contact_phone" => $shipper->nohp, 
            //    "shipper_contact_email" => $shipper->email, 
            //    "shipper_organization" => "Tomxperience.id", 
            //    "origin_contact_name" => $shipper->name, 
            //    "origin_contact_phone" => $shipper->nohp, 
            //    "origin_address" => $k->alamat, 
            //    "origin_note" => $shipper->note, 
            //    "origin_postal_code" => $k->postal_code, 
            //    "origin_coordinate" => [
            //          "latitude" => $k->lat, 
            //          "longitude" => $k->long 
            //       ], 
            //    "destination_contact_name" => $alamat->penerima, 
            //    "destination_contact_phone" => $alamat->nohp, 
            //    "destination_contact_email" => $alamat->email, 
            //    "destination_address" => $alamat->alamat, 
            //    "destination_postal_code" => $alamat->postal_code, 
            //    "destination_note" => $alamat->note, 
            //    "destination_coordinate" => [
            //             "latitude" => $alamat->lat, 
            //             "longitude" => $alamat->long 
            //          ], 
            //    "courier_company" => $iddelivery->delivery_name, 
            //    "courier_type" => $iddelivery->delivery_type, 
            //    "delivery_type" => "now", 
            //    "delivery_date" => $hariini, 
            //    "delivery_time" => $jam, 
            //    "order_note" => "Please be carefull", 
            //    "status" => "placed",
            //    "metadata" => [
            //             ], 
            //    "items" => json_decode($kranjang22)
            // ];


            // $output = self::$client->request('POST', self::$hostUrl . '/v1/orders', [
            //     'headers' => [
            //          'Content-Type'  => 'application/json',
            //          'Authorization' => env('BITESHIP_KEY')
            //     ],
            //     'json' => $jayParsedAry,
            // ]);

            // $output = json_decode($output->getBody(), true);

            // $sudahtour = Transaksi::where(['id'=>$trans->id])
            // ->update(['delivery_code'=>$output['id']]);

        }
 

        // ========== SELESAI =========

        $keranjanghapus = Keranjang::where('keranjang.user_id', '=', $user->id)
        ->delete();

        return response()->json($keranjanghapus);

    }

    public function history()
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d');

        $user = Auth::user();

        $transaksis = Transaksi::where([
            ['user_id', '=', $user->id],
            ['alamat_id', '!=', NULL],
        ])
        ->orderBy("id","desc")
        ->get();

        $userid = $user->id;

        return view('xhome.history.index', compact('date','transaksis','userid'));

    }

    public function historydetail(Request $request)
    {   
        $trans = Transaksi::select("transactions.*","orders.type_bayar","regencies.name as regency_name","provinces.name as prov_name","regencies.postal_code","districts.name as district_name","alamat.penerima","alamat.nohp","alamat.alamat","orders.jam")
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
        ->first();

        $jenis = 'Delivery';

        $saldos = OrderDetails::select("posts.*","order_details.qty","order_details.amount","transactions.id as trans_id","orders.amount as total","transactions.status","product.name as prod_name","orders.delivery","delivery.name as delivery_name")
        ->leftJoin("orders", "order_details.order_id", "=", "orders.id")
        ->leftJoin("transactions", "orders.transaction_id", "=", "transactions.id")
        ->leftJoin("posts", "order_details.post_id", "=", "posts.id")
        ->leftJoin("product", "posts.product_id", "=", "product.id")
        ->leftJoin("delivery", "orders.delivery_id", "=", "delivery.id")
        ->where("transactions.uuid", $request->uuid)
        ->get();


        $tour = Tours::where("user_id", $user->id)
        ->first();


        $sudahtour = Tours::where(['user_id'=>$user->id])
        ->update(['transdetail'=>'1']);


        return view('xhome.history.detail', compact('saldos','jenis','trans','wilayah','tour','service'));

    }

    public function historyselesai(Request $request)
    {

        date_default_timezone_set('Asia/Jakarta');
        $user = Auth::user();

        $sudahtour = Transaksi::where(['id'=>$request->id])
        ->update(['status'=>'APPROVED']);

        return response()->json($sudahtour);

    }

    public function countdelivery(){

        $user = Auth::user();

        $reedem = Transaksi::select("transactions.*","wilayah.name as wilayah_name")
        ->leftJoin("transaction_details", "transactions.id", "=", "transaction_details.transaction_id")
        ->leftJoin("posts", "transaction_details.post_id", "=", "posts.id")
        ->leftJoin("users", "posts.user_id", "=", "users.id")
        ->leftJoin("wilayah", "users.wilayah_id", "=", "wilayah.id")
        ->where([
            ['transactions.status', '=', 'DIPROSES'],
            ['transactions.alamat_id', '!=', null],
            ['wilayah.id', '=', $user->wilayah_id],
        ])
        ->distinct()
        ->get();

        $delivery = $reedem->count();

        return response()->json($delivery);

    }

    public function countdeliveryuser(){

        $user = Auth::user();

        $reedem = Transaksi::where([
            ['status', '!=', 'APPROVED'],
            ['transactions.alamat_id', '!=', null],
            ['user_id', '=', $user->id],
        ])
        ->where([
            ['status', '!=', 'CANCEL'],
            ['transactions.alamat_id', '!=', null],
            ['user_id', '=', $user->id],
        ])
        ->where([
            ['status', '!=', 'CANCELLED'],
            ['transactions.alamat_id', '!=', null],
            ['user_id', '=', $user->id],
        ])
        ->where([
            ['status', '!=', 'KADALUARSA'],
            ['transactions.alamat_id', '!=', null],
            ['user_id', '=', $user->id],
        ])
        ->get();
        

        $reedembiasa = Transaksi::where([
            ['status', '!=', 'APPROVED'],
            ['transactions.alamat_id', '=', null],
            ['user_id', '=', $user->id],
        ])
        ->where([
            ['status', '!=', 'CANCEL'],
            ['transactions.alamat_id', '=', null],
            ['user_id', '=', $user->id],
        ])
        ->where([
            ['status', '!=', 'CANCELLED'],
            ['transactions.alamat_id', '=', null],
            ['user_id', '=', $user->id],
        ])
        ->where([
            ['status', '!=', 'KADALUARSA'],
            ['transactions.alamat_id', '=', null],
            ['user_id', '=', $user->id],
        ])
        ->get();

        $delivery = $reedem->count() + $reedembiasa->count();

        return response()->json($delivery);

    }

    public function petugas()
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d');

        $user = Auth::user();

        $transaksis = Transaksi::select("transactions.*","wilayah.name as wilayah_name","orders.jam")
        ->leftJoin("transaction_details", "transactions.id", "=", "transaction_details.transaction_id")
        ->leftJoin("orders", "transactions.id", "=", "orders.transaction_id")
        ->leftJoin("posts", "transaction_details.post_id", "=", "posts.id")
        ->leftJoin("users", "posts.user_id", "=", "users.id")
        ->leftJoin("wilayah", "users.wilayah_id", "=", "wilayah.id")
        ->where([
            ['transactions.status', '=', 'DIPROSES'],
            ['transactions.alamat_id', '!=', null],
            ['wilayah.id', '=', $user->wilayah_id],
        ])
        ->distinct()
        ->orderBy("id","desc")
        ->get();

        $userid = $user->id;

        return view('xhome.petugas.index', compact('date','transaksis','userid'));

    }

    public function petugasdetail(Request $request)
    {   
        $trans = Transaksi::select("transactions.*","orders.type_bayar","regencies.name as regency_name","provinces.name as prov_name","regencies.postal_code","districts.name as district_name","alamat.penerima","alamat.nohp","alamat.alamat","users.name as username",'orders.jam',"orders.delivery_name")
        ->leftJoin("orders", "transactions.id", "=", "orders.transaction_id")
        ->leftJoin("alamat", "transactions.alamat_id", "=", "alamat.id")
        ->leftJoin("districts", "alamat.district_id", "=", "districts.id")
        ->leftJoin("regencies", "districts.regency_id", "=", "regencies.id")
        ->leftJoin("provinces", "regencies.province_id", "=", "provinces.id")
        ->leftJoin("users", "transactions.user_id", "=", "users.id")
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
        ->first();

        $jenis = 'Delivery';

        $saldos = OrderDetails::select("posts.*","order_details.qty","order_details.amount","transactions.id as trans_id","orders.amount as total","transactions.status","product.name as prod_name","orders.delivery","orders.delivery_name","orders.delivery_type")
        ->leftJoin("orders", "order_details.order_id", "=", "orders.id")
        ->leftJoin("transactions", "orders.transaction_id", "=", "transactions.id")
        ->leftJoin("posts", "order_details.post_id", "=", "posts.id")
        ->leftJoin("product", "posts.product_id", "=", "product.id")
        ->where("transactions.uuid", $request->uuid)
        ->get();

        $potongan = Order::select("vouchers.*")
        ->leftJoin("voucher_details", "orders.voucherdet_id", "=", "voucher_details.id")
        ->leftJoin("vouchers", "voucher_details.voucher_id", "=", "vouchers.id")
        ->where("transaction_id", $trans->id)
        ->where("voucherdet_id", '!=', NULL)
        ->first();


        $tour = Tours::where("user_id", $user->id)
        ->first();


        $sudahtour = Tours::where(['user_id'=>$user->id])
        ->update(['transdetail'=>'1']);


        return view('xhome.petugas.detail', compact('saldos','jenis','trans','wilayah','tour','service','potongan'));

    }

    public function upload(Request $request)
    {   
        date_default_timezone_set('Asia/Jakarta');
        $user = Auth::user();

        $validation = Validator::make($request->all(), [
            'file' => 'mimes:jpeg,bmp,png,svg,pdf,jpg',
        ]);

        if($validation->passes()) {

            $image = $request->file('file');
            $input['imagename'] = rand() . '.' . $image->getClientOriginalExtension();

            $destinationPath = public_path('assets/img_delivery');

            $img = Image::make($image->getRealPath());
            $img->resize(400, 400, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath.'/'.$input['imagename']);

            return response()->json([
                'message'  => 'Upload Anda Tersimpan',
                'icon' => 'success',
                'name' => $input['imagename'],
                'status' => '1',
            ]);

        } else {

            return response()->json([
                'message' => $validation->errors()->all(),
                'icon' => 'error',
                'status' => '0',
            ]);
        }

    }

    public function petugasproses(Request $request)
    {  
        date_default_timezone_set('Asia/Jakarta');
        $user = Auth::user();
        $hariini = date('Y-m-d');
        $jam = date('H:i');

        $k = Wilayah::where("id", $user->wilayah_id)
        ->first();

        $trans = Transaksi::select("transactions.*","orders.delivery_name","orders.delivery_type")
        ->leftJoin("orders", "transactions.id", "=", "orders.transaction_id")
        ->where("transactions.id", $request->id)
        ->first();

        $alamat = Alamat::select("alamat.*","users.email")
         ->leftJoin("users", "alamat.user_id", "=", "users.id")
         ->where('alamat.id', '=', $trans->alamat_id)
        ->first();

        $kranjang22 = TransaksiDetails::select("posts.id as id","product.name as name","posts.img as image", "posts.name as description","posts.harga_act as value","posts.length","posts.width","posts.height","posts.width","transaction_details.qty as quantity")
        ->leftJoin("posts", "transaction_details.post_id", "=", "posts.id")
        ->leftJoin("product", "posts.product_id", "=", "product.id")
        ->leftJoin("users", "posts.user_id", "=", "users.id")
        ->leftJoin("wilayah", "users.wilayah_id", "=", "wilayah.id")
        ->where("transaction_id", $request->id)
        ->get();

        // ===== MAKE ORDER DELIVERY =====

        $shipper = Shipper::where('wilayah_id', $k->id)
        ->first();

        if($trans->delivery_name != "kurirtoko"){

            $jayParsedAry = [
               "shipper_contact_name" => $shipper->name, 
               "shipper_contact_phone" => $shipper->nohp, 
               "shipper_contact_email" => $shipper->email, 
               "shipper_organization" => "Tomxperience.id", 
               "origin_contact_name" => $shipper->name, 
               "origin_contact_phone" => $shipper->nohp, 
               "origin_address" => $k->alamat, 
               "origin_note" => $shipper->note, 
               "origin_postal_code" => $k->postal_code, 
               "origin_coordinate" => [
                     "latitude" => $k->lat, 
                     "longitude" => $k->long 
                  ], 
               "destination_contact_name" => $alamat->penerima, 
               "destination_contact_phone" => $alamat->nohp, 
               "destination_contact_email" => $alamat->email, 
               "destination_address" => $alamat->alamat, 
               "destination_postal_code" => $alamat->postal_code, 
               "destination_note" => $alamat->note, 
               "destination_coordinate" => [
                        "latitude" => $alamat->lat, 
                        "longitude" => $alamat->long 
                     ], 
               "courier_company" => $trans->delivery_name, 
               "courier_type" => $trans->delivery_type, 
               "delivery_type" => "now", 
               "delivery_date" => $hariini, 
               "delivery_time" => $jam, 
               "order_note" => "Please be carefull", 
               "status" => "confirmed",
               "metadata" => [
                        ], 
               "items" => json_decode($kranjang22)
            ];

            $output = self::$client->request('POST', self::$hostUrl . '/v1/orders', [
                'headers' => [
                     'Content-Type'  => 'application/json',
                     'Authorization' => 'biteship_live.eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJuYW1lIjoiV2FydW5na29raSIsInVzZXJJZCI6IjYxMDc4ZmJjZmI3ZjM5NTYyZDI3ZTc5ZCIsImlhdCI6MTYzMDMwNzYwOX0.BcQMP-V3tWhXsytld67HxFrKgMOhm_4TeRVxTntyY1U'
                ],
                'json' => $jayParsedAry,
            ]);

            $output = json_decode($output->getBody(), true);

            $sudahtour = Transaksi::where(['id'=>$trans->id])
            ->update(['delivery_code'=>$output['id']]);

            $update = Transaksi::where(['id'=>$request->id])
            ->update(['status'=> strtoupper($output['status'])]);

        } else {

            $update = Transaksi::where(['id'=>$request->id])
            ->update(['status'=> "ALLOCATED"]);

        }

        
        return response()->json($trans);


    }

    public function petugascancel(Request $request)
    {  
        date_default_timezone_set('Asia/Jakarta');
        $user = Auth::user();
        $hariini = date('Y-m-d');
        $jam = date('H:i');

        $update2 = Transaksi::where(['id'=>$request->id])
        ->update(['status'=>'CANCEL', 'ket' => $request->ket]);

        $trans = Transaksi::select("transactions.*","orders.amount")
        ->leftJoin("orders", "transactions.id", "=", "orders.transaction_id")
        ->where("transactions.id", $request->id)
        ->first();

        $uuid2 = Uuid::generate();
        $code2 = substr($uuid2,0,8);

        $saldox = new SaldoTrans();
        $saldox->uuid = $code2;
        $saldox->user_id = $trans->user_id;
        $saldox->transaction_id = $request->id;
        $saldox->type = 'in';
        $saldox->amount = floatval($trans->amount);
        $saldox->save();

        $adasaldo = SaldoUang::where("user_id", $trans->user_id)
        ->orderBy("id", "desc")
        ->first();

        if($adasaldo){

            $sald = new SaldoUang();
            $sald->user_id = $trans->user_id;
            $sald->saldotrans_id = $saldox->id;
            $sald->before = $adasaldo->sisa;
            $sald->sisa = $adasaldo->sisa + $trans->amount;
            $sald->save();

        } else {

            $sald = new SaldoUang();
            $sald->user_id = $trans->user_id;
            $sald->saldotrans_id = $saldox->id;
            $sald->before = 0;
            $sald->sisa = $trans->amount;
            $sald->save();

        }

        
        return response()->json($trans);


    }

    public function kurirproses(Request $request)
    {  
        date_default_timezone_set('Asia/Jakarta');
        $user = Auth::user();

        $sald = new TransactionDelivery();
        $sald->transaction_id = $request->id;
        $sald->user_id = $user->id;
        $sald->photo = $request->img;
        $sald->save();

        $update2 = Transaksi::where(['id'=>$request->id])
        ->update(['status'=>'DROPPING_OFF']);

        return response()->json($sald);


    }


    public function kurirselesai(Request $request)
    {  
        date_default_timezone_set('Asia/Jakarta');
        $user = Auth::user();

        $ada = TransactionDelivery::where("transaction_id",$request->id)
        ->first();

        $update = TransactionDelivery::where(['id'=>$ada->id])
        ->update(['selesai'=>$request->img]);

        $update2 = Transaksi::where(['id'=>$request->id])
        ->update(['status'=>'APPROVED']);

        return response()->json($ada);


    }

    public function validasi()
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d');
        $user = Auth::user();

        if($user->pemegangsaham == 'yes'){

            $pemegangsaham = Services::where('type', 'pemegangsaham')
            ->first();

            $diskon = $pemegangsaham->biaya;

        } else {

            $diskon = 0;

        }

        $saldouang = SaldoUang::where("user_id", $user->id)
        ->orderBy("id", "desc")
        ->first();

        $keranjangs = Keranjang::select("posts.*","keranjang.qty")
        ->leftJoin("posts", "keranjang.post_id", "=", "posts.id")
        ->where([
            ['keranjang.user_id', '=', $user->id],
            ['voucherdet_id', '=', null],
            ['posts.type', '=', 'Products'],
        ])
        ->get();

        $cekdelivery = Keranjang::where([
            ['user_id', '=', $user->id],
            ['delivery_amount', '!=', null],
        ])
        ->first();

        $total = 0;

        foreach ($keranjangs as $keranjang) {

            $totalss = $keranjang->harga_act - ceil($keranjang->harga_act * (float)$diskon / 100);

            $total += $keranjang->qty * $totalss;

        }

        $adavoucher = Keranjang::select("vouchers.amount","keranjang.voucherdet_id","vouchers.jenis","vouchers.percent")
        ->leftJoin("voucher_details", "keranjang.voucherdet_id", "=", "voucher_details.id")
        ->leftJoin("vouchers", "voucher_details.voucher_id", "=", "vouchers.id")
        ->where("voucherdet_id","!=",NULL)
        ->where("user_id", $user->id)
        ->first();

        if($adavoucher){

            if($adavoucher->jenis == "cashback"){

                $total = $total;

            } else {

                if($adavoucher->amount == NULL){

                    $total = $total - ($total * ($adavoucher->percent / 100));

                } else {

                    $total = $total - $adavoucher->amount;
                }

            }        

        } else {

            $total = $total;

        }

        $grandtotal = $cekdelivery->delivery_amount + $total;


        if($saldouang){
            if($saldouang->sisa >= $grandtotal){
                $data = 0;
            } else {
                $data = 1;
            }
        } else {
            $data = 1;
        }

        $validas = array(    
            'saldo' => $data,
        );

        return response()->json($validas);

    }

    public function bayaronline(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $dates = date('d');

        $snaps = Transaksi::leftJoin("orders", "transactions.id", "=", "orders.transaction_id")
        ->where("transactions.id", $request->transaction_id)
        ->first();

        // Beri response snap token
        $this->response['snap_token'] = $snaps->snap_token;

 
        return response()->json($this->response);
    }

    public function callback(Request $request)
    {

        $bodyContent = json_decode($request->getContent(), true);

        if($bodyContent['status'] == "delivered"){

            $sudahtour = Transaksi::where(['delivery_code'=>$bodyContent['order_id']])
            ->update(['status'=>"APPROVED"]);

        }else{

            $sudahtour = Transaksi::where(['delivery_code'=>$bodyContent['order_id']])
            ->update(['status'=>strtoupper($bodyContent['status'])]);
        }

        $respone = array(    
            'response_status' => 200,
            'response_msg' => 'success',
            "message" => "Status Berhasil Berubah"
        );

        
        return response()->json($respone);

    }

    public function isisaldo(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d');
        $user = Auth::user();

        if($user->va != null){

            $va = $user->va;

            return view('xhome.isisaldo.index', compact('va'));

        } else {

            // $cek = Verifikasi::where("user_id", $user->id)
            // ->first();

            // if($cek){

            //     return view('xhome.isisaldo.verifikasi');

            // } else {

                return view('xhome.isisaldo.add');

            // }

        }
        
    }

    public function verifikasi(Request $request)
    {

        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d');
        $user = Auth::user();

        $cek = Users::where('va', '13749'.$request->nohp)
        ->first();

        if(!$cek){

            $sudahtour = Users::where(['id'=>$user->id])
            ->update(['no_hp'=>$request->nohp, 'va' => '13749'.$request->nohp]);
            $data = 0;

        } else {

            $data = 1;
        }

        return response()->json($data);

    }

    public function verifikasi4(Request $request)
    {

        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d');
        $user = Auth::user();

        $uuid = Uuid::generate();
        $code = substr($uuid,0,8);

        $trans = new Verifikasi();
        $trans->user_id = $user->id;
        $trans->kode = $code;
        $trans->nohp = $request->nohp;
        $trans->save();

        $emails = $user->email;

        try{
            Mail::send('email.verifikasi', ['nama' => $user->name, 'kode' => $code, 'nohp' => $request->nohp], function ($message) use ($emails)
            {
                $message->subject('Verifikasi nomor Handphone Warungkoki!');
                $message->from('admin@warungkoki.id', 'Admin warungkoki.id');
                $message->to($emails);
            });

        }
        catch (Exception $e){
            return response (['status' => false,'errors' => $e->getMessage()]);
        }

        return response()->json($emails);

    }

    public function verifikasi2(Request $request)
    {

        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d');
        $user = Auth::user();

        $cek = Verifikasi::where("kode", $request->kode)
        ->first();

        if($cek){

            $data = 0;

            $sudahtour = Users::where(['id'=>$user->id])
            ->update(['no_hp'=>$cek->nohp, 'va' => '13562'.$cek->nohp]);

            $delete = Verifikasi::where('id', $cek->id)
            ->delete();

        } else {

            $data = 1;
        }

        return response()->json($data);

    }

    public function verifikasi3(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d');
        $user = Auth::user();

        $cek = Verifikasi::where("user_id", $user->id)
        ->first();

        if($cek){

            $delete = Verifikasi::where('id', $cek->id)
            ->delete();

        }

        return response()->json($user);

    }

    public function diskon(Request $request)
    {
        for ($i=1; $i < 26 ; $i++) { 
            
            $trans = new DiskonDetails();
            $trans->diskon_id = 2;
            $trans->code_id = $i;
            $trans->save();

        }


    }

    public function aktifkurir(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $user = Auth::user();

        $cek = KurirLocal::where("wilayah_id", $user->wilayah_id)
        ->first();

        if($cek->active == "yes"){

            $sudahtour = KurirLocal::where(['wilayah_id'=>$user->wilayah_id])
            ->update(['active'=>'no']);

        } else {

            $sudahtour = KurirLocal::where(['wilayah_id'=>$user->wilayah_id])
            ->update(['active'=>'yes']);

        }

        return response()->json($cek);


    }

}
