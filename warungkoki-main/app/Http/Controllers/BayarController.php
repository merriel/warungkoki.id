<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Keranjang;
use App\KeranjangReedemPoint;
use App\Transaksi;
use App\SaldoUang;
use App\SaldoTrans;
use App\Services;
use App\Order;
use App\OrderDetails;
use App\TransaksiDetails;
use App\Saldo;
use App\Posts;
use App\SaldoPoin;
use App\TransSaldoPoin;
use App\Diskon;
use App\DiskonDetails;
use App\VoucherDetails;
use App\Undian;
use App\UndianVouchers;
use App\Users;
use App\Alamat;
use App\BracketProduct;
use Auth;
use DB;
use Mail;
use Uuid;
use GuzzleHttp\Client;

class BayarController extends Controller
{
    private static $hostUrl = 'https://api.midtrans.com';
    private static $client;

    public function __construct(){
        self::$client = new \GuzzleHttp\Client;
    }

    public function index()
    {
    	date_default_timezone_set('Asia/Jakarta');
		$date = date('Y-m-d');

		$usernyah = Auth::user();

        if(!$usernyah){
            $user = Users::where("clubsmart", csrf_token())
            ->first();
        } else {
            $user = Auth::user();
        }

        $service = Services::first();

		$keranjangs = Keranjang::select("posts.*","keranjang.qty","wilayah.name as wilayah_name","product.name as prod_name","retailers.name as retailer_name")
		->leftJoin("posts", "keranjang.post_id", "=", "posts.id")
        ->leftJoin("product", "posts.product_id", "=", "product.id")
        ->leftJoin("users", "posts.user_id", "=", "users.id")
        ->leftJoin("wilayah", "users.wilayah_id", "=", "wilayah.id")
        ->leftJoin("retailers", "keranjang.retailer_id", "=", "retailers.id")
        ->where([
            ['keranjang.user_id', '=', $user->id],
            ['voucherdet_id', '=', null],
            ['posts.type', '=', 'Products'],
        ])
		->get();

        $saldouang = SaldoUang::where("user_id", $user->id)
        ->orderBy("id", "desc")
        ->first();

        $adatrans = Transaksi::where("user_id", $user->id)
        ->first();
		
		$promo = Keranjang::select("posts.*")
		->leftJoin("posts", "keranjang.post_id", "=", "posts.id")
        ->where([
            ['keranjang.user_id', '=', $user->id],
            ['posts.jenis', '=', 'promo'],
            ['posts.type', '=', 'Products'],
        ])
		->first();

        if($user->pemegangsaham == 'yes'){

            $pemegangsaham = Services::where('type', 'pemegangsaham')
            ->first();

            $diskon = $pemegangsaham->biaya;

        } else {

            $diskon = 0;

        }

        $potongan = Keranjang::select('vouchers.*','voucher_details.kode','keranjang.id as kranjang_id')
        ->leftJoin("voucher_details", "keranjang.voucherdet_id", "=", "voucher_details.id")
        ->leftJoin("vouchers", "voucher_details.voucher_id", "=", "vouchers.id")
        ->where([
            ['keranjang.user_id', '=', $user->id],
            ['voucherdet_id', '!=', NULL],
        ])
        ->first();

        if(!$usernyah){

            $cektrans = Transaksi::select("transactions.*","wilayah.uuid as wilayah_uuid")
            ->leftJoin("wilayah", "transactions.wilayah_id", "=", "wilayah.id")
            ->where("user_id", $user->id)
            ->orderBy("id","desc")
            ->first();

            if($cektrans){

                if($cektrans->status == "REEDEM"){

                    return redirect('/users/transaksi/detail2?uuid='.$cektrans->uuid);

                } else {

                    return view('content.pembayaran.index', compact('date','keranjangs','adatrans','saldouang','service','promo','diskon','potongan'));

                }

            } else {

                return view('content.pembayaran.index', compact('date','keranjangs','adatrans','saldouang','service','promo','diskon','potongan'));
            }

        }

        $wilayah = Keranjang::select("wilayah.*")
        ->leftJoin("posts", "keranjang.post_id", "=", "posts.id")
        ->leftJoin("users", "posts.user_id", "=", "users.id")
        ->leftJoin("wilayah", "users.wilayah_id", "=", "wilayah.id")
        ->where([
            ['keranjang.user_id', '=', $user->id],
            ['voucherdet_id', '=', null],
            ['posts.type', '=', 'Products'],
        ])
        ->first();

		return view('content.pembayaran.index', compact('date','keranjangs','adatrans','saldouang','service','promo','diskon','potongan','wilayah'));

    }

    public function reedem_point()
    {
    	date_default_timezone_set('Asia/Jakarta');
		$date = date('Y-m-d');

		$usernyah = Auth::user();

        if(!$usernyah){
            $user = Users::where("clubsmart", csrf_token())
            ->first();
        } else {
            $user = Auth::user();
        }

        $service = Services::first();

		$keranjangs = KeranjangReedemPoint::select("posts.*","keranjang_reedem_point.qty","wilayah.name as wilayah_name","product.name as prod_name")
		->leftJoin("posts", "keranjang_reedem_point.post_id", "=", "posts.id")
        ->leftJoin("product", "posts.product_id", "=", "product.id")
        ->leftJoin("users", "posts.user_id", "=", "users.id")
        ->leftJoin("wilayah", "users.wilayah_id", "=", "wilayah.id")
        ->where([
            ['keranjang_reedem_point.user_id', '=', $user->id],
            ['posts.type', '=', 'Products'],
        ])
		->get();

        $saldopoin = SaldoPoin::where("user_id", $user->id)
        ->orderBy("id", "desc")
        ->first();

        $adatrans = Transaksi::where("user_id", $user->id)
        ->first();
		
		$promo = KeranjangReedemPoint::select("posts.*")
		->leftJoin("posts", "keranjang_reedem_point.post_id", "=", "posts.id")
        ->where([
            ['keranjang_reedem_point.user_id', '=', $user->id],
            ['posts.jenis', '=', 'promo'],
            ['posts.type', '=', 'Products'],
        ])
		->first();

        $diskon = 0;

        $wilayah = KeranjangReedemPoint::select("wilayah.*")
        ->leftJoin("posts", "keranjang_reedem_point.post_id", "=", "posts.id")
        ->leftJoin("users", "posts.user_id", "=", "users.id")
        ->leftJoin("wilayah", "users.wilayah_id", "=", "wilayah.id")
        ->where([
            ['keranjang_reedem_point.user_id', '=', $user->id],
            ['posts.type', '=', 'Products'],
        ])
        ->first();

		return view('content.reedem_point.pembayaran.index', compact('date','keranjangs','adatrans','saldopoin','service','wilayah'));

    }

    public function validasiwilayah()
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

        $total = 0;

        foreach ($keranjangs as $keranjang) {

            $harga = $keranjang->harga_act - ceil($keranjang->harga_act * (float)$diskon / 100);
            $totalnya = $keranjang->qty * $harga;

            $totalkeseluruhan = $totalnya;

            $total += $totalkeseluruhan;

        }

        $adavoucher = Keranjang::select("vouchers.amount","keranjang.voucherdet_id","vouchers.jenis")
        ->leftJoin("voucher_details", "keranjang.voucherdet_id", "=", "voucher_details.id")
        ->leftJoin("vouchers", "voucher_details.voucher_id", "=", "vouchers.id")
        ->where("voucherdet_id","!=",NULL)
        ->where("user_id", $user->id)
        ->first();

        if($adavoucher){

            if($adavoucher->jenis == "cashback"){

                $total = $total;

            } else {

                $total = $total - $adavoucher->amount;

            }        

        } else {

            $total = $total;

        }


        if($saldouang){
            if($saldouang->sisa >= $total){
                $data = 1;
            } else {
                $data = 0;
            }
        } else {
            $data = 0;
        }

		$wilayah = Keranjang::select("wilayah.name")
		->leftJoin("posts", "keranjang.post_id", "=", "posts.id")
        ->leftJoin("users", "posts.user_id", "=", "users.id")
        ->leftJoin("wilayah", "users.wilayah_id", "=", "wilayah.id")
        ->where([
            ['keranjang.user_id', '=', $user->id],
            ['voucherdet_id', '=', null],
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

    public function saldo(Request $request)
    {

        date_default_timezone_set('Asia/Jakarta');
        $usernyah = Auth::user();

        if(!$usernyah){
            $user = Users::where("email", csrf_token())
            ->first();
        } else {
            $user = Auth::user();
        }

        $dates = date('d');
        if($user->pemegangsaham == 'yes'){

            $pemegangsaham = Services::where('type', 'pemegangsaham')
            ->first();

            $diskon = $pemegangsaham->biaya;

        } else {

            $diskon = 0;

        }

        $keranjangs = Keranjang::select("posts.*","keranjang.qty")
        ->leftJoin("posts", "keranjang.post_id", "=", "posts.id")
        ->where([
            ['keranjang.user_id', '=', $user->id],
            ['voucherdet_id', '=', null],
            ['posts.type', '=', 'Products'],
        ])
        ->get();

        $cekwilayah = Keranjang::select("users.wilayah_id")
        ->leftJoin("posts", "keranjang.post_id", "=", "posts.id")
        ->leftJoin("users", "posts.user_id", "=", "users.id")
        ->where([
            ['keranjang.user_id', '=', $user->id],
            ['voucherdet_id', '=', null],
            ['posts.type', '=', 'Products'],
        ])
        ->first();

        $cekretailer = Keranjang::where('keranjang.user_id', '=', $user->id)
        ->first();

        $uuid = Uuid::generate();
        $code = substr($uuid,0,8);

        $trans = new Transaksi();
        $trans->uuid = $code.$dates;
        $trans->user_id = $user->id;
        $trans->wilayah_id = $cekwilayah->wilayah_id;
        $trans->retailer_id = $cekretailer->retailer_id;
        $trans->type = 'in';
        $trans->status = 'REEDEM';
        $trans->save();

        $total = 0;

        foreach ($keranjangs as $keranjang) {

            $harga = $keranjang->harga_act - ceil($keranjang->harga_act * (float)$diskon / 100);
            $totalnya = $keranjang->qty * $harga;

            $totalkeseluruhan = $totalnya;

            $total += $totalkeseluruhan;

        }

        $reedems = Keranjang::where("user_id", $user->id)
        ->first();

        $adavoucher = Keranjang::select("vouchers.amount","keranjang.voucherdet_id","vouchers.jenis")
        ->leftJoin("voucher_details", "keranjang.voucherdet_id", "=", "voucher_details.id")
        ->leftJoin("vouchers", "voucher_details.voucher_id", "=", "vouchers.id")
        ->where("voucherdet_id","!=",NULL)
        ->where("user_id", $user->id)
        ->first();

        if($adavoucher){

            if($adavoucher->jenis == "cashback"){

                $total = $total;

            } else {

                $total = $total - $adavoucher->amount;

            }        

        } else {

            $total = $total;

        }

        $donation = new Order();
        $donation->uuid = $uuid;
        $donation->transaction_id = $trans->id;
        $donation->user_id = $user->id;
        $donation->type_bayar = 'Saldo Warungkoki';
        $donation->status = 'selesai';
        $donation->order_type = 'Pembelian Deals/Product';
        $donation->amount = floatval($total);
        $donation->reedem = $reedems->reedem;
        if($adavoucher){
            $donation->voucherdet_id = $adavoucher->voucherdet_id;
        }
        $donation->save();

        if($adavoucher){
            if($adavoucher->type == NULL){
                $updates = VoucherDetails::where(['id'=>$adavoucher->voucherdet_id])
                ->update(['status'=> 'selesai']);
            }
        }

        // ==== CEK DAPAT UNDIAN =====

        $totalbayar = (int)$total;

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
                $undvcr->transaction_id = $trans->id;
                $undvcr->code = date('H').$code.date('i').$i;
                $undvcr->save();

            }

        }

        foreach ($keranjangs as $keranjang) {

            $totalx = $keranjang->harga_act - ceil($keranjang->harga_act * (float)$diskon / 100);
            $totalnya = $keranjang->qty * $harga;

            $diskonnya = null;

            $transorder = new OrderDetails();
            $transorder->order_id = $donation->id;
            $transorder->post_id = $keranjang->id;
            $transorder->qty = $keranjang->qty;
            $transorder->amount = $keranjang->qty * $totalx;
            $transorder->diskon = $diskonnya;
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

        $emails = $orderan->email;


        // ========== SELESAI =========
        $trandetails = TransaksiDetails::select("transactions.user_id","transaction_details.product_id","transaction_details.transaction_id","transaction_details.post_id","transaction_details.qty","posts.type")
        ->leftJoin("transactions", "transaction_details.transaction_id", "=", "transactions.id")
        ->leftJoin("posts", "transaction_details.post_id", "=", "posts.id")
        ->where("transaction_details.transaction_id", $trans->id)
        ->get();

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

        $uuid2 = Uuid::generate();
        $code2 = substr($uuid2,0,8);

        $saldox = new SaldoTrans();
        $saldox->uuid = $code2;
        $saldox->user_id = $user->id;
        $saldox->transaction_id = $trans->id;
        $saldox->type = 'out';
        $saldox->amount = floatval($total);
        $saldox->save();

        $adasaldo = SaldoUang::where("user_id", $user->id)
        ->orderBy("id", "desc")
        ->first();

        $sald = new SaldoUang();
        $sald->user_id = $user->id;
        $sald->saldotrans_id = $saldox->id;
        $sald->before = $adasaldo->sisa;
        $sald->sisa = $adasaldo->sisa - $total;
        $sald->save();


         if(strlen($trans->id) == 2){
            $codenya = '0000'.$trans->id;
        } else if(strlen($trans->id) == 3){
            $codenya = '000'.$trans->id;

        } else if(strlen($trans->id) == 4){
            $codenya = '00'.$trans->id;
        } else if(strlen($trans->id) == 5){
            $codenya = '0'.$trans->id;  
        } else {
           $codenya = $trans->id; 
        }

        $uuidxx = Uuid::generate();
        $codexx = substr($uuidxx,0,3);

        $transxx = Transaksi::where(['id'=>$trans->id])
        ->update(['uuid'=>'INV'.date('ymd').$codenya.$codexx]);

        $keranjanghapus = Keranjang::where('keranjang.user_id', '=', $user->id)
        ->delete();

        $cekwilayah = Transaksi::select("users.wilayah_id","posts.type","wilayah.name","wilayah.alamat")
        ->leftJoin("transaction_details", "transactions.id", "=", "transaction_details.transaction_id")
        ->leftJoin("posts", "transaction_details.post_id", "=", "posts.id")
        ->leftJoin("users", "posts.user_id", "=", "users.id")
        ->leftJoin("wilayah", "users.wilayah_id", "=", "wilayah.id")
        ->where("transactions.id", $trans->id)
        ->first();

        $trx = array(    
            'reedem' => $reedems->reedem,
            'wilayah_id' => $cekwilayah->wilayah_id,
        );

        return response()->json($trx);

    }

    public function cash(Request $request)
    {

        date_default_timezone_set('Asia/Jakarta');
        $user = Auth::user();
        $dates = date('d');
        if($user->pemegangsaham == 'yes'){

            $pemegangsaham = Services::where('type', 'pemegangsaham')
            ->first();

            $diskon = $pemegangsaham->biaya;

        } else {

            $diskon = 0;

        }

        $keranjangs = Keranjang::select("posts.*","keranjang.qty")
        ->leftJoin("posts", "keranjang.post_id", "=", "posts.id")
        ->where([
            ['keranjang.user_id', '=', $user->id],
            ['voucherdet_id', '=', null],
            ['posts.type', '=', 'Products'],
        ])
        ->get();

        $uuid = Uuid::generate();
        $code = substr($uuid,0,8);

        $cekretailer = Keranjang::where('keranjang.user_id', '=', $user->id)
        ->first();

        $wilayah = Keranjang::select("users.wilayah_id")
        ->leftJoin("posts", "keranjang.post_id", "=", "posts.id")
        ->leftJoin("users", "posts.user_id", "=", "users.id")
        ->where([
            ['keranjang.user_id', '=', $user->id],
            ['posts.type', '=', 'Products'],
        ])
        ->first();

        $trans = new Transaksi();
        $trans->uuid = $code.$dates;
        $trans->user_id = $user->id;
        $trans->wilayah_id = $wilayah->wilayah_id;
        $trans->retailer_id = $cekretailer->retailer_id;
        $trans->type = 'in';
        $trans->status = 'BELUM BAYAR';
        $trans->save();

        $total = 0;

        foreach ($keranjangs as $keranjang) {

            $harga = $keranjang->harga_act - ceil($keranjang->harga_act * (float)$diskon / 100);
            $totalnya = $keranjang->qty * $harga;

            // $diskonbarang = DiskonDetails::select("diskon.*")
            // ->join("diskon", "diskon_details.diskon_id", "=", "diskon.id")
            // ->where('diskon_details.code_id', $keranjang->code_id)
            // ->where([
            //   ['diskon_details.code_id', '=', $keranjang->code_id],
            //   ['diskon.dari', '<=', (int)$totalnya],
            //   ['diskon.sampai', '>', (int)$totalnya],
            // ])
            // ->first();

            // if($diskonbarang){
            //   $diskonnya = $totalnya * ((int)$diskonbarang->diskon)/100;
            //   $totalkeseluruhan = $totalnya - $diskonnya;

            // } else {
                $totalkeseluruhan = $totalnya;
            // }

            $total += $totalkeseluruhan;

        }

        $reedems = Keranjang::where("user_id", $user->id)
        ->first();

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

                    $total = $total - ($total * ($adavoucher->percent/100));

                } else {

                    $total = $total - $adavoucher->amount;
                }

            }

        } else {

            $total = $total;

        }

        $donation = new Order();
        $donation->uuid = $uuid;
        $donation->transaction_id = $trans->id;
        $donation->user_id = $user->id;
        $donation->type_bayar = 'Cash';
        $donation->status = 'pending';
        $donation->order_type = 'Pembelian Deals/Product';
        $donation->amount = floatval($total);
        $donation->reedem = 'Yes';
        if($adavoucher){
            $donation->voucherdet_id = $adavoucher->voucherdet_id;
        }
        $donation->save();


        foreach ($keranjangs as $keranjang) {

            $totalx = $keranjang->harga_act - ceil($keranjang->harga_act * (float)$diskon / 100);
            $totalnya = $keranjang->qty * $harga;

            // $diskonbarang = DiskonDetails::select("diskon.*")
            // ->join("diskon", "diskon_details.diskon_id", "=", "diskon.id")
            // ->where('diskon_details.code_id', $keranjang->code_id)
            // ->where([
            //   ['diskon_details.code_id', '=', $keranjang->code_id],
            //   ['diskon.dari', '<=', (int)$totalnya],
            //   ['diskon.sampai', '>', (int)$totalnya],
            // ])
            // ->first();

            // if($diskonbarang){
            //   $diskonnya = $diskonbarang->diskon;

            // } else {
                $diskonnya = null;
            // }

            $transorder = new OrderDetails();
            $transorder->order_id = $donation->id;
            $transorder->post_id = $keranjang->id;
            $transorder->qty = $keranjang->qty;
            $transorder->amount = $keranjang->qty * $totalx;
            $transorder->diskon = $diskonnya;
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
        //     Mail::send('email.belicash', ['nama' => $orderan->username, 'amount' => $orderan->amount, 'transaksis' => $transaksis], function ($message) use ($emails)
        //     {
        //         $message->subject('Segera Lakukan Pembayaran di Kasir Warung Koki!');
        //         $message->from('admin@warungkoki.id', 'Admin Warungkoki.id');
        //         $message->to($emails);
        //     });

        // }
        // catch (Exception $e){
        //     return response (['status' => false,'errors' => $e->getMessage()]);
        // }

        $keranjanghapus = Keranjang::where('keranjang.user_id', '=', $user->id)
        ->delete();

        if(strlen($trans->id) == 2){
            $codenya = '0000'.$trans->id;
        } else if(strlen($trans->id) == 3){
            $codenya = '000'.$trans->id;

        } else if(strlen($trans->id) == 4){
            $codenya = '00'.$trans->id;
        } else if(strlen($trans->id) == 5){
            $codenya = '0'.$trans->id;
        } else {
           $codenya = $trans->id; 
        }

        $uuidxx = Uuid::generate();
        $codexx = substr($uuidxx,0,3);

        $transxx = Transaksi::where(['id'=>$trans->id])
        ->update(['uuid'=>'INV'.date('ymd').$codenya.$codexx]);

        return response()->json($trans);

    }

    public function saldo_point(Request $request)
    {

        date_default_timezone_set('Asia/Jakarta');
        $usernyah = Auth::user();

        if(!$usernyah){
            $user = Users::where("email", csrf_token())
            ->first();
        } else {
            $user = Auth::user();
        }

        $dates = date('d');
        $diskon = 0;

        $keranjangs = KeranjangReedemPoint::select("posts.*","keranjang_reedem_point.qty",'keranjang_reedem_point.id_bracket_product')
        ->leftJoin("posts", "keranjang_reedem_point.post_id", "=", "posts.id")
        ->where([
            ['keranjang_reedem_point.user_id', '=', $user->id],
            ['posts.type', '=', 'Products'],
        ])
        ->get();

        $total = 0;
        foreach ($keranjangs as $keranjang) {

            $harga = butir_padi($keranjang->harga_act);
            $totalnya = $keranjang->qty * $harga;

            $totalkeseluruhan = round($totalnya);

            $total += $totalkeseluruhan;

        }
        

        $cekwilayah = KeranjangReedemPoint::select("users.wilayah_id")
        ->leftJoin("posts", "keranjang_reedem_point.post_id", "=", "posts.id")
        ->leftJoin("users", "posts.user_id", "=", "users.id")
        ->where([
            ['keranjang_reedem_point.user_id', '=', $user->id],
            ['posts.type', '=', 'Products'],
        ])
        ->first();

        $uuid = Uuid::generate();
        $code = substr($uuid,0,8);

        $trans = new Transaksi();
        $trans->uuid = $code.$dates;
        $trans->user_id = $user->id;
        $trans->wilayah_id = $cekwilayah->wilayah_id;
        $trans->retailer_id = null;
        $trans->type = 'in';
        $trans->status = 'PENDING';
        $trans->save();

        

        $donation = new Order();
        $donation->uuid = $uuid;
        $donation->transaction_id = $trans->id;
        $donation->user_id = $user->id;
        $donation->type_bayar = 'Saldo Reedem Poin';
        $donation->status = 'selesai';
        $donation->order_type = 'Pembelian Deals/Product';
        $donation->amount = $total;
        $donation->save();

        // ==== CEK DAPAT UNDIAN =====


        $totalbayar = (int)$total;

        foreach ($keranjangs as $keranjang) {

            $totalx = $keranjang->harga_act;
            $totalnya = $keranjang->qty * $harga;

            $diskonnya = null;

            $transorder = new OrderDetails();
            $transorder->order_id = $donation->id;
            $transorder->post_id = $keranjang->id;
            $transorder->qty = $keranjang->qty;
            $transorder->amount = butir_padi($keranjang->qty * $totalx);
            $transorder->diskon = $diskonnya;
            $transorder->save();

            $transdet = new TransaksiDetails();
            $transdet->transaction_id = $trans->id;
            $transdet->post_id = $keranjang->id;
            $transdet->product_id = $keranjang->product_id;
            $transdet->qty = $keranjang->qty;
            $transdet->save();

            //update stock bracket reedem

            $bracketProduct = BracketProduct::where('id',$keranjang->id_bracket_product);
            $getBracket = $bracketProduct->first();
            $lastStock = $getBracket['stock'];

            // return response()->json($lastStockt,500);

            
            if($keranjang->qty > $lastStock){
                $keranjanghapus = KeranjangReedemPoint::where('keranjang_reedem_point.id', '=', $keranjang->id)
                    ->delete();
                $trx = array(
                    'status' => 'error',
                    'message' => 'Stock sudah habis.'
                );
        
                return response()->json($trx);
            }
            $newStock = $lastStock - $keranjang->qty;
            $updateStock = $bracketProduct->update(['stock'=>$newStock]);
            
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

        $emails = $orderan->email;

        // try{
        //     Mail::send('email.bayaronline', ['nama' => $orderan->username, 'amount' => $orderan->amount, 'transaksis' => $transaksis], function ($message) use ($emails)
        //     {
        //         $message->subject('Terimakasih sudah Membayar dengan Saldo Warungkoki!');
        //         $message->from('admin@tomxperience.id', 'Admin Tomxperience.id');
        //         $message->to($emails);
        //     });

        // }
        // catch (Exception $e){
        //     return response (['status' => false,'errors' => $e->getMessage()]);
        // }


        // ========== SELESAI =========
        $trandetails = TransaksiDetails::select("transactions.user_id","transaction_details.product_id","transaction_details.transaction_id","transaction_details.post_id","transaction_details.qty","posts.type")
        ->leftJoin("transactions", "transaction_details.transaction_id", "=", "transactions.id")
        ->leftJoin("posts", "transaction_details.post_id", "=", "posts.id")
        ->where("transaction_details.transaction_id", $trans->id)
        ->get();

        
        $uuid2 = Uuid::generate();
        $code2 = substr($uuid2,0,8);

        $trsaldo = new TransSaldoPoin();
        $trsaldo->user_id =  $trans->user_id;
        $trsaldo->transaction_id = $trans->id;
        $trsaldo->type = "out";
        $trsaldo->amount = $total;
        $trsaldo->save();

        $saldopoin = SaldoPoin::where("user_id", $trans->user_id)
        ->orderBy("id", "desc")
        ->first();

        $saldonya = new SaldoPoin();
        $saldonya->transpoin_id = $trsaldo->id;
        $saldonya->user_id =  $trans->user_id;
        $saldonya->before = $saldopoin->sisa;
        $saldonya->sisa = $saldopoin->sisa - $total;
        $saldonya->save();

        

        $keranjanghapus = KeranjangReedemPoint::where('keranjang_reedem_point.user_id', '=', $user->id)
        ->delete();

        $cekwilayah = Transaksi::select("users.wilayah_id","posts.type","wilayah.name","wilayah.alamat")
        ->leftJoin("transaction_details", "transactions.id", "=", "transaction_details.transaction_id")
        ->leftJoin("posts", "transaction_details.post_id", "=", "posts.id")
        ->leftJoin("users", "posts.user_id", "=", "users.id")
        ->leftJoin("wilayah", "users.wilayah_id", "=", "wilayah.id")
        ->where("transactions.id", $trans->id)
        ->first();

        $trx = array(
            'uuid' => $trans->uuid,
            'wilayah_id' => $cekwilayah->wilayah_id,
        );

        return response()->json($trx);

    }

    public function konfirm(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $user = Auth::user();

        $serverkey = 'Mid-server-T-bYnWxY1Q2QjhN_kl5nddUX:';
        $base = base64_encode($serverkey);
        $auth = 'Basic '.$base;

        if($request->uuid == NULL){

            $cekdelivery = Keranjang::select("keranjang.*","wilayah.id as wilayah_id")
            ->leftJoin("posts", "keranjang.post_id", "=", "posts.id")
            ->leftJoin("users", "posts.user_id", "=", "users.id")
            ->leftJoin("wilayah", "users.wilayah_id", "=", "wilayah.id")
            ->where([
                ['keranjang.user_id', '=', $user->id],
                ['voucherdet_id', '=', NULL],
                ['keranjang.delivery', '=', 'Y'],
                ['keranjang.delivery_name', '!=', NULL],
            ])
            ->first();

            $keranjangs = Keranjang::select("posts.*","keranjang.qty")
            ->leftJoin("posts", "keranjang.post_id", "=", "posts.id")
            ->where([
                ['keranjang.user_id', '=', $user->id],
                ['posts.type', '=', 'Products'],
            ])
            ->get();

            if($user->pemegangsaham == 'yes'){

                $pemegangsaham = Services::where('type', 'pemegangsaham')
                ->first();

                $diskon = $pemegangsaham->biaya;

            } else {

                $diskon = 0;

            }

            $totals = Keranjang::select("keranjang.qty","posts.harga_act","posts.code_id","keranjang.delivery_amount")
            ->leftJoin("posts", "keranjang.post_id", "=", "posts.id")
            ->where([
                ['keranjang.user_id', '=', $user->id],
                ['posts.type', '=', 'Products'],
            ])
            ->get();

            $sums = 0;
            $deliverynya = 0;
            foreach ($totals as $total ) {

                $harga = $total->harga_act - ceil($total->harga_act * (float)$diskon / 100);
                $totalnya = $total->qty * $harga;

                $totalkeseluruhan = $totalnya;
                $sums += $totalkeseluruhan;

                $deliverynya += $total->delivery_amount;
            }

            $grandtotal = $sums;

            $uuid = Uuid::generate();
            $code = substr($uuid,0,8);

            $wilayah = Keranjang::select("users.wilayah_id")
            ->leftJoin("posts", "keranjang.post_id", "=", "posts.id")
            ->leftJoin("users", "posts.user_id", "=", "users.id")
            ->where([
                ['keranjang.user_id', '=', $user->id],
                ['posts.type', '=', 'Products'],
            ])
            ->first();

            $cekretailer = Keranjang::where('keranjang.user_id', '=', $user->id)
            ->first();

            // ====== CEK DELIVERY APA BUKAN =====

            if($cekdelivery){

                $alamat = Alamat::where([
                    ['user_id', '=', $user->id],
                    ['utama', '=', 'yes'],
                ])
                ->first();
            }



            $trans = new Transaksi();
            $trans->uuid = $code.date('d');
            $trans->user_id = $user->id;
            $trans->wilayah_id = $wilayah->wilayah_id;
            $trans->retailer_id = $cekretailer->retailer_id;
            $trans->type = 'in';
            $trans->status = 'NOT APPROVED';
            $trans->plan = $request->plan;

            if($cekdelivery){
                $trans->alamat_id = $alamat->id;
            }

            $trans->save();

            $reedem = Keranjang::leftJoin("posts", "keranjang.post_id", "=", "posts.id")
            ->where([
                ['keranjang.user_id', '=', $user->id],
                ['posts.type', '=', 'Products'],
            ])
            ->first();

            $adavoucher = Keranjang::select("vouchers.amount","keranjang.voucherdet_id","vouchers.jenis","vouchers.amount","vouchers.percent")
            ->leftJoin("voucher_details", "keranjang.voucherdet_id", "=", "voucher_details.id")
            ->leftJoin("vouchers", "voucher_details.voucher_id", "=", "vouchers.id")
            ->where("voucherdet_id","!=",NULL)
            ->where("user_id", $user->id)
            ->first();

            if($adavoucher){

                if($adavoucher->jenis == "cashback"){

                    $grandtotal = $grandtotal;

                } else {

                    if($adavoucher->amount == NULL){

                        $grandtotal = $grandtotal - ($grandtotal * $adavoucher->percent/100);

                    } else {

                        $grandtotal = $grandtotal - $adavoucher->amount;

                    }

                    

                }


            } else {

                $grandtotal = $grandtotal;

            }

            $donation = new Order();
            $donation->uuid = $uuid;
            $donation->transaction_id = $trans->id;
            $donation->user_id = $user->id;
            $donation->type_bayar = 'ONLINE';
            $donation->status = 'pending';

            if($cekdelivery){

                $donation->order_type = "Pembelian Delivery";
                $donation->delivery = floatval($deliverynya);
                $donation->delivery_name = $cekdelivery->delivery_name;
                $donation->delivery_type = $cekdelivery->delivery_type;
                $donation->amount = floatval($grandtotal+$deliverynya);

            } else {

                $donation->order_type = "Pembelian Deals/Product";
                $donation->amount = floatval($grandtotal);
            }

            $donation->reedem = 'Yes';

            if($adavoucher){
                $donation->voucherdet_id = $adavoucher->voucherdet_id;
            }

            $donation->save();

            foreach ($keranjangs as $keranjang) {

                $totalss = $keranjang->harga_act - ceil($keranjang->harga_act * (float)$diskon / 100);
                $totalnya = $keranjang->qty * $harga;

                $diskonnya = null;

                $transorder = new OrderDetails();
                $transorder->order_id = $donation->id;
                $transorder->post_id = $keranjang->id;
                $transorder->qty = $keranjang->qty;
                $transorder->amount = $keranjang->qty * $totalss;
                $transorder->diskon = $diskonnya;
                $transorder->save();


                $transdet = new TransaksiDetails();
                $transdet->transaction_id = $trans->id;
                $transdet->post_id = $keranjang->id;
                $transdet->product_id = $keranjang->product_id;
                $transdet->qty = $keranjang->qty;
                $transdet->save();

                
            }

            if(strlen($trans->id) == 2){
                $codenya = '0000'.$trans->id;
            } else if(strlen($trans->id) == 3){
                $codenya = '000'.$trans->id;

            } else if(strlen($trans->id) == 4){
                $codenya = '00'.$trans->id;
            } else if(strlen($trans->id) == 5){
                $codenya = '0'.$trans->id;  
            } else {
               $codenya = $trans->id; 
            }

            $uuidxx = Uuid::generate();
            $codexx = substr($uuidxx,0,3);

            $transxx = Transaksi::where(['id'=>$trans->id])
            ->update(['uuid'=>'INV'.date('ymd').$codenya.$codexx]);

            $hapuskeranjang = Keranjang::where("user_id", $user->id)
            ->delete();

            // === MUNCULKAN LINK BAYAR ====

            $transaction = Transaksi::select("transactions.*","orders.amount","users.name as user_name","users.email","orders.qris","orders.status as order_status")
            ->leftJoin("orders", "transactions.id", "=", "orders.transaction_id")
            ->leftJoin("users", "transactions.user_id", "=", "users.id")
            ->where("transactions.id",$trans->id)
            ->first();

            $kranjang22 = TransaksiDetails::select("post_codes.kode as id", "posts.harga_act as price","transaction_details.qty as quantity","product.name as name")
            ->leftJoin("posts", "transaction_details.post_id", "=", "posts.id")
            ->leftJoin("post_codes", "posts.code_id", "=", "post_codes.id")
            ->leftJoin("product", "posts.product_id", "=", "product.id")
            ->where('transaction_details.transaction_id', '=', $transaction->id)
            ->get();

            $jayParsedAry2 = [
                "payment_type"=> "gopay",
                "transaction_details"=> [
                    "gross_amount"=> $transaction->amount,
                    "order_id"=> 'INV'.date('ymd').$codenya.$codexx,
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
            $deeplink = $output['actions'][1]['url'];

            $updateorder = Order::where(['transaction_id'=>$transaction->id])
            ->update(['qris'=> $qris,'type_bayar' => 'ONLINE', 'deeplink'=> $deeplink]);

            $transxx = Transaksi::select("orders.deeplink","transactions.uuid","orders.qris")
            ->leftJoin("orders", "transactions.id", "=", "orders.transaction_id")
            ->where("transactions.id",$transaction->id)
            ->first();


        } else {

            $transaction = Transaksi::select("transactions.*","orders.amount","users.name as user_name","users.email","orders.qris","orders.status as order_status")
            ->leftJoin("orders", "transactions.id", "=", "orders.transaction_id")
            ->leftJoin("users", "transactions.user_id", "=", "users.id")
            ->where("transactions.uuid",$request->uuid)
            ->first();

            if($transaction->order_status == "pending"){

                $transxx = Transaksi::select("orders.deeplink","transactions.uuid","orders.qris")
                ->leftJoin("orders", "transactions.id", "=", "orders.transaction_id")
                ->where("transactions.id",$transaction->id)
                ->first();

            } else {

                $kranjang22 = TransaksiDetails::select("post_codes.kode as id", "posts.harga_act as price","transaction_details.qty as quantity","product.name as name")
                ->leftJoin("posts", "transaction_details.post_id", "=", "posts.id")
                ->leftJoin("post_codes", "posts.code_id", "=", "post_codes.id")
                ->leftJoin("product", "posts.product_id", "=", "product.id")
                ->where('transaction_details.transaction_id', '=', $transaction->id)
                ->get();

                $jayParsedAry2 = [
                    "payment_type"=> "gopay",
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
                $deeplink = $output['actions'][1]['url'];

                $updateorder = Order::where(['transaction_id'=>$transaction->id])
                ->update(['qris'=> $qris,'type_bayar' => 'ONLINE', 'deeplink'=> $deeplink]);

                $transxx = Transaksi::select("orders.deeplink","transactions.uuid","orders.qris")
                ->leftJoin("orders", "transactions.id", "=", "orders.transaction_id")
                ->where("transactions.id",$transaction->id)
                ->first();

            }


        }


        return view('content.pembayaran.konfirm', compact('transxx'));
    }
}
