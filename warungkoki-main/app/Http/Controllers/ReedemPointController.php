<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Users;
use App\Product;
use App\Garansi;
use App\UserCompany;
use App\SaldoUang;
use App\Follow;
use App\UserDaerah;
use App\Wilayah;
use App\Posts;
use App\PostAreas;
use App\PostDetails;
use App\PostRewards;
use App\PostImages;
use App\Province;
use App\Regency;
use App\Transaksi;
use App\WSTransaksi;
use App\Kategori;
use App\Alamat;
use App\Tours;
use App\Services;
use App\SaldoPoin;
use App\Banners;
use App\UndianVouchers;
use App\KeranjangReedemPoint as Keranjang;
use App\KurirLocal;
use Auth;
use DataTables;
use View;

class ReedemPointController extends Controller
{

    public function index()
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d');

        $user = Auth::user();

        return view('content.reedem_point.index');
    }

    public function getKeranjang()
    {
    	date_default_timezone_set('Asia/Jakarta');
		$date = date('Y-m-d');

		$user = Auth::user();

		$kranjangs = Keranjang::select("posts.name","posts.harga_act","keranjang_reedem_point.qty","keranjang_reedem_point.id","product.img as img_name","wilayah.name as wilayah_name","product.name as prod_name","posts.img","posts.jenis","posts.weight")
		->leftJoin("posts", "keranjang_reedem_point.post_id", "=", "posts.id")
        ->leftJoin("users", "posts.user_id", "=", "users.id")
        ->leftJoin("wilayah", "users.wilayah_id", "=", "wilayah.id")
        ->leftJoin("product", "posts.product_id", "=", "product.id")
        ->where([
            ['keranjang_reedem_point.user_id', '=', $user->id],
            ['posts.type', '=', 'Products'],
        ])
		->get();

        $userdetails = Users::where('id', $user->id)
        ->first();

        $adatrans = Transaksi::where("user_id", $user->id)
        ->first();

		$ada = Keranjang::leftJoin("posts", "keranjang_reedem_point.post_id", "=", "posts.id")
        ->where([
            ['keranjang_reedem_point.user_id', '=', $user->id],
            ['posts.type', '=', 'Products'],
        ])
        ->count();

        $service = Services::first();

        $diskon = 0;

        $toko = Keranjang::select("wilayah.*")
        ->join("posts", "keranjang_reedem_point.post_id", "=", "posts.id")
        ->join("users", "posts.user_id", "=", "users.id")
        ->join("wilayah", "users.wilayah_id", "=", "wilayah.id")
        ->where("keranjang_reedem_point.user_id", $user->id)
        ->first();

        $alamat = Alamat::where([
            ['user_id', '=', $user->id],
            ['utama', '=', 'yes'],
        ])
        ->first();

        if($toko){

            if($alamat){

                $dist = GetDrivingDistance($toko->lat,$alamat->lat,$toko->long,$alamat->long);

                $distance = $dist['distance'];
                $time = $dist['time'];

            } else {

                $distance = 0;
                $time = 0;

            }

            // ==== GET KURIR TOKO ===

            $tots=0;
            $berat=0;
            foreach($kranjangs as $krj){

                $tots += $krj->qty * $krj->harga_act - ceil($krj->harga_act * (float)$diskon / 100);
                $berat += $krj->qty;
            }

            $local = KurirLocal::where("wilayah_id", $toko->id)
            ->first();

            if($local){
                if($local->active == "yes"){

                    if((int)$berat >= 100){

                        $getfree = "yes";

                    } else {

                        if((int)$local->jarak >= (int)$distance){

                            if((int)$local->amount <= (int)$tots){

                                $getfree = "yes";

                            } else {

                                $getfree = "no";

                            }

                        } else {

                            $getfree = "no";

                        }
                    }

                } else {

                    $getfree = "no";
                }
            }

        } else {

            $distance = 0;
            $time = 0;
            $getfree = "no";
            $berat = 0;

            $toko = Users::select("wilayah.*","company.photo","regencies.name as regency_name")
                    ->join("wilayah", "users.wilayah_id", "=", "wilayah.id")
                    ->join("company", "wilayah.company_id", "=", "company.id")
                    ->join("regencies", "wilayah.regency_id", "=", "regencies.id")
                    ->where("users.id", $user->id)
                    ->first();

            if($toko){

                if($alamat){

                    $dist = GetDrivingDistance($toko->lat,$alamat->lat,$toko->long,$alamat->long);

                    $distance = $dist['distance'];
                    $time = $dist['time'];

                } else {

                    $distance = 0;
                    $time = 0;

                }

            } else {

                $distance = 0;
                $time = 0;
                $getfree = "no";
                $berat = 0;

            }

        }

        $saldopoin = SaldoPoin::where("user_id", $user->id)
            ->orderBy("id", "desc")
            ->first();

		return view('content.reedem_point.produk.users.index_keranjang', 
        compact('date','kranjangs','ada','userdetails','adatrans','service','diskon','toko','getfree','berat','saldopoin'));

    }

    public function addKeranjang(Request $request)
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
            $keranjang->id_bracket_product = $request->bracket_product_id;
	        $keranjang->save();

        } else {

            $qty = $ada->qty + 1;

        	$keranjang = Keranjang::where(['user_id'=>$user->id,'post_id'=>$request->post_id])
                ->update(['qty'=>$qty]);
        }

        $keranjangnow = Keranjang::leftJoin("posts", "keranjang_reedem_point.post_id", "=", "posts.id")
        ->where([
            ['keranjang_reedem_point.user_id', '=', $user->id]
        ])
        ->count();
        
        return response()->json($keranjangnow);

    }

    public function subKeranjang(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');

        if($request->qty == "" || $request->qty == 0){
            $qty = 1;
        } else {
            $qty = $request->qty;

        }

        $keranjang = Keranjang::where(['id'=>$request->id])
        ->update(['qty'=>$qty]);

        return response()->json($keranjang);

    }

    public function updateQtyKeranjang(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');

        $show = Keranjang::findOrFail($request->id);
        $show->qty = $request->qty;
        $show->save();

        return response()->json($show);

    }

    public function getCountKeranjang(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');

        $user = Auth::user();

		$ada = Keranjang::leftJoin("posts", "keranjang_reedem_point.post_id", "=", "posts.id")
        ->where([
            ['keranjang_reedem_point.user_id', '=', $user->id],
            ['posts.type', '=', 'Products'],
        ])
        ->count();
        
        return response()->json($ada);

    }

    public function getProduct(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d');
        $hariini = date('Y-m-d H:i:s');
        $hari = date('Y-m-d');

        $user = Auth::user();

        $iduser = $user->id;

        $roles = Users::select("role_id")
        ->where("id", $user->id)
        ->first();

        $ada = Follow::where("user_id", $iduser)
        ->count();

        // ===CEK KADALUARSA ===

        $trans = Transaksi::where([
            ['created_at', '<', $hariini],
            ['status', '=', 'BELUM BAYAR'],
            ['user_id', '=', $user->id],
        ])
        ->orWhere([
            ['created_at', '<', $hariini],
            ['status', '=', 'NOT APPROVED'],
            ['user_id', '=', $user->id],
        ])
        ->get();

        foreach ($trans as $tran) {
            
            $datetime1 = $tran->created_at;
            $datetime2 = date('Y-m-d H:i:s', strtotime($datetime1 .' +1 day'));
            
            if(strtotime($hariini) > strtotime($datetime2)){

                $updates = Transaksi::findOrFail($tran->id);
                $updates->status = 'KADALUARSA';
                $updates->save();

            }
            // $selisih =  $interval->format('%R%a');

            // $angka = intval(substr($selisih,1));

            // if($angka >= 2){

            //     $updates = Transaksi::findOrFail($tran->id);
            //     $updates->status = 'KADALUARSA';
            //     $updates->save();

            // }

        }

        $reedemss = Transaksi::where([
            ['status', '=', 'REEDEM'],
            ['user_id', '=', $user->id],
        ])
        ->get();

        foreach ($reedemss as $reedem) {

            $plans = date('Y-m-d', strtotime($reedem->plan));

            if(strtotime($plans) < strtotime($hari)){

                $updates = Transaksi::findOrFail($reedem->id);
                $updates->status = 'KADALUARSA';
                $updates->save();

            }

        }

        // === KATEGORI BBM ===

        $kategori = Kategori::where("type", null)->get();

        $reedems = Transaksi::where([
            ['type', '=', 'out'],
            ['user_id', '=', $user->id],
            ['status', '=', 'REEDEM'],
        ])
        ->orWhere([
            ['type', '=', 'in'],
            ['user_id', '=', $user->id],
            ['status', '=', 'BELUM BAYAR'],
        ])
        ->orderBy("transactions.id","desc")
        ->get();

        $toko = Users::select("wilayah.*","company.photo","regencies.name as regency_name")
        ->join("wilayah", "users.wilayah_id", "=", "wilayah.id")
        ->join("company", "wilayah.company_id", "=", "company.id")
        ->join("regencies", "wilayah.regency_id", "=", "regencies.id")
        ->where("users.id", $user->id)
        ->first();

        $alamat = Alamat::where([
            ['user_id', '=', $user->id],
            ['utama', '=', 'yes'],
        ])
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

        $saldouang = SaldoUang::where("user_id", $user->id)
        ->orderBy("id", "desc")
        ->first();

        $service = Services::where('type', 'midtrans')
        ->first();

        if($user->pemegangsaham == 'yes'){

            $pemegangsaham = Services::where('type', 'pemegangsaham')
            ->first();

            $diskon = $pemegangsaham->biaya;

        } else {

            $diskon = 0;

        }

        if($toko){

            if($alamat){

                $dist = GetDrivingDistance($toko->lat,$alamat->lat,$toko->long,$alamat->long);

                $distance = $dist['distance'];
                $time = $dist['time'];

            } else {

                $distance = 0;
                $time = 0;

            }

        } else {

            $distance = 0;
            $time = 0;

        }

        $saldopoin = SaldoPoin::where("user_id", $user->id)
        ->orderBy("id", "desc")
        ->first();


        // ======= MENENTUKAN TAMPILAN =======

        $toko = Users::select("wilayah.*","company.photo","regencies.name as regency_name")
        ->join("wilayah", "users.wilayah_id", "=", "wilayah.id")
        ->join("company", "wilayah.company_id", "=", "company.id")
        ->join("regencies", "wilayah.regency_id", "=", "regencies.id")
        ->where("users.id", $user->id)
        ->first();

        if($toko){

            if($alamat){

                $dist = GetDrivingDistance($toko->lat,$alamat->lat,$toko->long,$alamat->long);

                $distance = $dist['distance'];
                $time = $dist['time'];

            } else {

                $distance = 0;
                $time = 0;

            }

        } else {

            $distance = 0;
            $time = 0;

        }

        $wilayahid = $user->wilayah_id;

        $banners = Banners::where("active", "yes")
        ->orderBy("urutan","asc")
        ->get();

        $bracket_reedem = $this->getGuzzleRequest($wilayahid);
        $product_reedem = [];
        $variant_reedem = [];

        $variant_ignore = [];

        return view('content.reedem_point.produk.users.index', 
        compact('date','iduser', 'variant_ignore', 'bracket_reedem','wilayahid','kategori','reedems','toko','sudahtour','cekout','service','saldouang','diskon','distance','time','alamat','saldopoin','banners'));

    }

    public function getHistoryTransaction()
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d');

        $user = Auth::user();

        $adasaldo = SaldoPoin::where("user_id", $user->id)
        ->orderBy("id", "desc")
        ->first();

        $saldos = SaldoPoin::select("saldo_poin.*","saldo_trans_poin.amount","saldo_trans_poin.type")
        ->join("saldo_trans_poin", "saldo_poin.transpoin_id", "=", "saldo_trans_poin.id")
        ->where('saldo_poin.user_id', '=', $user->id)
        ->orderBy("saldo_poin.id","desc")
        ->get();

        $toko = Users::select("wilayah.*","company.photo","regencies.name as regency_name")
        ->join("wilayah", "users.wilayah_id", "=", "wilayah.id")
        ->join("company", "wilayah.company_id", "=", "company.id")
        ->join("regencies", "wilayah.regency_id", "=", "regencies.id")
        ->where("users.id", $user->id)
        ->first();

        return view('content.reedem_point.produk.users.index_history', compact('date','adasaldo','saldos','toko'));
    }
    
    public function validasiTokenWilayah()
    {
        date_default_timezone_set('Asia/Jakarta');
		$date = date('Y-m-d');

		$usernyah = Auth::user();

        if(!$usernyah){
            $user = Users::where("email", csrf_token())
            ->first();
        } else {
            $user = Auth::user();
        }

        $diskon = 0;

        $saldopoin = Saldopoin::where("user_id", $user->id)
        ->orderBy("id", "desc")
        ->first();

        $keranjangs = Keranjang::select("posts.*","keranjang_reedem_point.qty")
        ->leftJoin("posts", "keranjang_reedem_point.post_id", "=", "posts.id")
        ->where([
            ['keranjang_reedem_point.user_id', '=', $user->id],
        ])
        ->get();

        $total = 0;

        $act = [];
        $ss = [];

        foreach ($keranjangs as $keranjang) {

            $harga = (butir_padi($keranjang->harga_act));
            $totalnya = $keranjang->qty * $harga;

            $totalkeseluruhan = $totalnya;

            $total += $totalkeseluruhan;

            $act[] = $keranjang->harga_act;
            $ss[] = $harga;

        }

        if($saldopoin){
            if($saldopoin->sisa >= $total){
                $data = 1;
            } else {
                $data = 0;
            }
        } else {
            $data = 0;
        }

		$wilayah = Keranjang::select("wilayah.name")
		->leftJoin("posts", "keranjang_reedem_point.post_id", "=", "posts.id")
        ->leftJoin("users", "posts.user_id", "=", "users.id")
        ->leftJoin("wilayah", "users.wilayah_id", "=", "wilayah.id")
        ->where([
            ['keranjang_reedem_point.user_id', '=', $user->id],
            ['posts.type', '=', 'Products'],
        ])
		->distinct()
		->get();

        $banyak = $wilayah->count();

        $validas = array(    
            'wilayah' => $banyak,
            'saldo' => $data,
        );

		return response()->json($validas);
    }

    private function getGuzzleRequest($wilayahid)
    {

        $client = new \GuzzleHttp\Client();

        $request = $client->get("http://127.0.0.1:8000/api/reedem_point/product/list/today?type_response=json&wilayah_id=$wilayahid");

        $response = json_decode($request->getBody(),true);

        return ($response['data']);

    }

    public function getVariantByIdProduct($id)
    {

        $client = new \GuzzleHttp\Client();

        $request = $client->get("http://127.0.0.1:8000/api/reedem_point/bracket/product/variant?type_response=json&id=$id");

        $response = json_decode($request->getBody(),true);

        return ($response['data']);

    }


    

}
