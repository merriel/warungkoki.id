<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Saldo;
use App\SaldoRewards;
use App\SendNotif;
use App\Transaksi;
use App\TransaksiDetails;
use App\TransaksiMission;
use App\TransactionInsentifs;
use App\Users;
use App\Posts;
use App\Product;
use App\OrderDetails;
use App\ReedemKeranjang;
use App\ReedemKet;
use App\Tours;
use App\Rewards;
use App\Order;
use App\VoucherDetails;
use App\UserMembers;
use App\TransSaldoPoin;
use App\UndianVouchers;
use App\SaldoPoin;
use App\Undian;
use App\Vouchers;
use Auth;
use Mail;
use Uuid;
use Carbon\Carbon;
use GuzzleHttp\Client;

class ReedemController extends Controller
{   
    private static $hostUrl = 'https://api.midtrans.com';
    private static $client;

    public function __construct(){
        self::$client = new \GuzzleHttp\Client;
    }

    public function index()
    {
        date_default_timezone_set('Asia/Jakarta');
        $user = Auth::user();

        $reedems = Transaksi::select("product.name as product_name","transaction_details.qty","transactions.created_at","wilayah.name as wilayah_name","wilayah.kota")
        ->leftJoin("users", "transactions.user_id", "=", "users.id")
        ->leftJoin("user_companies", "transactions.petugas_id", "=", "user_companies.user_id")
        ->leftJoin("wilayah", "user_companies.wilayah_id", "=", "wilayah.id")
        ->leftJoin("transaction_details", "transactions.id", "=", "transaction_details.transaction_id")
        ->leftJoin("product", "transaction_details.product_id", "=", "product.id")
        ->leftJoin("posts", "transaction_details.post_id", "=", "posts.id")
        ->where([
            ['transactions.user_id', '=', $user->id],
            ['transactions.type', '=', 'out'],
            ['transactions.status', '=', 'APPROVED'],
        ])
        ->orderBy("transactions.id", "desc")
        ->get();

        return view('content.reedem.index', compact('reedems'));

    }

    public function reedemdeals(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $user = Auth::user();

        if($request->type == 'reward'){

            $saldo = SaldoRewards::where("id", $request->saldo_id)
            ->first();

        } else{

            $saldo = Saldo::where("id", $request->saldo_id)
            ->first();
        }

        $uuid = Uuid::generate();

        $code = substr($uuid,0,8);


        $trans = new Transaksi();
        $trans->uuid = $code;
        $trans->user_id = $user->id;
        $trans->type = 'out';
        $trans->status = 'REEDEMREWARD';
        $trans->save();

        $transdet = new TransaksiDetails();
        $transdet->transaction_id = $trans->id;
        if($request->type == 'reward'){
            $transdet->join_id = $saldo->join_id;
        } else {
            $transdet->post_id = $saldo->post_id; 
        }
        
        $transdet->product_id = $saldo->product_id;
        $transdet->qty = $request->qty;
        $transdet->save();

        $transaksi = Transaksi::where("id", $trans->id)
        ->first();

        return response()->json($transaksi);


    }

    public function view(Request $request)
    {   
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d');

        $code = $request->code;

        $cektrans = Transaksi::select("users.*","transactions.id as trans_id","transactions.type","transactions.ket","transactions.uuid as trans_uuid","transactions.status")
        ->join("transaction_details", "transactions.id", "=", "transaction_details.transaction_id")
        ->join("users", "transactions.user_id", "=", "users.id")
        ->where([
            ['uuid', '=', $request->code],
            ['transactions.status', '!=', 'KADALUARSA'],
        ])
        ->first();

        $cekapproved = Transaksi::select("transactions.*","users.name as user_name","wilayah.name as wilayah_name")
        ->join("transaction_details", "transactions.id", "=", "transaction_details.transaction_id")
        ->join("users", "transactions.user_id", "=", "users.id")
        ->join("wilayah", "transactions.wilayah_id", "=", "wilayah.id")
        ->where([
            ['transactions.uuid', '=', $request->code],
            ['transactions.status', '=', 'APPROVED'],
        ])
        ->first();

        $wilayah = TransaksiDetails::select("wilayah.name")
        ->leftJoin("transactions", "transaction_details.transaction_id", "=", "transactions.id")
        ->leftJoin("posts", "transaction_details.post_id", "=", "posts.id")
        ->leftJoin("users", "posts.user_id", "=", "users.id")
        ->leftJoin("wilayah", "users.wilayah_id", "=", "wilayah.id")
        ->where("transactions.uuid", $request->code)
        ->first();

        $user = Auth::user();

        $fcm = $user->fcm_token;

        if($cektrans){

            $voucher = Order::select("vouchers.*")
            ->leftJoin("voucher_details", "orders.voucherdet_id", "=", "voucher_details.id")
            ->leftJoin("vouchers", "voucher_details.voucher_id", "=", "vouchers.id")
            ->where("transaction_id", $cektrans->trans_id)
            ->where("voucherdet_id", '!=', NULL)
            ->first();

            if($cektrans->status == "REEDEM"){

                $saldos = Transaksi::select("users.name","product.name as prod_name","users.fcm_token","transactions.id","transaction_details.qty","posts.type as post_type","transaction_details.id as detail_id","transaction_details.status")
                ->join("transaction_details", "transactions.id", "=", "transaction_details.transaction_id")
                ->join("product", "transaction_details.product_id", "=", "product.id")
                ->join("users", "transactions.user_id", "=", "users.id")
                ->join("posts", "transaction_details.post_id", "=", "posts.id")
                ->where("transactions.uuid", $request->code)
                ->get();

            } else {

                $saldos = OrderDetails::select("posts.*","order_details.qty","order_details.amount","transactions.id as trans_id","orders.amount as total","product.name as prod_name",'product.timbangan',"order_details.id as detail_id","order_details.timbangan as order_timbangan")
                ->leftJoin("orders", "order_details.order_id", "=", "orders.id")
                ->leftJoin("transactions", "orders.transaction_id", "=", "transactions.id")
                ->leftJoin("posts", "order_details.post_id", "=", "posts.id")
                ->leftJoin("product", "posts.product_id", "=", "product.id")
                ->where("transactions.uuid", $request->code)
                ->get();

            }

            return view('content.prosesreedem.index', compact('saldos','cektrans','fcm','wilayah','code','voucher','cekapproved'));

        } else {

            return view('content.prosesreedem.index', compact('cektrans','fcm','wilayah','code','cekapproved'));


        }

    }

    public function transaksi(Request $request)
    {
    	date_default_timezone_set('Asia/Jakarta');
    	$date = date('Y-m-d');
    	$timestamp = date('Y-m-d H:i:s');

    	$user = Auth::user();

        $ambiluser = Transaksi::select("users.email","users.fcm_token","product.name","users.name as user_name","transactions.status","transaction_details.join_id")
        ->join("users", "transactions.user_id", "=", "users.id")
        ->join("transaction_details", "transactions.id", "=", "transaction_details.transaction_id")
        ->join("product", "transaction_details.product_id", "=", "product.id")
        ->where("transactions.id", $request->trans_id)
        ->first();

        if($ambiluser->join_id == null){

            $cekwilayah = Transaksi::select("users.wilayah_id","posts.type","wilayah.name","wilayah.alamat")
            ->leftJoin("transaction_details", "transactions.id", "=", "transaction_details.transaction_id")
            ->leftJoin("posts", "transaction_details.post_id", "=", "posts.id")
            ->leftJoin("users", "posts.user_id", "=", "users.id")
            ->leftJoin("wilayah", "users.wilayah_id", "=", "wilayah.id")
            ->where("transactions.id", $request->trans_id)
            ->first();

        } else {

           $cekwilayah = Transaksi::select("users.wilayah_id","posts.type","wilayah.name","wilayah.alamat")
            ->leftJoin("transaction_details", "transactions.id", "=", "transaction_details.transaction_id")
            ->leftJoin("challange_joins", "transaction_details.join_id", "=", "challange_joins.id")
            ->leftJoin("posts", "challange_joins.post_id", "=", "posts.id")
            ->leftJoin("users", "posts.user_id", "=", "users.id")
            ->leftJoin("wilayah", "users.wilayah_id", "=", "wilayah.id")
            ->where("transactions.id", $request->trans_id)
            ->first(); 
        }

        if($cekwilayah->wilayah_id == $user->wilayah_id){


            if($ambiluser->status != "APPROVED"){

                $emails = $ambiluser->email;

                $details = count($request->transdetail_id);

                for($i=0; $i < $details; $i++){

                    $tran = Transaksi::select("transaction_details.product_id","transaction_details.post_id","transactions.user_id","transaction_details.qty","transaction_details.join_id")
                    ->join("transaction_details", "transactions.id", "=", "transaction_details.transaction_id")
                    ->where('transaction_details.id', $request->transdetail_id[$i])
                    ->first();

                    $tokens = TransaksiDetails::where(['id'=>$request->transdetail_id[$i]])
                    ->update(['status'=> 'SELESAI', 'petugas_id'=>$user->id]);

                }

                $cekstatus = Transaksi::join("transaction_details", "transactions.id", "=", "transaction_details.transaction_id")
                ->where([
                    ['transactions.id', '=', $request->trans_id],
                    ['transaction_details.status', '=', null],
                ])
                ->count();

                if($cekstatus == '0'){

                    $tokens = Transaksi::where(['id'=>$request->trans_id])
                    ->update(['status'=> 'APPROVED', 'petugas_id'=>$user->id]);

                    $hasil = '1';

                    $transactionx = TransaksiDetails::select("transaction_details.*","posts.name as post_name", "product.name as product_name","posts.type")
                    ->leftJoin("transactions", "transaction_details.transaction_id", "=", "transactions.id")
                    ->leftJoin("posts", "transaction_details.post_id", "=", "posts.id")
                    ->leftJoin("product", "transaction_details.product_id", "=", "product.id")
                    ->where("transactions.id", $request->trans_id)
                    ->get();

                } else {

                    $transactionz = array(    
                        'status' => 'belumselesai',
                    );

                }

            } else {

                $transactionz = array(     
                    'status' => 'kadaluarsa',
                );

                return response()->json($transactionz);

            }

        } else {

            $transactionz = array(     
                'status' => 'bedawilayah',
            );

            return response()->json($transactionz);
        }

        
    }

    public function konfirmasireedem(Request $request)
    {
    	date_default_timezone_set('Asia/Jakarta');
    	$timestamp = date('Y-m-d H:i:s');

    	$notif = SendNotif::where("id", $request->notif_id)
    	->first();

        $user = Auth::user();

        $ambiluser = Users::where("id", $user->id)
        ->first();

        $emails = $ambiluser->email;

    	$tokens = SendNotif::where(['id'=>$request->notif_id])
       	->update(['flag'=>'r']);

    	if($timestamp > $notif->expired){

        	$hasil = '0';

    	} else {

    		$tokens = Transaksi::where(['id'=>$request->transaction_id])
        	->update(['status'=> 'APPROVED']);

        	$trans = Transaksi::select("transaction_details.product_id","transaction_details.post_id","transactions.user_id","transaction_details.qty")
        	->join("transaction_details", "transactions.id", "=", "transaction_details.transaction_id")
        	->where('transaction_id', $request->transaction_id)
        	->first();

        	$saldo = Saldo::select("sisa")
        	->where([
	            ['user_id', '=', $trans->user_id],
	            ['post_id', '=', $trans->post_id],
	            ['product_id', '=', $trans->product_id],
                ['status', '=', null],
	        ])
	        ->orderBy("id", "desc")
	        ->first();

	        $sisa = $saldo->sisa - $trans->qty;

        	$transdet = new Saldo();
	        $transdet->user_id = $trans->user_id;
	        $transdet->product_id = $trans->product_id;
	        $transdet->transaction_id = $request->transaction_id;
	        $transdet->post_id = $trans->post_id;
	        $transdet->before = $saldo->sisa;
	        $transdet->sisa = $sisa;
	        $transdet->save();

        	$hasil = '1';

            $prods = Product::where("id", $trans->product_id)
            ->first();

            $post = Posts::where("id", $trans->post_id)
            ->first();

            try{
                Mail::send('email.reedem', ['nama' => $ambiluser->name, 'post' => $post->name, 'type' => $post->type, 'qty' => $trans->qty, 'produk' => $prods->name], function ($message) use ($emails)
                {
                    $message->subject('Anda Melakukan Reedem Saldo');
                    $message->from('admin@tomxperience.id', 'Admin Tomxperience.id');
                    $message->to($emails);
                });
                return back()->with('alert-success','Berhasil Kirim Email');
            }
            catch (Exception $e){
                return response (['status' => false,'errors' => $e->getMessage()]);
            }


    	}

    	return response()->json($hasil);
    }

    public function keranjangreedem(Request $request)
    {

        date_default_timezone_set('Asia/Jakarta');
        $user = Auth::user();

        $reedemsnya = ReedemKeranjang::select("reedem.*")
        ->leftJoin("saldo", "reedem.saldo_id", "=", "saldo.id")
        ->where("saldo.user_id", $user->id)
        ->first();

        if($reedemsnya){

            if($reedemsnya->tab != $request->tab){

                $delete = ReedemKet::where("user_id", $user->id)
                ->delete();

                $delete = ReedemKeranjang::leftJoin("saldo", "reedem.saldo_id", "=", "saldo.id")
                ->where([
                    ['saldo.user_id', '=', $user->id],
                    ['tab', '!=', $request->tab],
                ])
                ->delete();

            }
        }

        $cari = Saldo::where([
            ['user_id', '=', $user->id],
            ['post_id', '=', $request->post_id],
        ])
        ->orderBy("id", "desc")
        ->first();

        $cekreedem = ReedemKeranjang::where("saldo_id", $cari->id)
        ->first();

        if(!$cekreedem){

            $simpanreedem = new ReedemKeranjang();
            $simpanreedem->saldo_id = $cari->id;
            $simpanreedem->qty = $request->qty;
            $simpanreedem->tab = $request->tab;
            $simpanreedem->save();


        } else {

            $simpanreedem = ReedemKeranjang::where(['saldo_id'=>$cari->id])
            ->update(['qty'=> $request->qty, 'tab'=> $request->tab]);

        }

        return response()->json($simpanreedem);

    }

    public function keranjang()
    {
        date_default_timezone_set('Asia/Jakarta');
        $user = Auth::user();

        $keranjangs = ReedemKeranjang::select("reedem.*","product.name as prod_name","posts.name as post_name","posts.img as img_name","wilayah.name as wilayah_name","posts.type","posts.harga_act","posts.po")
        ->leftJoin("saldo", "reedem.saldo_id", "=", "saldo.id")
        ->leftJoin("product", "saldo.product_id", "=", "product.id")
        ->leftJoin("posts", "saldo.post_id", "=", "posts.id")
        ->leftJoin("users", "posts.user_id", "=", "users.id")
        ->leftJoin("wilayah", "users.wilayah_id", "=", "wilayah.id")
        ->where([
            ['saldo.user_id', '=', $user->id],
            ['reedem.tab', '=', 'cod'],
        ])
        ->get();

        $deliveries = ReedemKeranjang::select("reedem.*","product.name as prod_name","posts.name as post_name","imgpost.name as img_name","wilayah.name as wilayah_name","posts.type","posts.harga_act","posts.po")
        ->leftJoin("saldo", "reedem.saldo_id", "=", "saldo.id")
        ->leftJoin("product", "saldo.product_id", "=", "product.id")
        ->leftJoin("posts", "saldo.post_id", "=", "posts.id")
        ->leftJoin("post_images", "posts.id", "=", "post_images.post_id")
        ->leftJoin("imgpost", "post_images.img_id", "=", "imgpost.id")
        ->leftJoin("users", "posts.user_id", "=", "users.id")
        ->leftJoin("wilayah", "users.wilayah_id", "=", "wilayah.id")
        ->where([
            ['saldo.user_id', '=', $user->id],
            ['reedem.tab', '=', 'delivery'],
        ])
        ->get();

        $adatrans = Transaksi::where([
            ['user_id', '=', $user->id],
            ['type', '=', 'out'],
            ['status', '=', 'REEDEM'],
        ])
        ->first();

        if($adatrans){

            $sudahtour = Tours::where(['user_id'=>$user->id])
            ->update(['keranjangambil'=>'1']);
        }

        $ket = ReedemKet::where("user_id", $user->id)
        ->first();

        $tour = Tours::where("user_id", $user->id)
        ->first();

        return view('content.keranjangreedem.index', compact('keranjangs','ket','deliveries','adatrans','tour'));

    }

    public function reedemcount(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');

        $user = Auth::user();

        $ada = ReedemKeranjang::leftJoin("saldo", "reedem.saldo_id", "=", "saldo.id")
        ->where([
            ['saldo.user_id', '=', $user->id],
            ['saldo.status', '=', null],
        ])
        ->count();
        
        return response()->json($ada);
    }

    public function reedemdestroy(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');

        $user = Auth::user();

        $ada = ReedemKeranjang::where("id", $request->id)
        ->delete();

        $banyak = ReedemKeranjang::select("reedem.*")
        ->leftJoin("saldo", "reedem.saldo_id", "=", "saldo.id")
        ->where("saldo.user_id", $user->id)
        ->get();

        if($banyak->count() == 0){

            $delete = ReedemKet::where("user_id", $user->id)
            ->delete();

        }
        
        return response()->json($ada);
    }

    public function lihatsaldo(Request $request)
    {

        $user = Auth::user();

        $saldo = Saldo::where([
            ['user_id', '=', $user->id],
            ['post_id', '=', $request->post_id],
        ])
        ->orderBy("saldo.id","desc")
        ->first();

        return response()->json($saldo);

    }

    public function keranjangreedemdeals(Request $request)
    {

        date_default_timezone_set('Asia/Jakarta');
        $user = Auth::user();

        $cekreedem = ReedemKeranjang::where("saldo_id", $request->saldo_id)
        ->first();

        if(!$cekreedem){

            $simpanreedem = new ReedemKeranjang();
            $simpanreedem->saldo_id = $request->saldo_id;
            $simpanreedem->qty = $request->qty;
            $simpanreedem->save();


        } else {

            $simpanreedem = ReedemKeranjang::where(['saldo_id'=>$request->saldo_id])
            ->update(['qty'=> $request->qty]);

        }

        return response()->json($simpanreedem);

    }

    public function cekwilayah(){

        $user = Auth::user();

        $wilayah = ReedemKeranjang::select("wilayah.name")
        ->leftJoin("saldo", "reedem.saldo_id", "=", "saldo.id")
        ->leftJoin("posts", "saldo.post_id", "=", "posts.id")
        ->leftJoin("users", "posts.user_id", "=", "users.id")
        ->leftJoin("wilayah", "users.wilayah_id", "=", "wilayah.id")
        ->where("saldo.user_id", $user->id)
        ->where([
            ['saldo.user_id', '=', $user->id],
            ['saldo.status', '=', NULL],
        ])
        ->distinct()
        ->get();

        $count = $wilayah->count();

        return response()->json($count);

    }

    public function proses(){

        $user = Auth::user();

        $wilayah = ReedemKeranjang::select("wilayah.*")
        ->leftJoin("saldo", "reedem.saldo_id", "=", "saldo.id")
        ->leftJoin("posts", "saldo.post_id", "=", "posts.id")
        ->leftJoin("users", "posts.user_id", "=", "users.id")
        ->leftJoin("wilayah", "users.wilayah_id", "=", "wilayah.id")
        ->where([
            ['saldo.user_id', '=', $user->id],
            ['saldo.status', '=', NULL],
        ])
        ->first();

        $petugas = Users::select("fcm_token")
        ->where([
            ['role_id', '=', '3'],
            ['wilayah_id', '=', $wilayah->id],
        ])
        ->get();

        $keranjang = ReedemKeranjang::select("saldo.*","reedem.qty")
        ->leftJoin("saldo", "reedem.saldo_id", "=", "saldo.id")
        ->where([
            ['saldo.user_id', '=', $user->id],
            ['tab', '!=', 'delivery'],
        ])
        ->get();

        $uuid = Uuid::generate();
        $code = substr($uuid,0,8);

        $codex = date('d').$code;

        $getket = ReedemKet::where("user_id", $user->id)
        ->first();

        $trans = new Transaksi();
        $trans->uuid = $codex;
        $trans->user_id = $user->id;
        $trans->type = 'out';
        $trans->status = 'REEDEM';
        $trans->ket = $getket->ket != null ? $getket->ket : null;
        $trans->plan = $getket->plan != null ? $getket->plan : null;
        $trans->save();

        if($getket){

            $dels = ReedemKet::where("user_id", $user->id)
            ->delete();

        }

        foreach ($keranjang as $kranjang) {

            $transdet = new TransaksiDetails();
            $transdet->transaction_id = $trans->id;
            $transdet->post_id = $kranjang->post_id;
            $transdet->product_id = $kranjang->product_id;
            $transdet->qty = $kranjang->qty;
            $transdet->save();

        }

        $transactionx = TransaksiDetails::select("transaction_details.*","posts.name as post_name", "product.name as product_name","posts.type","transactions.user_id")
        ->leftJoin("transactions", "transaction_details.transaction_id", "=", "transactions.id")
        ->leftJoin("posts", "transaction_details.post_id", "=", "posts.id")
        ->leftJoin("product", "transaction_details.product_id", "=", "product.id")
        ->where("transactions.id", $trans->id)
        ->get();

        foreach ($transactionx as $tran) {

            $saldoc = Saldo::select("sisa")
            ->where([
                ['user_id', '=', $tran->user_id],
                ['post_id', '=', $tran->post_id],
                ['product_id', '=', $tran->product_id],
                ['status', '=', null],
            ])
            ->orderBy("id", "desc")
            ->first();

            $sisa = $saldoc->sisa - $tran->qty;

            $transdet = new Saldo();
            $transdet->user_id = $tran->user_id;
            $transdet->product_id = $tran->product_id;
            $transdet->transaction_id = $trans->id;
            $transdet->post_id = $tran->post_id;
            $transdet->before = $saldoc->sisa;
            $transdet->sisa = $sisa;
            $transdet->save();

        }

        $emails = $user->email;

        $hapusreedemkeranjang = ReedemKeranjang::leftJoin("saldo", "reedem.saldo_id", "=", "saldo.id")
        ->where("saldo.user_id", $user->id)
        ->delete();

        try{
            Mail::send('email.keranjangreedem', ['nama' => $user->name,'wilayah' => $wilayah->name, 'alamat' => $wilayah->alamat, 'trans' => $transactionx, 'type' => 'biasa'], function ($message) use ($emails)
            {
                $message->subject('Segera Selesaikan Reedem Anda ke Site');
                $message->from('admin@tomxperience.id', 'Admin Tomxperience.id');
                $message->to($emails);
            });

        }
        catch (Exception $e){
            return response (['status' => false,'errors' => $e->getMessage()]);
        }

        return response()->json($petugas);

    }

    public function catatan(Request $request)
    {
        $user = Auth::user();

        $ada = ReedemKet::where("user_id", $user->id)
        ->first();

        if(!$ada){

            $transdet = new ReedemKet();
            $transdet->user_id = $user->id;
            $transdet->ket = $request->ket;
            $transdet->save();

        } else {

            $updates = ReedemKet::where(['user_id'=>$user->id])
            ->update(['ket'=> $request->ket]);

        }
        
        return response()->json($request->ket);

    }

    public function planreedem(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $hariini = date('Y-m-d H:i');
        $haritgl = date('Y-m-d');

        $hari = date('d F Y H:i', strtotime($request->tgl.' '.$request->jam));

        if(strtotime($hariini) > strtotime($hari)){

            $data = '1';

            $transactionz = array(    
                'hari' => $hari, 
                'status' => $data,
            );

        } else {

            $user = Auth::user();
            $data = '0';

            $cekadapo = ReedemKeranjang::select("posts.id")
            ->leftJoin("saldo", "reedem.saldo_id", "=", "saldo.id")
            ->leftJoin("posts", "saldo.post_id", "=", "posts.id")
            ->where([
                ['saldo.user_id', '=', $user->id],
                ['posts.po', '=', 'yes'],
            ])
            ->get();

            $ada = ReedemKet::where("user_id", $user->id)
            ->first();

            $cekwaktu = ReedemKeranjang::select("wilayah.*")
            ->leftJoin("saldo", "reedem.saldo_id", "=", "saldo.id")
            ->leftJoin("posts", "saldo.post_id", "=", "posts.id")
            ->leftJoin("users", "posts.user_id", "=", "users.id")
            ->leftJoin("wilayah", "users.wilayah_id", "=", "wilayah.id")
            ->where("saldo.user_id", $user->id)
            ->first();

            if($cekadapo->count() == '0'){

                $planing = date('H:i', strtotime($request->tgl.' '.$request->jam));

                if(strtotime($planing) >= strtotime($cekwaktu->jam_masuk) &&  strtotime($planing) <= strtotime($cekwaktu->jam_tutup)){

                    $waktu = '1';

                    if(!$ada){

                        $transdet = new ReedemKet();
                        $transdet->user_id = $user->id;
                        $transdet->plan = $request->tgl.' '.$request->jam;
                        $transdet->save();

                    } else {

                        $updates = ReedemKet::where(['user_id'=>$user->id])
                        ->update(['plan'=> $request->tgl.' '.$request->jam]);

                    }

                } else {

                    $waktu = '0';

                }

                $bolehpo = '1';


            } else {

                if($request->tgl == $haritgl){

                    $bolehpo = '0';
                    $waktu = '0';

                } else {

                    $planing = date('H:i', strtotime($request->tgl.' '.$request->jam));

                    if(strtotime($planing) >= strtotime($cekwaktu->jam_masuk) &&  strtotime($planing) <= strtotime($cekwaktu->jam_tutup)){

                        $waktu = '1';

                        if(!$ada){

                            $transdet = new ReedemKet();
                            $transdet->user_id = $user->id;
                            $transdet->plan = $request->tgl.' '.$request->jam;
                            $transdet->save();

                        } else {

                            $updates = ReedemKet::where(['user_id'=>$user->id])
                            ->update(['plan'=> $request->tgl.' '.$request->jam]);

                        }

                    } else {

                        $waktu = '0';

                    }

                    $bolehpo = '1';
                    

                }
                

            }

            $transactionz = array(    
                'hari' => $hari, 
                'status' => $data,
                'waktu' => $waktu,
                'masuk' => $cekwaktu->jam_masuk,
                'tutup' => $cekwaktu->jam_tutup,
                'po' => $bolehpo,
            );

        }
        
        return response()->json($transactionz);

    }

    public function prosesdelivery(){

        $user = Auth::user();

        $wilayah = ReedemKeranjang::select("wilayah.*")
        ->leftJoin("saldo", "reedem.saldo_id", "=", "saldo.id")
        ->leftJoin("posts", "saldo.post_id", "=", "posts.id")
        ->leftJoin("users", "posts.user_id", "=", "users.id")
        ->leftJoin("wilayah", "users.wilayah_id", "=", "wilayah.id")
        ->where("saldo.user_id", $user->id)
        ->first();

        $keranjang = ReedemKeranjang::select("saldo.*","reedem.qty")
        ->leftJoin("saldo", "reedem.saldo_id", "=", "saldo.id")
        ->where([
            ['saldo.user_id', '=', $user->id],
            ['tab', '=', 'delivery'],
        ])
        ->get();

        $uuid = Uuid::generate();
        $code = substr($uuid,0,8);

        $codex = date('d').$code;

        $getket = ReedemKet::where("user_id", $user->id)
        ->first();

        $trans = new Transaksi();
        $trans->uuid = $codex;
        $trans->user_id = $user->id;
        $trans->type = 'out';
        $trans->status = 'REEDEM';
        $trans->ket = $getket->ket != null ? $getket->ket : null;
        $trans->plan = $getket->plan != null ? $getket->plan : null;
        $trans->alamat_id = $getket->alamat_id != null ? $getket->alamat_id : '';
        $trans->save();

        if($getket){

            $dels = ReedemKet::where("user_id", $user->id)
            ->delete();

        }

        foreach ($keranjang as $kranjang) {

            $transdet = new TransaksiDetails();
            $transdet->transaction_id = $trans->id;
            $transdet->post_id = $kranjang->post_id;
            $transdet->product_id = $kranjang->product_id;
            $transdet->qty = $kranjang->qty;
            $transdet->save();

        }



        $transactionx = TransaksiDetails::select("transaction_details.*","posts.name as post_name", "product.name as product_name","posts.type")
        ->leftJoin("transactions", "transaction_details.transaction_id", "=", "transactions.id")
        ->leftJoin("posts", "transaction_details.post_id", "=", "posts.id")
        ->leftJoin("product", "transaction_details.product_id", "=", "product.id")
        ->where("transactions.id", $trans->id)
        ->get();

        $emails = $user->email;

        $hapusreedemkeranjang = ReedemKeranjang::leftJoin("saldo", "reedem.saldo_id", "=", "saldo.id")
        ->where("saldo.user_id", $user->id)
        ->delete();

        try{
            Mail::send('email.keranjangreedem', ['nama' => $user->name,'wilayah' => $wilayah->name, 'alamat' => $wilayah->alamat, 'trans' => $transactionx, 'type' => 'delivery'], function ($message) use ($emails)
            {
                $message->subject('Anda Melakukan Reedem Delivery');
                $message->from('admin@tomxperience.id', 'Admin Tomxperience.id');
                $message->to($emails);
            });

            return response()->json($transactionx);
        }
        catch (Exception $e){
            return response (['status' => false,'errors' => $e->getMessage()]);
        }

    }

    public function reedemtoday(){

        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d');

        $user = Auth::user();

        $transs = Transaksi::select("transactions.*")
        ->leftJoin("transaction_details", "transactions.id", "=", "transaction_details.transaction_id")
        ->leftJoin("posts", "transaction_details.post_id", "=", "posts.id")
        ->leftJoin("users", "posts.user_id", "=", "users.id")
        ->where([
            ['users.wilayah_id', '=', $user->wilayah_id],
            ['transactions.status', '=', 'REEDEM'],
            ['transactions.alamat_id', '=', null],
        ])
        ->distinct()
        ->orderBy('transactions.id', 'asc')
        ->get();

        $transnexts = Transaksi::select("transactions.*")
        ->leftJoin("transaction_details", "transactions.id", "=", "transaction_details.transaction_id")
        ->leftJoin("posts", "transaction_details.post_id", "=", "posts.id")
        ->leftJoin("users", "posts.user_id", "=", "users.id")
        ->where([
            ['users.wilayah_id', '=', $user->wilayah_id],
            ['transactions.status', '=', 'REEDEM'],
            ['transactions.alamat_id', '=', null],
        ])
        ->whereDate('transactions.created_at', '=', Carbon::tomorrow('Asia/Jakarta'))
        ->distinct()
        ->orderBy('transactions.id', 'asc')
        ->get();

        $deliverys = Transaksi::select("transactions.*","wilayah.name as wilayah_name","orders.jam")
        ->leftJoin("transaction_details", "transactions.id", "=", "transaction_details.transaction_id")
        ->leftJoin("orders", "transactions.id", "=", "orders.transaction_id")
        ->leftJoin("posts", "transaction_details.post_id", "=", "posts.id")
        ->leftJoin("users", "posts.user_id", "=", "users.id")
        ->leftJoin("wilayah", "users.wilayah_id", "=", "wilayah.id")
        ->where([
            ['transactions.status', '!=', 'APPROVED'],
            ['transactions.alamat_id', '!=', null],
            ['wilayah.id', '=', $user->wilayah_id],
        ])
        ->where([
            ['transactions.status', '!=', 'CANCEL'],
            ['transactions.alamat_id', '!=', null],
            ['wilayah.id', '=', $user->wilayah_id],
        ])
        ->where([
            ['transactions.status', '!=', 'CANCELLED'],
            ['transactions.alamat_id', '!=', null],
            ['wilayah.id', '=', $user->wilayah_id],
        ])
        ->where([
            ['transactions.status', '!=', 'NOT APPROVED'],
            ['transactions.alamat_id', '!=', null],
            ['wilayah.id', '=', $user->wilayah_id],
        ])
        ->where([
            ['transactions.status', '!=', 'KADALUARSA'],
            ['transactions.alamat_id', '!=', null],
            ['wilayah.id', '=', $user->wilayah_id],
        ])
        ->distinct()
        ->orderBy("id","desc")
        ->get();

        return view('content.reedem.today', compact('transs','transnexts','deliverys'));

    }

    public function countreedem(){

        date_default_timezone_set('Asia/Jakarta');
        $user = Auth::user();

        $reedem = Transaksi::select("transactions.*")
        ->leftJoin("transaction_details", "transactions.id", "=", "transaction_details.transaction_id")
        ->leftJoin("posts", "transaction_details.post_id", "=", "posts.id")
        ->leftJoin("users", "posts.user_id", "=", "users.id")
        ->where([
            ['users.wilayah_id', '=', $user->wilayah_id],
            ['transactions.type', '=', 'out'],
            ['transactions.status', '=', 'REEDEM'],
            ['transactions.alamat_id', '=', null],
        ])
        ->whereDate('transactions.plan', Carbon::today())
        ->distinct()
        ->get();

        $transnexts = Transaksi::select("transactions.*")
        ->leftJoin("transaction_details", "transactions.id", "=", "transaction_details.transaction_id")
        ->leftJoin("posts", "transaction_details.post_id", "=", "posts.id")
        ->leftJoin("users", "posts.user_id", "=", "users.id")
        ->where([
            ['users.wilayah_id', '=', $user->wilayah_id],
            ['transactions.type', '=', 'out'],
            ['transactions.status', '=', 'REEDEM'],
            ['transactions.alamat_id', '=', null],
        ])
        ->whereDate('transactions.plan', '=', Carbon::tomorrow('Asia/Jakarta'))
        ->distinct()
        ->get();

        $deliverys = Transaksi::select("transactions.*","wilayah.name as wilayah_name","orders.jam")
        ->leftJoin("transaction_details", "transactions.id", "=", "transaction_details.transaction_id")
        ->leftJoin("orders", "transactions.id", "=", "orders.transaction_id")
        ->leftJoin("posts", "transaction_details.post_id", "=", "posts.id")
        ->leftJoin("users", "posts.user_id", "=", "users.id")
        ->leftJoin("wilayah", "users.wilayah_id", "=", "wilayah.id")
        ->where([
            ['transactions.status', '!=', 'APPROVED'],
            ['transactions.alamat_id', '!=', null],
            ['wilayah.id', '=', $user->wilayah_id],
        ])
        ->where([
            ['transactions.status', '!=', 'CANCEL'],
            ['transactions.alamat_id', '!=', null],
            ['wilayah.id', '=', $user->wilayah_id],
        ])
        ->where([
            ['transactions.status', '!=', 'CANCELLED'],
            ['transactions.alamat_id', '!=', null],
            ['wilayah.id', '=', $user->wilayah_id],
        ])
        ->where([
            ['transactions.status', '!=', 'NOT APPROVED'],
            ['transactions.alamat_id', '!=', null],
            ['wilayah.id', '=', $user->wilayah_id],
        ])
        ->where([
            ['transactions.status', '!=', 'KADALUARSA'],
            ['transactions.alamat_id', '!=', null],
            ['wilayah.id', '=', $user->wilayah_id],
        ])
        ->distinct()
        ->orderBy("id","desc")
        ->get();

        $jumlah = $reedem->count() + $transnexts->count() + $deliverys->count();

        return response()->json($jumlah);

    }

    public function reedemdelivery(){

        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d');

        $user = Auth::user();

        $transs = Transaksi::select("transactions.*","wilayah.name as wilayah_name","alamat.judul","alamat.alamat","regencies.name as regency_name","provinces.name as prov_name")
        ->leftJoin("transaction_details", "transactions.id", "=", "transaction_details.transaction_id")
        ->leftJoin("posts", "transaction_details.post_id", "=", "posts.id")
        ->leftJoin("users", "posts.user_id", "=", "users.id")
        ->leftJoin("wilayah", "users.wilayah_id", "=", "wilayah.id")
        ->leftJoin("alamat", "transactions.alamat_id", "=", "alamat.id")
        ->leftJoin("regencies", "alamat.regency_id", "=", "regencies.id")
        ->leftJoin("provinces", "regencies.province_id", "=", "provinces.id")
        ->where([
            ['transactions.type', '=', 'out'],
            ['transactions.status', 'LIKE', '%REEDEM%'],
            ['transactions.alamat_id', '!=', null],
        ])
        ->distinct()
        ->orderBy('transactions.id', 'desc')
        ->get();

        

        return view('content.reedem.delivery', compact('transs'));

    }

    public function countdelivery(){

        $user = Auth::user();

        $reedem = Transaksi::select("transactions.*","wilayah.name as wilayah_name")
        ->leftJoin("transaction_details", "transactions.id", "=", "transaction_details.transaction_id")
        ->leftJoin("posts", "transaction_details.post_id", "=", "posts.id")
        ->leftJoin("users", "posts.user_id", "=", "users.id")
        ->leftJoin("wilayah", "users.wilayah_id", "=", "wilayah.id")
        ->where([
            ['transactions.type', '=', 'out'],
            ['transactions.status', '=', 'REEDEM'],
            ['transactions.alamat_id', '!=', null],
        ])
        ->distinct()
        ->get();

        return response()->json($reedem);

    }

    public function setujudelivery(Request $request){

        $tokens = Transaksi::where(['id'=>$request->id])
        ->update(['status'=> 'REEDEM DISETUJUI']);

        $users = Transaksi::select("users.*")
        ->leftJoin("users", "transactions.user_id", "=", "users.id")
        ->where("transactions.id", $request->id)
        ->first();

        return response()->json($users);

    }

    public function tolakdelivery(Request $request){

        $tokens = Transaksi::where(['id'=>$request->id])
        ->update(['status'=> 'DITOLAK']);

        $users = Transaksi::select("users.*")
        ->leftJoin("users", "transactions.user_id", "=", "users.id")
        ->where("transactions.id", $request->id)
        ->first();

        return response()->json($users);

    }

    public function cekreedem(){

        $user = Auth::user();

        $cek = ReedemKet::where("user_id", $user->id)
        ->first();

        if(!$cek){

            $ada = '0';

        } else {

            $ada = '1';

        }

        $transactionz = array(    
            'plan' => $ada, 
        );

        return response()->json($transactionz);

    }

    public function updateplan(Request $request){

        $trans = Transaksi::findOrFail($request->id);
        $trans->plan = $request->tgl.' '.$request->jam;
        $trans->save();

        return response()->json($trans);

    }

    public function notifpetugas(Request $request){

        $trans = Users::select('fcm_token','name')
        ->where([
            ['wilayah_id', '=', $request->wilayah_id],
            ['role_id', '=', '3'],
        ])
        ->get();

        return response()->json($trans);

    }

    public function reedemready(Request $request){

        $trans = Transaksi::findOrFail($request->id);
        $trans->ready = 'yes';
        $trans->save();

        $users = Transaksi::select("users.*")
        ->leftJoin("users", "transactions.user_id", "=", "users.id")
        ->where("transactions.id", $request->id)
        ->first();

        $transactionz = array(    
            'fcm' => $users->fcm_token, 
            'name' => $users->name,
        );

        return response()->json($transactionz);

    }

    public function reedemselesai(Request $request){

        date_default_timezone_set('Asia/Jakarta');
        $user = Auth::user();

        $trans = Transaksi::findOrFail($request->id);
        $trans->status = 'APPROVED';
        $trans->petugas_id = $user->id;
        $trans->save();

        $transak = Transaksi::where("id", $request->id)
        ->first();

        $cekmember = UserMembers::where("member_id", $transak->user_id)
        ->first();

        if(!$cekmember){

            $create = new UserMembers();
            $create->member_id = $transak->user_id;
            $create->user_id = $user->id;
            $create->transaction_id = $transak->id;
            $create->save();

        }

        return response()->json($trans);

    }

    public function scantimbangan(Request $request){

        date_default_timezone_set('Asia/Jakarta');

        $tokens = OrderDetails::where(['id'=>$request->id])
        ->update(['timbangan'=> $request->amount]);

        return response()->json(1);

    }

    public function scanhapus(Request $request){

        date_default_timezone_set('Asia/Jakarta');

        $tokens = OrderDetails::where(['id'=>$request->id])
        ->update(['timbangan'=> NULL]);

        return response()->json(1);

    }

    public function showqris(Request $request){

        date_default_timezone_set('Asia/Jakarta');
        $user = Auth::user();

        $transx = Transaksi::where("uuid", $request->uuid)
        ->first();

        if($transx->cash == NULL){
            $updatexx = Transaksi::where(['id'=>$transx->id])
            ->update(['wilayah_id'=>$user->wilayah_id, 'created_at' => date('Y-m-d H:i:s')]);
        } 

        // === MENJADI MEMBER PETUGAS ====

        $cekmember = UserMembers::where("member_id", $transx->user_id)
        ->first();

        if(!$cekmember){

            $cekregistered = Users::where("google_id", NULL)
            ->where("no_hp", NULL)
            ->where("id", $transx->user_id)
            ->first();

            if(!$cekregistered){

                $create = new UserMembers();
                $create->member_id = $transx->user_id;
                $create->user_id = $user->id;
                $create->transaction_id = $transx->id;
                $create->save();

            }

        }

        if($transx->status == "APPROVED" && $transx->cash == NULL){

            $data = 2;

            $transxx = Transaksi::select("orders.qris","transactions.uuid","orders.expired_at")
            ->leftJoin("orders", "transactions.id", "=", "orders.transaction_id")
            ->where("transactions.uuid",$request->uuid)
            ->first();

        } else {

            // ==== CEK VOUCHER APA ====
            $voucher = Order::select("vouchers.amount","voucher_details.id","orders.id as order_id","voucher_details.voucher_id")
            ->leftJoin("voucher_details", "orders.voucherdet_id", "=", "voucher_details.id")
            ->leftJoin("vouchers", "voucher_details.voucher_id", "=", "vouchers.id")
            ->where("transaction_id", $transx->id)
            ->where("voucherdet_id", '!=', NULL)
            ->where("voucher_details.status", '=', NULL)
            ->where("vouchers.product", '=', "khusus")
            ->first();

            $voucherbiasa = Order::select("vouchers.amount","voucher_details.id","orders.id as order_id","vouchers.jenis")
            ->leftJoin("voucher_details", "orders.voucherdet_id", "=", "voucher_details.id")
            ->leftJoin("vouchers", "voucher_details.voucher_id", "=", "vouchers.id")
            ->where("transaction_id", $transx->id)
            ->where("voucherdet_id", '!=', NULL)
            ->where("voucher_details.status", '=', NULL)
            ->first();

            if($voucher){

                $vouchernya = Vouchers::where("id", $voucher->voucher_id)
                ->first();

                $vouc = explode(",", $vouchernya->wilayah);

                $voucwilayah = Users::select("id")
                ->whereIn('wilayah_id', $vouc)
                ->where("id", $user->id)
                ->first();

                // == UPDATE WILAYAH ==
                $updatesss = Transaksi::where(['id'=>$transx->id])
                ->update(['wilayah_id'=>$user->wilayah_id]);

                $postx = Posts::select("posts.id")
                ->leftJoin("users", "posts.user_id", "=", "users.id")
                ->where([
                    ['users.wilayah_id', '=', $user->wilayah_id],
                    ['posts.code_id', '=', $vouchernya->codes],
                ])
                ->first();

                $updatesss2 = TransaksiDetails::where(['transaction_id'=>$transx->id])
                ->update(['post_id'=>$postx->id]);

                $updatesss3 = OrderDetails::where(['order_id'=>$voucher->order_id])
                ->update(['post_id'=>$postx->id]);

                $cekwilayah = Transaksi::select("users.wilayah_id")
                ->leftJoin("transaction_details", "transactions.id", "=", "transaction_details.transaction_id")
                ->leftJoin("posts", "transaction_details.post_id", "=", "posts.id")
                ->leftJoin("users", "posts.user_id", "=", "users.id")
                ->where("transactions.id", $transx->id)
                ->first();

            } else {

                $cekwilayah = Transaksi::select("users.wilayah_id")
                ->leftJoin("transaction_details", "transactions.id", "=", "transaction_details.transaction_id")
                ->leftJoin("posts", "transaction_details.post_id", "=", "posts.id")
                ->leftJoin("users", "posts.user_id", "=", "users.id")
                ->where("transactions.id", $transx->id)
                ->first();
            }

            if($cekwilayah->wilayah_id == $user->wilayah_id){

                $transaction = Transaksi::select("transactions.*","orders.amount","users.name as user_name","users.email","orders.qris","orders.status as order_status","orders.expired_at")
                ->leftJoin("orders", "transactions.id", "=", "orders.transaction_id")
                ->leftJoin("users", "transactions.user_id", "=", "users.id")
                ->where("transactions.uuid",$request->uuid)
                ->first();

                $serverkey = 'Mid-server-T-bYnWxY1Q2QjhN_kl5nddUX:';
                $base = base64_encode($serverkey);
                $auth = 'Basic '.$base;

                if($transaction->qris == NULL){

                    if($transaction->order_status == "pending"){

                        $transaction = Transaksi::select("transactions.*","orders.amount","users.name as user_name","users.email","orders.qris","orders.status as order_status")
                        ->leftJoin("orders", "transactions.id", "=", "orders.transaction_id")
                        ->leftJoin("users", "transactions.user_id", "=", "users.id")
                        ->where("transactions.uuid",$request->uuid)
                        ->first();

                        $kranjang22 = TransaksiDetails::select("post_codes.kode as id", "posts.harga_act as price","transaction_details.qty as quantity","product.name as name")
                        ->leftJoin("posts", "transaction_details.post_id", "=", "posts.id")
                        ->leftJoin("post_codes", "posts.code_id", "=", "post_codes.id")
                        ->leftJoin("product", "posts.product_id", "=", "product.id")
                        ->where('transaction_details.transaction_id', '=', $transaction->id)
                        ->get();

                        $jayParsedAry2 = [
                            "payment_type"=> "qris",
                            "transaction_details"=> [
                                "gross_amount"=> $transaction->amount,
                                "order_id"=> $transaction->uuid,
                            ],
                            "customer_details"=> [
                                "email"=> $transaction->email,
                                "first_name"=> $transaction->user_name
                            ]
                         ]; 

                        $output = self::$client->request('POST', self::$hostUrl . '/v2/charge', [
                            'headers' => [
                                'Content-Type'  => 'application/json',
                                'Accept'  => 'application/json',
                                'Authorization' => $auth,
                            ],
                            'json' => $jayParsedAry2,
                        ]);

                        $output = json_decode($output->getBody(), true);

                        $qris = $output['actions'][0]['url'];

                        $expiredtime = date('Y-m-d H:i:s',strtotime('+10 minutes'));

                        $updateorder = Order::where(['transaction_id'=>$transaction->id])
                        ->update(['qris'=> $qris,'type_bayar' => 'QRIS','expired_at' => $expiredtime]);

                        $updateorder2 = Transaksi::where(['id'=>$transaction->id])
                        ->update(['petugas_id'=> $user->id]);

                        $transxx = Transaksi::select("orders.qris","transactions.uuid")
                        ->leftJoin("orders", "transactions.id", "=", "orders.transaction_id")
                        ->where("transactions.uuid",$transaction->uuid)
                        ->first();



                    }

                } else {

                    if($transaction->order_status == "pending"){

                        if(strtotime($transaction->expired_at) > strtotime(date('Y-m-d H:i:s'))){

                            $transxx = Transaksi::select("orders.qris","transactions.uuid","orders.expired_at")
                            ->leftJoin("orders", "transactions.id", "=", "orders.transaction_id")
                            ->where("transactions.uuid",$transaction->uuid)
                            ->first();

                        } else {

                            $output = self::$client->request('POST', self::$hostUrl . '/v2/'.$transaction->uuid.'/expire', [
                                'headers' => [
                                    'Content-Type'  => 'application/json',
                                    'Accept'  => 'application/json',
                                    'Authorization' => $auth,
                                ],
                            ]);

                            $updateorder2 = Order::where(['transaction_id'=>$transaction->id])
                            ->update(['qris'=> NULL]);


                            $transaction = Transaksi::select("transactions.*","orders.amount","users.name as user_name","users.email","orders.qris","orders.status as order_status")
                            ->leftJoin("orders", "transactions.id", "=", "orders.transaction_id")
                            ->leftJoin("users", "transactions.user_id", "=", "users.id")
                            ->where("transactions.uuid",$request->uuid)
                            ->first();

                            $kranjang22 = TransaksiDetails::select("post_codes.kode as id", "posts.harga_act as price","transaction_details.qty as quantity","product.name as name")
                            ->leftJoin("posts", "transaction_details.post_id", "=", "posts.id")
                            ->leftJoin("post_codes", "posts.code_id", "=", "post_codes.id")
                            ->leftJoin("product", "posts.product_id", "=", "product.id")
                            ->where('transaction_details.transaction_id', '=', $transaction->id)
                            ->get();

                            $jayParsedAry2 = [
                                "payment_type"=> "qris",
                                "transaction_details"=> [
                                    "gross_amount"=> $transaction->amount,
                                    "order_id"=> $transaction->uuid,
                                ],
                                "customer_details"=> [
                                    "email"=> $transaction->email,
                                    "first_name"=> $transaction->user_name
                                ]
                             ]; 

                             $output = self::$client->request('POST', self::$hostUrl . '/v2/charge', [
                                'headers' => [
                                    'Content-Type'  => 'application/json',
                                    'Accept'  => 'application/json',
                                    'Authorization' => $auth,
                                ],
                                'json' => $jayParsedAry2,
                            ]);

                            $output = json_decode($output->getBody(), true);

                            $qris = $output['actions'][0]['url'];

                            $expiredtime = date('Y-m-d H:i:s',strtotime('+10 minutes'));

                            $updateorder = Order::where(['transaction_id'=>$transaction->id])
                            ->update(['qris'=> $qris,'type_bayar' => 'QRIS','status' => 'pending','expired_at' => $expiredtime]);

                            $updateorder2 = Transaksi::where(['id'=>$transaction->id])
                            ->update(['petugas_id'=> $user->id]);

                            $transxx = Transaksi::select("orders.qris","transactions.uuid")
                            ->leftJoin("orders", "transactions.id", "=", "orders.transaction_id")
                            ->where("transactions.uuid",$transaction->uuid)
                            ->first();


                        }


                    } else {

                        $transaction = Transaksi::select("transactions.*","orders.amount","users.name as user_name","users.email","orders.qris","orders.status as order_status")
                        ->leftJoin("orders", "transactions.id", "=", "orders.transaction_id")
                        ->leftJoin("users", "transactions.user_id", "=", "users.id")
                        ->where("transactions.uuid",$request->uuid)
                        ->first();

                        $kranjang22 = TransaksiDetails::select("post_codes.kode as id", "posts.harga_act as price","transaction_details.qty as quantity","product.name as name")
                        ->leftJoin("posts", "transaction_details.post_id", "=", "posts.id")
                        ->leftJoin("post_codes", "posts.code_id", "=", "post_codes.id")
                        ->leftJoin("product", "posts.product_id", "=", "product.id")
                        ->where('transaction_details.transaction_id', '=', $transaction->id)
                        ->get();

                        $jayParsedAry2 = [
                            "payment_type"=> "qris",
                            "transaction_details"=> [
                                "gross_amount"=> $transaction->amount,
                                "order_id"=> $transaction->uuid,
                            ],
                            "customer_details"=> [
                                "email"=> $transaction->email,
                                "first_name"=> $transaction->user_name
                            ]
                         ]; 

                         $output = self::$client->request('POST', self::$hostUrl . '/v2/charge', [
                            'headers' => [
                                'Content-Type'  => 'application/json',
                                'Accept'  => 'application/json',
                                'Authorization' => $auth,
                            ],
                            'json' => $jayParsedAry2,
                        ]);

                        $output = json_decode($output->getBody(), true);

                        $qris = $output['actions'][0]['url'];

                        $expiredtime = date('Y-m-d H:i:s',strtotime('+10 minutes'));

                        $updateorder = Order::where(['transaction_id'=>$transaction->id])
                        ->update(['qris'=> $qris,'type_bayar' => 'QRIS','status' => 'pending','expired_at' => $expiredtime]);

                        $updateorder2 = Transaksi::where(['id'=>$transaction->id])
                        ->update(['petugas_id'=> $user->id]);

                        $transxx = Transaksi::select("orders.qris","transactions.uuid","orders.expired_at")
                        ->leftJoin("orders", "transactions.id", "=", "orders.transaction_id")
                        ->where("transactions.uuid",$transaction->uuid)
                        ->first();

                    }

                }

                $data = 1;


            } else {

                $transxx = Transaksi::select("orders.qris","transactions.uuid","orders.expired_at")
                ->leftJoin("orders", "transactions.id", "=", "orders.transaction_id")
                ->where("transactions.uuid",$request->uuid)
                ->first();

                $data = 0;  

            }  

        } 

        $transxx = Transaksi::select("orders.qris","transactions.uuid","orders.expired_at")
        ->leftJoin("orders", "transactions.id", "=", "orders.transaction_id")
        ->where("transactions.uuid",$request->uuid)
        ->first();

        $awal  = strtotime(date('Y-m-d H:i:s'));
        $expired = strtotime($transxx->expired_at);
        $diff  = $expired - $awal;

        $jam   = floor($diff / (60 * 60));
        $menit = $diff - ( $jam * (60 * 60) );
        $detik = $diff % 60;

        $waktu = floor( $menit / 60 ).':'.$detik;


        return view('content.prosesreedem.qris', compact('transxx','data','waktu'));
        
    }

    public function bayarcash(Request $request){

        date_default_timezone_set('Asia/Jakarta');
        $user = Auth::user();

        $transx = Transaksi::where("id", $request->id)
        ->first();

        $updatexx = Transaksi::where(['id'=>$transx->id])
        ->update(['wilayah_id'=>$user->wilayah_id, 'created_at' => date('Y-m-d H:i:s')]);

        $updateorders = Order::where(['transaction_id'=>$transx->id])
        ->update(['type_bayar' => 'QRIS']);

        // ==== CEK VOUCHER APA ====
        $voucher = Order::select("vouchers.amount","voucher_details.id","orders.id as order_id","voucher_details.voucher_id")
        ->leftJoin("voucher_details", "orders.voucherdet_id", "=", "voucher_details.id")
        ->leftJoin("vouchers", "voucher_details.voucher_id", "=", "vouchers.id")
        ->where("transaction_id", $request->id)
        ->where("voucherdet_id", '!=', NULL)
        ->where("vouchers.product", '=', "khusus")
        ->first();

        $voucherbiasa = Order::select("vouchers.amount","voucher_details.id","orders.id as order_id","vouchers.type")
        ->leftJoin("voucher_details", "orders.voucherdet_id", "=", "voucher_details.id")
        ->leftJoin("vouchers", "voucher_details.voucher_id", "=", "vouchers.id")
        ->where("transaction_id", $request->id)
        ->where("voucherdet_id", '!=', NULL)
        ->where("voucher_details.status", '=', NULL)
        ->first();

        if($voucher){

            $vouchernya = Vouchers::where("id", $voucher->voucher_id)
            ->first();

            $vouc = explode(",", $vouchernya->wilayah);

            $voucwilayah = Users::select("id")
            ->whereIn('wilayah_id', $vouc)
            ->where("id", $user->id)
            ->first();

            $cekmasihada = VoucherDetails::where("voucher_id", $voucher->voucher_id)
            ->where("status", "selesai")
            ->count();
            
            if($vouchernya->total == $cekmasihada || $cekmasihada > $vouchernya->total){

                $data = 4;

            } else {

                if($voucwilayah){

                    // ==UPDATE VOUCHER DIAMBIL ==
                    $updates = VoucherDetails::where(['id'=>$voucher->id])
                    ->update(['status'=> 'selesai']);

                    // == UPDATE WILAYAH ==
                    $updatesss = Transaksi::where(['id'=>$request->id])
                    ->update(['wilayah_id'=>$user->wilayah_id]);

                    $postx = Posts::select("posts.id")
                    ->leftJoin("users", "posts.user_id", "=", "users.id")
                    ->where([
                        ['users.wilayah_id', '=', $user->wilayah_id],
                        ['posts.code_id', '=', $vouchernya->codes],
                    ])
                    ->first();

                    $updatesss2 = TransaksiDetails::where(['transaction_id'=>$request->id])
                    ->update(['post_id'=>$postx->id]);

                    $updatesss3 = OrderDetails::where(['order_id'=>$voucher->order_id])
                    ->update(['post_id'=>$postx->id]);

                    $cekwilayah = Transaksi::select("users.wilayah_id")
                    ->leftJoin("transaction_details", "transactions.id", "=", "transaction_details.transaction_id")
                    ->leftJoin("posts", "transaction_details.post_id", "=", "posts.id")
                    ->leftJoin("users", "posts.user_id", "=", "users.id")
                    ->where("transactions.id", $request->id)
                    ->first();

                    $updateorder2 = Transaksi::where(['id'=>$request->id])
                    ->update(['status'=> "APPROVED","cash"=>"yes", 'petugas_id'=>$user->id,'ket'=>"cash"]);

                    $data = 1;

                } else {

                    $data = 3;

                }

            }


        } else {

            $cekwilayah = Transaksi::select("users.wilayah_id")
            ->leftJoin("transaction_details", "transactions.id", "=", "transaction_details.transaction_id")
            ->leftJoin("posts", "transaction_details.post_id", "=", "posts.id")
            ->leftJoin("users", "posts.user_id", "=", "users.id")
            ->where("transactions.id", $request->id)
            ->first();

            if($cekwilayah->wilayah_id == $user->wilayah_id){

                $updateorder2 = Transaksi::where(['id'=>$request->id])
                ->update(['status'=> "APPROVED","cash"=>"yes", 'petugas_id'=>$user->id,'ket'=>"cash"]);

                if($voucherbiasa){

                    if($voucherbiasa->type != "fixed"){

                        // ==UPDATE VOUCHER DIAMBIL ==
                        $updates = VoucherDetails::where(['id'=>$voucherbiasa->id])
                        ->update(['status'=> 'selesai']);

                    }

                }

                $data = 1;


            } else {

                $data = 0;

            }

        }

        if($data == 1){

            $trandetails = TransaksiDetails::select("transactions.user_id","transaction_details.product_id","transaction_details.transaction_id","transaction_details.post_id","transaction_details.qty","posts.type")
            ->leftJoin("transactions", "transaction_details.transaction_id", "=", "transactions.id")
            ->leftJoin("posts", "transaction_details.post_id", "=", "posts.id")
            ->where("transaction_details.transaction_id", $transx->id)
            ->get();

            $orderan = Order::select("orders.*","users.email","users.fcm_token","users.name as username")
            ->leftJoin("transactions", "orders.transaction_id", "=", "transactions.id")
            ->leftJoin("users", "transactions.user_id", "=", "users.id")
            ->where("transaction_id", $transx->id)
            ->first();

            // ====== SELESAI ====

            foreach($trandetails as $details){

                // ===== DAPAT POIN =====

                $cekpost = Posts::select("post_codes.poin")
                ->leftJoin("post_codes", "posts.code_id", "=", "post_codes.id")
                ->where('posts.id', $details->post_id)
                ->first();

                $trsaldo = new TransSaldoPoin();
                $trsaldo->user_id = $details->user_id;
                $trsaldo->transaction_id = $details->transaction_id;
                $trsaldo->type = "in";
                $trsaldo->amount = $cekpost->poin * $details->qty;
                $trsaldo->save();

                $saldopoin = SaldoPoin::where("user_id", $details->user_id)
                ->orderBy("id", "desc")
                ->first();

                $saldonya = new SaldoPoin();
                $saldonya->transpoin_id = $trsaldo->id;
                $saldonya->user_id = $details->user_id;
                if(!$saldopoin){

                    $saldonya->before = '0';
                    $saldonya->sisa = $cekpost->poin * $details->qty;

                } else {

                    $saldonya->before = $saldopoin->sisa;
                    $saldonya->sisa = ($cekpost->poin * $details->qty) + $saldopoin->sisa;

                }
                $saldonya->save();

            }

            // === MENJADI MEMBER PETUGAS ====

            $cekmember = UserMembers::where("member_id", $transx->user_id)
            ->first();

            if(!$cekmember){

                $cekregistered = Users::where("google_id", NULL)
                ->where("no_hp", NULL)
                ->where("id", $transx->user_id)
                ->first();

                if(!$cekregistered){

                    $create = new UserMembers();
                    $create->member_id = $transx->user_id;
                    $create->user_id = $user->id;
                    $create->transaction_id = $request->id;
                    $create->save();

                }

            }


            // === DAPAT UNDIAN VOUCHER ====

            $totalbayar = (int)$orderan->amount;

            $undian = Undian::select("undians.*")
            ->whereDate("dari" ,"<=" ,date('Y-m-d'))
            ->whereDate("sampai" ,">=" ,date('Y-m-d'))
            ->where("nominal","<=", $totalbayar)
            ->first();

            if($undian){

                $dapat = $totalbayar / $undian->nominal;
                $dapat2 = floor($dapat);

                for($i=0; $i < $dapat2; $i++){

                    $uuid = Uuid::generate();
                    $code = substr($uuid,0,4);

                    $undvcr = new UndianVouchers();
                    $undvcr->undian_id = $undian->id;
                    $undvcr->transaction_id = $transx->id;
                    $undvcr->code = date('H').$code.date('i').$i;
                    $undvcr->save();

                }

            }
        }

        
        return response()->json($data);
    }


    public function bayarselesai(Request $request){

        date_default_timezone_set('Asia/Jakarta');
        $user = Auth::user();

        $transaction = Transaksi::select("transactions.*","orders.amount","users.name as user_name","users.email","orders.qris","orders.status as order_status")
        ->leftJoin("orders", "transactions.id", "=", "orders.transaction_id")
        ->leftJoin("users", "transactions.user_id", "=", "users.id")
        ->where("transactions.petugas_id",$user->id)
        ->where("transactions.status","APPROVED")
        ->where("transactions.type","in")
        ->where("transactions.cash",NULL)
        ->whereDate("transactions.created_at", $request->tanggal)
        ->get();

        $tanggalnya = $request->tanggal;

        return view('content.home.petugas.selesai', compact('transaction','tanggalnya'));
    }

    public function bayarpending(Request $request){

        date_default_timezone_set('Asia/Jakarta');
        $user = Auth::user();
        $tanggal = date('Y-m-d');

        $transaction = Transaksi::select("transactions.*","orders.amount","users.name as user_name","users.email","orders.qris","orders.status as order_status")
        ->leftJoin("orders", "transactions.id", "=", "orders.transaction_id")
        ->leftJoin("users", "transactions.user_id", "=", "users.id")
        ->where("transactions.petugas_id",$user->id)
        ->where("transactions.status","APPROVED")
        ->where("transactions.type","in")
        ->where("transactions.cash","yes")
        ->whereDate("transactions.created_at", $tanggal)
        ->get();

        $kemarin = Transaksi::select("transactions.*","orders.amount","users.name as user_name","users.email","orders.qris","orders.status as order_status")
        ->leftJoin("orders", "transactions.id", "=", "orders.transaction_id")
        ->leftJoin("users", "transactions.user_id", "=", "users.id")
        ->where("transactions.petugas_id",$user->id)
        ->where("transactions.status","APPROVED")
        ->where("transactions.type","in")
        ->where("transactions.cash","yes")
        ->whereDate("transactions.created_at",'<', $tanggal)
        ->get();

        $tanggalnya = $tanggal;

        return view('content.home.petugas.pending', compact('transaction','tanggalnya','kemarin'));
    }

    public function penjual(Request $request)
    {
        $user = Auth::user();

        $cek = TransactionInsentifs::where("transaction_id", $request->id)
        ->first();

        if(!$cek){

            $undvcr = new TransactionInsentifs();
            $undvcr->transaction_id = $request->id;
            $undvcr->name = $request->penjual;
            $undvcr->save();

        } else {

            $undvcr = TransactionInsentifs::where(['transaction_id'=>$request->id])
            ->update(['name'=>$request->penjual]);

        }
   
        return response()->json($undvcr);

    }

}
