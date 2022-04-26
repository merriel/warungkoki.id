<?php

namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use App\Order;
use App\OrderDetails;
use App\Saldo;
use App\SaldoRewards;
use App\Keranjang;
use App\Transaksi;
use App\Posts;
use App\PostDetails;
use App\PostRewards;
use App\TransaksiDetails;
use \Midtrans\Config;
use \Midtrans\Snap;
use \Midtrans\Notification;
use \Midtrans\Transaction;
use App\ChallangeJoins;
use App\ChallangeProses;
use App\WSOrder;
use App\WSTransaksi;
use App\Services;
use App\SaldoTrans;
use App\SaldoUang;
use App\Alamat;
use App\Users;
use App\SaldoPoin;
use App\TransSaldoPoin;
use App\DiskonDetails;
use App\VoucherDetails;
use App\UndianVouchers;
use App\Undian;
use Auth;
use Uuid;
use DB;
use Mail;


class OrderController extends Controller
{
  /**
     * Make request global.
     *
     * @var \Illuminate\Http\Request
     */
    protected $request;
    /**
     * Class constructor.
     *
     * @param \Illuminate\Http\Request $request User Request
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
 
        // Set midtrans configuration
        \Midtrans\Config::$serverKey = config('services.midtrans.serverKey');
        \Midtrans\Config::$isProduction = config('services.midtrans.isProduction');
        \Midtrans\Config::$isSanitized = config('services.midtrans.isSanitized');
        \Midtrans\Config::$is3ds = config('services.midtrans.is3ds');

    }

    public function submitOrder()
    {
        $usernyah = Auth::user();

        if(!$usernyah){
            $user = Users::where("clubsmart", csrf_token())
            ->first();
        } else {
            $user = Auth::user();
        }

        $cekkeranjangs = Keranjang::select("posts.*","keranjang.qty")
        ->leftJoin("posts", "keranjang.post_id", "=", "posts.id")
        ->where([
            ['keranjang.user_id', '=', $user->id],
            ['posts.type', '=', 'Products'],
        ])
        ->count();

        if($cekkeranjangs == 0){

            $usernyah = Auth::user();

            if(!$usernyah){

                $user = Users::select("users.*","wilayah.uuid")
                ->leftJoin("wilayah", "users.wilayah_id", "=", "wilayah.id")
                ->where("clubsmart", csrf_token())
                ->first();

                $arrayNames = array(    
                    'status' => 1,
                    'wilayah' => $user->uuid,
                );

                return response()->json($arrayNames);

            } else {
                $user = Auth::user();

                $arrayNames = array(    
                    'status' => 2,
                );

                return response()->json($arrayNames);
            }

        } else {

            date_default_timezone_set('Asia/Jakarta');
            $dates = date('d');

            \DB::transaction(function(){
                // Save donasi ke database
                $usernyah = Auth::user();

                if(!$usernyah){
                    $user = Users::where("clubsmart", csrf_token())
                    ->first();
                } else {
                    $user = Auth::user();
                }

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

                $totals = Keranjang::select("keranjang.qty","posts.harga_act","posts.code_id")
                ->leftJoin("posts", "keranjang.post_id", "=", "posts.id")
                ->where([
                    ['keranjang.user_id', '=', $user->id],
                    ['posts.type', '=', 'Products'],
                ])
                ->get();

                $sums = 0;
                foreach ($totals as $total ) {

                    $harga = $total->harga_act - ceil($total->harga_act * (float)$diskon / 100);
                    $totalnya = $total->qty * $harga;

                    // $diskonbarang = DiskonDetails::select("diskon.*")
                    // ->join("diskon", "diskon_details.diskon_id", "=", "diskon.id")
                    // ->where('diskon_details.code_id', $total->code_id)
                    // ->where([
                    //   ['diskon_details.code_id', '=', $total->code_id],
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

                    $sums += $totalkeseluruhan;
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

                $trans = new Transaksi();
                $trans->uuid = $code.date('d');
                $trans->user_id = $user->id;
                $trans->wilayah_id = $wilayah->wilayah_id;
                $trans->retailer_id = $cekretailer->retailer_id;
                $trans->type = 'in';
                $trans->status = 'NOT APPROVED';
                $trans->save();

                $reedem = Keranjang::leftJoin("posts", "keranjang.post_id", "=", "posts.id")
                ->where([
                    ['keranjang.user_id', '=', $user->id],
                    ['posts.type', '=', 'Products'],
                ])
                ->first();

                $adavoucher = Keranjang::select("vouchers.amount","keranjang.voucherdet_id","vouchers.jenis")
                ->leftJoin("voucher_details", "keranjang.voucherdet_id", "=", "voucher_details.id")
                ->leftJoin("vouchers", "voucher_details.voucher_id", "=", "vouchers.id")
                ->where("voucherdet_id","!=",NULL)
                ->where("user_id", $user->id)
                ->first();

                if($adavoucher){

                    if($adavoucher->jenis == "cashback"){

                        $grandtotal = $grandtotal;

                    } else {

                        $grandtotal = $grandtotal - $adavoucher->amount;

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
                $donation->order_type = $this->request->order_type;
                $donation->amount = floatval($grandtotal);
                $donation->reedem = $reedem->reedem;
                if($adavoucher){
                    $donation->voucherdet_id = $adavoucher->voucherdet_id;
                }
                $donation->save();

                // if($usernyah){

                //     if($adavoucher){

                //         if($adavoucher->jenis == null){
                //             $updates = VoucherDetails::where(['id'=>$adavoucher->voucherdet_id])
                //             ->update(['status'=> 'selesai']);
                //         }
                //     }

                // }

                foreach ($keranjangs as $keranjang) {

                    $totalss = $keranjang->harga_act - ceil($keranjang->harga_act * (float)$diskon / 100);
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
                    $transorder->amount = $keranjang->qty * $totalss;
                    $transorder->diskon = $diskonnya;
                    $transorder->save();

                    // $posts = PostDetails::where("post_id", $keranjang->id)
                    // ->get();

                    // foreach($posts as $post){

                        $transdet = new TransaksiDetails();
                        $transdet->transaction_id = $trans->id;
                        $transdet->post_id = $keranjang->id;
                        $transdet->product_id = $keranjang->product_id;
                        $transdet->qty = $keranjang->qty;
                        $transdet->save();

                    // } 
                    
                }
     
                // Buat transaksi ke midtrans kemudian save snap tokennya.
                $payload = [
                    'transaction_details' => [
                        'order_id'      => $code.date('d'),
                        'gross_amount'  => $grandtotal,
                    ],
                    'customer_details' => [
                        'first_name'    => $user->name,
                        'email'         => $user->email,
                        // 'phone'         => '08888888888',
                        // 'address'       => '',
                    ],
                    'item_details' => [
                        [
                            'id'       => $donation->order_type,
                            'price'    => $donation->amount,
                            'quantity' => 1,
                            'name'     => ucwords(str_replace('_', ' ', $donation->order_type))
                        ]
                    ]
                ];

                $snapToken = \Midtrans\Snap::getSnapToken($payload);
                $donation->snap_token = $snapToken;
                $donation->save();
     
                // Beri response snap token
                $this->response['snap_token'] = $snapToken;
            });

            $usernyah = Auth::user();

            if(!$usernyah){
                $user = Users::where("clubsmart", csrf_token())
                ->first();
            } else {
                $user = Auth::user();
            }
     
            return response()->json($this->response);

        }
    }

    public function submitOrderDelivery()
    {

        date_default_timezone_set('Asia/Jakarta');
        $dates = date('d');

        \DB::transaction(function(){
            // Save donasi ke database
            $user = Auth::user();

            $service = Services::first();

            if($user->pemegangsaham == 'yes'){

                $pemegangsaham = Services::where('type', 'pemegangsaham')
                ->first();

                $diskon = $pemegangsaham->biaya;

            } else {

                $diskon = 0;

            }

            $kranjs = Keranjang::select("wilayah.id","wilayah.name","regencies.name as regency_name")
            ->leftJoin("posts", "keranjang.post_id", "=", "posts.id")
            ->leftJoin("users", "posts.user_id", "=", "users.id")
            ->leftJoin("wilayah", "users.wilayah_id", "=", "wilayah.id")
            ->leftJoin("regencies", "wilayah.regency_id", "=", "regencies.id")
            ->where([
                ['keranjang.user_id', '=', $user->id],
                ['voucherdet_id', '=', NULL],
                ['posts.type', '=', 'Delivery'],
                ['keranjang.delivery', '=', 'Y'],
            ])
            ->distinct()
            ->get();

            $codex = null;

            // foreach ($kranjs as $k) {
                
                $keranjangs = Keranjang::select("posts.*","keranjang.qty","keranjang.delivery_amount")
                ->leftJoin("posts", "keranjang.post_id", "=", "posts.id")
                ->leftJoin("users", "posts.user_id", "=", "users.id")
                ->leftJoin("wilayah", "users.wilayah_id", "=", "wilayah.id")
                ->leftJoin("regencies", "wilayah.regency_id", "=", "regencies.id")
                ->leftJoin("product", "posts.product_id", "=", "product.id")
                ->where([
                    ['keranjang.user_id', '=', $user->id],
                    ['voucherdet_id', '=', NULL],
                    ['keranjang.delivery', '=', 'Y'],
                ])
                ->get();

                $iddelivery = Keranjang::select("keranjang.*","wilayah.id as wilayah_id")
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


                $alamat = Alamat::where([
                    ['user_id', '=', $user->id],
                    ['utama', '=', 'yes'],
                ])
                ->first();

                $uuid = Uuid::generate();
                $code = substr($uuid,0,8);

                $trans = new Transaksi();
                $trans->uuid = $code.date('d');
                $trans->user_id = $user->id;
                $trans->wilayah_id = $iddelivery->wilayah_id;
                $trans->type = 'in';
                $trans->status = 'NOT APPROVED';
                $trans->alamat_id = $alamat->id;
                $trans->save();

                $total = 0;
                $delivery = 0;

                foreach ($keranjangs as $keranjang) {

                    $totalss = $keranjang->harga_act + ceil($keranjang->harga_act * (float)$diskon / 100);

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
                $donation->type_bayar = 'ONLINE';
                $donation->status = 'pending';
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

                $emails = $orderan->email;

                // try{
                //     Mail::send('email.bayaronline', ['nama' => $orderan->username, 'amount' => $orderan->amount, 'transaksis' => $transaksis], function ($message) use ($emails)
                //     {
                //         $message->subject('Terimakasih sudah Membayar dengan Secara ONLINE!');
                //         $message->from('admin@tomxperience.id', 'Admin Tomxperience.id');
                //         $message->to($emails);
                //     });

                // }
                // catch (Exception $e){
                //     return response (['status' => false,'errors' => $e->getMessage()]);
                // }

                $grandtotal = $total+$delivery-$voucher;

                // $codex .= $code.date('d').'-';

            // }

            // ===========
 
            // Buat transaksi ke midtrans kemudian save snap tokennya.
            $payload = [
                'transaction_details' => [
                    'order_id'      => $code.date('d'),
                    'gross_amount'  => $grandtotal,
                ],
                'customer_details' => [
                    'first_name'    => $user->name,
                    'email'         => $user->email,
                    // 'phone'         => '08888888888',
                    // 'address'       => '',
                ],
                'item_details' => [
                    [
                        'id'       => $donation->order_type,
                        'price'    => $grandtotal,
                        'quantity' => 1,
                        'name'     => ucwords(str_replace('_', ' ', "Pembelian Produk"))
                    ]
                ]
            ];

            $snapToken = \Midtrans\Snap::getSnapToken($payload);
            $donation->snap_token = $snapToken;
            $donation->save();
 
            // Beri response snap token
            $this->response['snap_token'] = $snapToken;
        });

        $userz = Auth::user();

        $keranjanghapus = Keranjang::where('keranjang.user_id', '=', $userz->id)
        ->delete();
 
        return response()->json($this->response);
    }


    /**
     * Midtrans notification handler.
     *
     * @param Request $request
     * 
     * @return void
     */
    public function notificationHandler(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d');
        $date2 = date('d');

        $notif = new \Midtrans\Notification();
        \DB::transaction(function() use ($notif) {
 
        $transaction = $notif->transaction_status;
        $type = $notif->payment_type;
        $orderId = $notif->order_id;
        $fraud = $notif->fraud_status;

        $cek = Transaksi::where('uuid', $orderId)
        ->first();

            $donation = Order::select("orders.*","transactions.alamat_id")
            ->leftJoin("transactions", "orders.transaction_id", "=", "transactions.id")
            ->where("transactions.uuid", $orderId)->first();
     
            if ($transaction == 'capture') {
     
                // For credit card transaction, we need to check whether transaction is challenge by FDS or not
                if ($type == 'credit_card') {
     
                  if($fraud == 'challenge') {
                    // TODO set payment status in merchant's database to 'Challenge by FDS'
                    // TODO merchant should decide whether this transaction is authorized or not in MAP
                    // $donation->addUpdate("Transaction order_id: " . $orderId ." is challenged by FDS");
                    $orderzz = Order::where(['id'=>$donation->id])
                    ->update(['status'=>'pending']);
                  } else {
                    // TODO set payment status in merchant's database to 'Success'
                    // $donation->addUpdate("Transaction order_id: " . $orderId ." successfully captured using " . $type);
                    $orderzz = Order::where(['id'=>$donation->id])
                    ->update(['status'=>'selesai']);
                  }
     
                }
     
            } elseif ($transaction == 'settlement') {
     
                // TODO set payment status in merchant's database to 'Settlement'
                // $donation->addUpdate("Transaction order_id: " . $orderId ." successfully transfered using " . $type);
                if($type == "qris"){
                    $type = "QRIS";
                } else if($type == "gopay"){
                    $type = "ONLINE";
                }

                $orderzz = Order::where(['id'=>$donation->id])
                ->update(['status' => 'selesai', 'type_bayar' => $type]);

                $cekorder = Order::where("id", $donation->id)
                ->first();

                if($cekorder->voucherdet_id != NULL){

                    $voucherx = VoucherDetails::select("vouchers.*")
                    ->leftJoin("vouchers", "voucher_details.voucher_id", "=", "vouchers.id")
                    ->where("voucher_details.id", $cekorder->voucherdet_id)
                    ->first();

                    if($voucherx->type == NULL){

                        $updatesvouc = VoucherDetails::where(['id'=>$cekorder->voucherdet_id])
                        ->update(['status'=> 'selesai']);

                    }
                }

                $transs = Transaksi::where("id", $donation->transaction_id)
                ->first();

                $keranjang = Keranjang::where('keranjang.user_id', '=', $transs->user_id)
                ->delete();

                if($transs->status != 'APPROVED'){

                    if($donation->alamat_id == NULL){

                        if($cekorder->type_bayar == "ONLINE"){
                            $transupdate = Transaksi::where(['id'=>$donation->transaction_id])
                            ->update(['status'=>'REEDEM','cash'=> NULL]);
                        } else {
                            $transupdate = Transaksi::where(['id'=>$donation->transaction_id])
                            ->update(['status'=>'APPROVED','cash'=> NULL]);
                        }

                        $trandetails = TransaksiDetails::select("transactions.user_id","transaction_details.product_id","transaction_details.transaction_id","transaction_details.post_id","transaction_details.qty","posts.type")
                        ->leftJoin("transactions", "transaction_details.transaction_id", "=", "transactions.id")
                        ->leftJoin("posts", "transaction_details.post_id", "=", "posts.id")
                        ->where("transaction_details.transaction_id", $donation->transaction_id)
                        ->get();

                        $orderan = Order::select("orders.*","users.email","users.fcm_token","users.name as username")
                        ->leftJoin("transactions", "orders.transaction_id", "=", "transactions.id")
                        ->leftJoin("users", "transactions.user_id", "=", "users.id")
                        ->where("transaction_id", $donation->transaction_id)
                        ->first();

                        // ====== KIRIM EMAIL ======

                        $transaksis = OrderDetails::select("posts.*","order_details.qty","order_details.amount","product.name as prod_name")
                        ->leftJoin("posts", "order_details.post_id", "=", "posts.id")
                        ->leftJoin("product", "posts.product_id", "=", "product.id")
                        ->where("order_details.order_id", $orderan->id)
                        ->get();

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
                                $undvcr->transaction_id = $donation->transaction_id;
                                $undvcr->code = date('H').$code.date('i').$i;
                                $undvcr->save();

                            }

                        }

                        // NOTIFIKASI

                        $getpetugas = TransaksiDetails::select("users.wilayah_id")
                        ->leftJoin("posts", "transaction_details.post_id", "=", "posts.id")
                        ->leftJoin("users", "posts.user_id", "=", "users.id")
                        ->where("transaction_id", $donation->transaction_id)
                        ->first();

                        $ambilpetugas = Users::select("fcm_token")
                        ->where([
                            ['wilayah_id', '=', $getpetugas->wilayah_id],
                            ['role_id', '=', 3],
                        ])
                        ->get();

                        foreach($ambilpetugas as $ambil){

                            if($ambil->fcm_token != NULL){

                                $url = 'https://fcm.googleapis.com/fcm/send';
                                $client = new \GuzzleHttp\Client;
                                $result = $client->post( $url, [
                                  'json'    => [
                                        'to' => $ambil->fcm_token,
                                        'notification' => [
                                            "body" => "AdA Pesanan yuk Cek Segera!",
                                            "title" => "Warungkoki.id Notification",
                                            "icon" => "https://warungkoki.id/assets/icon/96x96.png",
                                            "click_action" => "https://warungkoki.id/home"
                                        ]
                                  ],
                                  'headers' => [
                                     'Authorization' => 'key=AAAAvOfjMXs:APA91bHOcotCNaioU_hLul4_6CbHv8NW4Vfoi_vm97rJB3dv0Ff3IcmkOb1h5hpvmEJtiGydFCMBXBeguCi2H3DftknYx-iLAIOMQCVXVqXxK9PO83f6y3yEywYmpqBkLHlU3qQppOM6',
                                     'Content-Type'  => 'application/json',
                                  ],
                                ]);

                            }

                        }

                    // ====== SELESAI ====

                    // JIKA DIA DELIVERY 

                    } else {

                        $transupdate = Transaksi::where(['id'=>$donation->transaction_id])
                        ->update(['status'=>'DIPROSES']);

                        $orderan = Order::select("orders.*","users.email","users.fcm_token","users.name as username")
                        ->leftJoin("transactions", "orders.transaction_id", "=", "transactions.id")
                        ->leftJoin("users", "transactions.user_id", "=", "users.id")
                        ->where("transaction_id", $donation->transaction_id)
                        ->first();

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
                                $undvcr->transaction_id = $donation->transaction_id;
                                $undvcr->code = date('H').$code.date('i').$i;
                                $undvcr->save();

                            }

                        }
                    }

                } else {

                    // ==== JIKA SETORAN PETUGAS QRIS ====

                    if($transs->cash == 'yes'){

                        $transupdate = Transaksi::where(['id'=>$donation->transaction_id])
                        ->update(['status'=>'APPROVED','cash'=> NULL]);

                    }

                }
     
            } elseif($transaction == 'pending'){
     
                // TODO set payment status in merchant's database to 'Pending'
                // $donation->addUpdate("Waiting customer to finish transaction order_id: " . $orderId . " using " . $type);
                $orderzz = Order::where(['id'=>$donation->id])
                ->update(['status'=>'pending']);

     
            } elseif ($transaction == 'deny') {
     
                // TODO set payment status in merchant's database to 'Failed'
                // $donation->addUpdate("Payment using " . $type . " for transaction order_id: " . $orderId . " is Failed.");
                $orderzz = Order::where(['id'=>$donation->id])
                ->update(['status'=>'failed']);
     
            } elseif ($transaction == 'expire') {
     
                // TODO set payment status in merchant's database to 'expire'
                // $donation->addUpdate("Payment using " . $type . " for transaction order_id: " . $orderId . " is expired.");
                $orderzz = Order::where(['id'=>$donation->id])
                ->update(['status'=>'expired']);
     
            } elseif ($transaction == 'cancel') {
     
                // TODO set payment status in merchant's database to 'Failed'
                // $donation->addUpdate("Payment using " . $type . " for transaction order_id: " . $orderId . " is canceled.");
                $orderzz = Order::where(['id'=>$donation->id])
                ->update(['status'=>'failed']);
     
            } else {
                $orderzz = Order::where(['id'=>$donation->id])
                ->update(['status'=>'failure']);

            }
        });
 
        return;
    }

    public function testing(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d');
        $date2 = date('d');
 
          $transaction = 'settlement';
          $orderId = $request->order_id;

          $cek = Transaksi::where('uuid', $orderId)
          ->first();

              $donation = Order::select("orders.*")
              ->leftJoin("transactions", "orders.transaction_id", "=", "transactions.id")
              ->where("transactions.uuid", $orderId)->first();
     
              if ($transaction == 'capture') {
     
              } elseif ($transaction == 'settlement') {
     
                // TODO set payment status in merchant's database to 'Settlement'
                // $donation->addUpdate("Transaction order_id: " . $orderId ." successfully transfered using " . $type);
                $orderzz = Order::where(['id'=>$donation->id])
                ->update(['status'=>'selesai']);

                $cekorder = Order::where("id", $donation->id)
                ->first();

                if($cekorder->voucherdet_id != NULL){

                    $voucherx = VoucherDetails::select("vouchers.*")
                    ->leftJoin("vouchers", "voucher_details.voucher_id", "=", "vouchers.id")
                    ->where("voucher_details.id", $cekorder->voucherdet_id)
                    ->first();

                    if($voucherx->type == NULL){

                        $updatesvouc = VoucherDetails::where(['id'=>$cekorder->voucherdet_id])
                        ->update(['status'=> 'selesai']);

                    }
                }

                $transs = Transaksi::where("id", $donation->transaction_id)
                ->first();

                $keranjang = Keranjang::where('keranjang.user_id', '=', $transs->user_id)
                ->delete();

                if($transs->status != 'APPROVED'){

                    $transupdate = Transaksi::where(['id'=>$donation->transaction_id])
                        ->update(['status'=>'APPROVED','cash'=> NULL]);

                    $trandetails = TransaksiDetails::select("transactions.user_id","transaction_details.product_id","transaction_details.transaction_id","transaction_details.post_id","transaction_details.qty","posts.type")
                      ->leftJoin("transactions", "transaction_details.transaction_id", "=", "transactions.id")
                      ->leftJoin("posts", "transaction_details.post_id", "=", "posts.id")
                      ->where("transaction_details.transaction_id", $donation->transaction_id)
                      ->get();

                    $orderan = Order::select("orders.*","users.email","users.fcm_token","users.name as username")
                    ->leftJoin("transactions", "orders.transaction_id", "=", "transactions.id")
                    ->leftJoin("users", "transactions.user_id", "=", "users.id")
                    ->where("transaction_id", $donation->transaction_id)
                    ->first();

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
                            $undvcr->transaction_id = $donation->transaction_id;
                            $undvcr->code = date('H').$code.date('i').$i;
                            $undvcr->save();

                        }

                    }

                    // ====== KIRIM EMAIL ======

                    $transaksis = OrderDetails::select("posts.*","order_details.qty","order_details.amount")
                    ->leftJoin("posts", "order_details.post_id", "=", "posts.id")
                    ->where("order_details.order_id", $orderan->id)
                    ->get();

                    $emails = $orderan->email;

                    try{
                        Mail::send('email.bayaronline', ['nama' => $orderan->username, 'amount' => $orderan->amount, 'transaksis' => $transaksis], function ($message) use ($emails)
                        {
                            $message->subject('Terimakasih sudah Membayar secara ONLINE!');
                            $message->from('admin@iolosmart.com', 'Admin Iolo-Smart');
                            $message->to($emails);
                        });

                    }
                    catch (Exception $e){
                        return response (['status' => false,'errors' => $e->getMessage()]);
                    }

                    // ====== SELESAI ====
            
                    foreach($trandetails as $details){
            
                        if($details->type == 'Products'){
            
                            $adasaldo = Saldo::leftJoin("posts", "saldo.post_id", "=", "posts.id")
                            ->where([
                                ['saldo.user_id', '=', $details->user_id],
                                ['saldo.product_id', '=', $details->product_id],
                                ['post_id', '=', $details->post_id],
                                ['status', '=', null],
                            ])
                            ->orderBy("saldo.id", "desc")
                            ->first();
            
                        } else {

                            date_default_timezone_set('Asia/Jakarta');
            
                            $adasaldo = Saldo::leftJoin("posts", "saldo.post_id", "=", "posts.id")
                            ->where([
                                ['posts.sampai', '>=', date('Y-m-d')],
                                ['saldo.user_id', '=', $details->user_id],
                                ['saldo.product_id', '=', $details->product_id],
                                ['post_id', '=', $details->post_id],
                                ['status', '=', null],
                            ])
                            ->orderBy("saldo.id", "desc")
                            ->first();
            
                        }

            
                        $transdet = new Saldo();
                        $transdet->user_id = $details->user_id;
                        $transdet->product_id = $details->product_id;
                        $transdet->transaction_id = $details->transaction_id;
                        $transdet->post_id = $details->post_id;
                        
                        if(!$adasaldo){
            
                            $transdet->before = '0';
                            $transdet->sisa = $details->qty;
            
                        } else {
            
                            $transdet->before = $adasaldo->sisa;
                            $transdet->sisa = $details->qty + $adasaldo->sisa;
            
                        }
                        
                        $transdet->save();

                    }

                    $codee = substr($transs->uuid,5,5);
                    $codes = '0'.date('d').$codee.'22';

                    $trans = new Transaksi();
                    $trans->uuid = $codes;
                    $trans->user_id = $cek->user_id;
                    $trans->type = 'out';
                    $trans->status = 'REEDEM';
                    $trans->ket = 'Reedem Sekarang';
                    $trans->plan = date('Y-m-d H:i');
                    $trans->save();

                    $detailnyas = TransaksiDetails::select("transaction_details.*","transactions.user_id")
                    ->leftJoin("transactions", "transaction_details.transaction_id", "=", "transactions.id")
                    ->where("transaction_id", $donation->transaction_id)
                    ->get();

                    foreach($detailnyas as $detailnya){

                        $transdets = new TransaksiDetails();
                        $transdets->transaction_id = $trans->id;
                        $transdets->post_id = $detailnya->post_id;
                        $transdets->product_id = $detailnya->product_id;
                        $transdets->qty = $detailnya->qty;
                        $transdets->save();

                        $saldoc = Saldo::select("sisa")
                        ->where([
                            ['user_id', '=', $detailnya->user_id],
                            ['post_id', '=', $detailnya->post_id],
                            ['product_id', '=', $detailnya->product_id],
                            ['status', '=', null],
                        ])
                        ->orderBy("id", "desc")
                        ->first();

                        $sisac = $saldoc->sisa - $detailnya->qty;

                        $transaldo = new Saldo();
                        $transaldo->user_id = $detailnya->user_id;
                        $transaldo->product_id = $detailnya->product_id;
                        $transaldo->transaction_id = $trans->id;
                        $transaldo->post_id = $detailnya->post_id;
                        $transaldo->before = $saldoc->sisa;
                        $transaldo->sisa = $sisac;
                        $transaldo->save();

                    }

                    // NOTIFIKASI

                    $getpetugas = TransaksiDetails::select("users.wilayah_id")
                    ->leftJoin("posts", "transaction_details.post_id", "=", "posts.id")
                    ->leftJoin("users", "posts.user_id", "=", "users.id")
                    ->where("transaction_id", $donation->transaction_id)
                    ->first();

                    $ambilpetugas = Users::select("fcm_token")
                    ->where([
                        ['wilayah_id', '=', $getpetugas->wilayah_id],
                        ['role_id', '=', 3],
                    ])
                    ->get();

                    foreach($ambilpetugas as $ambil){

                        if($ambil->fcm_token != NULL){

                            $url = 'https://fcm.googleapis.com/fcm/send';
                            $client = new \GuzzleHttp\Client;
                            $result = $client->post( $url, [
                              'json'    => [
                                    'to' => $ambil->fcm_token,
                                    'notification' => [
                                        "body" => "AdA Pesanan yuk Cek Segera!",
                                        "title" => "Warungkoki.id Notification",
                                        "icon" => "https://warungkoki.id/assets/icon/96x96.png",
                                        "click_action" => "https://warungkoki.id/home"
                                    ]
                              ],
                              'headers' => [
                                 'Authorization' => 'key=AAAAvOfjMXs:APA91bHOcotCNaioU_hLul4_6CbHv8NW4Vfoi_vm97rJB3dv0Ff3IcmkOb1h5hpvmEJtiGydFCMBXBeguCi2H3DftknYx-iLAIOMQCVXVqXxK9PO83f6y3yEywYmpqBkLHlU3qQppOM6',
                                 'Content-Type'  => 'application/json',
                              ],
                            ]);

                        }

                    }

                } else {

                    // ==== JIKA SETORAN PETUGAS QRIS ====

                    if($transs->cash == 'yes'){

                        $transupdate = Transaksi::where(['id'=>$donation->transaction_id])
                        ->update(['status'=>'APPROVED','cash'=> NULL]);

                        $trandetails = TransaksiDetails::select("transactions.user_id","transaction_details.product_id","transaction_details.transaction_id","transaction_details.post_id","transaction_details.qty","posts.type")
                        ->leftJoin("transactions", "transaction_details.transaction_id", "=", "transactions.id")
                        ->leftJoin("posts", "transaction_details.post_id", "=", "posts.id")
                        ->where("transaction_details.transaction_id", $donation->transaction_id)
                        ->get();

                        $orderan = Order::select("orders.*","users.email","users.fcm_token","users.name as username")
                        ->leftJoin("transactions", "orders.transaction_id", "=", "transactions.id")
                        ->leftJoin("users", "transactions.user_id", "=", "users.id")
                        ->where("transaction_id", $donation->transaction_id)
                        ->first();

                        // ====== KIRIM EMAIL ======

                        $transaksis = OrderDetails::select("posts.*","order_details.qty","order_details.amount","product.name as prod_name")
                        ->leftJoin("posts", "order_details.post_id", "=", "posts.id")
                        ->leftJoin("product", "posts.product_id", "=", "product.id")
                        ->where("order_details.order_id", $orderan->id)
                        ->get();

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
                                $undvcr->transaction_id = $donation->transaction_id;
                                $undvcr->code = date('H').$code.date('i').$i;
                                $undvcr->save();

                            }

                        }

                    }
                }
     
              } elseif($transaction == 'pending'){
     
                // TODO set payment status in merchant's database to 'Pending'
                // $donation->addUpdate("Waiting customer to finish transaction order_id: " . $orderId . " using " . $type);
                $orderzz = Order::where(['id'=>$donation->id])
                ->update(['status'=>'pending']);
     
              } elseif ($transaction == 'deny') {
     
                // TODO set payment status in merchant's database to 'Failed'
                // $donation->addUpdate("Payment using " . $type . " for transaction order_id: " . $orderId . " is Failed.");
                $orderzz = Order::where(['id'=>$donation->id])
                ->update(['status'=>'failed']);
     
              } elseif ($transaction == 'expire') {
     
                // TODO set payment status in merchant's database to 'expire'
                // $donation->addUpdate("Payment using " . $type . " for transaction order_id: " . $orderId . " is expired.");
                $orderzz = Order::where(['id'=>$donation->id])
                ->update(['status'=>'expired']);
     
              } elseif ($transaction == 'cancel') {
     
                // TODO set payment status in merchant's database to 'Failed'
                // $donation->addUpdate("Payment using " . $type . " for transaction order_id: " . $orderId . " is canceled.");
                $orderzz = Order::where(['id'=>$donation->id])
                ->update(['status'=>'failed']);
     
              } else {
                $orderzz = Order::where(['id'=>$donation->id])
                ->update(['status'=>'failure']);
              }
 
        return;
    }


}
