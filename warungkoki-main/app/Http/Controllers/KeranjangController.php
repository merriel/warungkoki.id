<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Keranjang;
use App\Users;
use App\Transaksi;
use App\TransaksiDetails;
use App\PostDetails;
use App\PostRewards;
use App\Saldo;
use App\SaldoTrans;
use App\SaldoUang;
use App\SaldoRewards;
use App\UserPost;
use App\Posts;
use App\Order;
use App\OrderDetails;
use App\ChallangeJoins;
use App\ChallangeProses;
use App\Tours;
use App\Services;
use App\Vouchers;
use App\VoucherDetails;
use App\SaldoPoin;
use App\TransSaldoPoin;
use App\Undian;
use App\UndianVouchers;
use App\KurirLocal;
use App\Alamat;
use App\UserMembers;
use Auth;
use DB;
use Mail;
use Uuid;

class KeranjangController extends Controller
{
	public function index()
    {
    	date_default_timezone_set('Asia/Jakarta');
		$date = date('Y-m-d');

		$user = Auth::user();

		$kranjangs = Keranjang::select("posts.name","posts.harga_act","keranjang.qty","keranjang.id","product.img as img_name","wilayah.name as wilayah_name","product.name as prod_name","posts.img","posts.jenis","retailers.name as retailer_name","posts.weight","posts.min_qty","posts.max_qty")
		->leftJoin("posts", "keranjang.post_id", "=", "posts.id")
        ->leftJoin("users", "posts.user_id", "=", "users.id")
        ->leftJoin("wilayah", "users.wilayah_id", "=", "wilayah.id")
        ->leftJoin("product", "posts.product_id", "=", "product.id")
        ->leftJoin("retailers", "keranjang.retailer_id", "=", "retailers.id")
        ->where([
            ['keranjang.user_id', '=', $user->id],
            ['voucherdet_id', '=', NULL],
            ['posts.type', '=', 'Products'],
        ])
		->get();

        $userdetails = Users::where('id', $user->id)
        ->first();

		$ada = Keranjang::leftJoin("posts", "keranjang.post_id", "=", "posts.id")
        ->where([
            ['keranjang.user_id', '=', $user->id],
            ['posts.type', '=', 'Products'],
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

        if($user->pemegangsaham == 'yes'){

            $pemegangsaham = Services::where('type', 'pemegangsaham')
            ->first();

            $diskon = $pemegangsaham->biaya;

        } else {

            $diskon = 0;

        }

        $toko = Keranjang::select("wilayah.*")
        ->join("posts", "keranjang.post_id", "=", "posts.id")
        ->join("users", "posts.user_id", "=", "users.id")
        ->join("wilayah", "users.wilayah_id", "=", "wilayah.id")
        ->where("keranjang.user_id", $user->id)
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

        }

		return view('content.keranjang.index', compact('date','kranjangs','ada','userdetails','service','potongan','diskon','toko','getfree','berat'));

    }

    public function masuk(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');

        $user = Auth::user();
        if($request->retailer_id != null){
            $ada = Keranjang::where([
                ['user_id', '=', $user->id],
                ['post_id', '=', $request->post_id],
                ['retailer_id', '=', $request->retailer_id],
            ])
            ->first();

        } else {
            $ada = Keranjang::where([
                ['user_id', '=', $user->id],
                ['post_id', '=', $request->post_id],
            ])
            ->first();
        }

        if(!$ada){

            $cekpromo = Posts::where("id", $request->post_id)
            ->where("jenis","promo")
            ->first();

            if($cekpromo){

                if($cekpromo->min_qty == null){

                    $qty = '1';

                } else {

                    $qty = $cekpromo->min_qty;
                }

            } else {

                $qty = '1';

            }

        	$keranjang = new Keranjang();
	        $keranjang->user_id = $user->id;
	        $keranjang->post_id = $request->post_id;
            if($request->retailer_id != null){
                $keranjang->retailer_id = $request->retailer_id;
            }
	        $keranjang->qty = $qty;
	        $keranjang->save();

        } else {

            $cekpromo = Posts::where("id", $request->post_id)
            ->where("jenis","promo")
            ->first();

            if($cekpromo){

                if($cekpromo->min_qty == null){

                    $qty = $ada->qty + 1;

                } else {

                    $qty = $qty = $ada->qty + $cekpromo->min_qty;
                }

            } else {

                $qty = $ada->qty + 1;

            }

        	 $keranjang = Keranjang::where(['user_id'=>$user->id,'post_id'=>$request->post_id])
                ->update(['qty'=>$qty]);
        }

        $keranjangnow = Keranjang::leftJoin("posts", "keranjang.post_id", "=", "posts.id")
        ->where([
            ['keranjang.user_id', '=', $user->id],
            ['posts.type', '=', 'Products'],
        ])
        ->count();
        
        return response()->json($keranjangnow);
    }

    public function masuk2(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');

        $user = Auth::user();

        $ada = Keranjang::where([
            ['user_id', '=', $user->id],
            ['post_id', '=', $request->id],
        ])
        ->first();

        if(!$ada){

            $keranjang = new Keranjang();
            $keranjang->user_id = $user->id;
            $keranjang->post_id = $request->id;
            $keranjang->qty = $request->kg;
            $keranjang->save();

        } else {
            $qty = $ada->qty + $request->kg;

             $keranjang = Keranjang::where(['user_id'=>$user->id,'post_id'=>$request->id])
                ->update(['qty'=>$qty]);
        }

        $keranjangnow = Keranjang::leftJoin("posts", "keranjang.post_id", "=", "posts.id")
        ->where([
            ['keranjang.user_id', '=', $user->id],
            ['posts.type', '=', 'Products'],
        ])
        ->count();
        
        return response()->json($keranjangnow);
    }

    public function destroy(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');

        $user = Auth::user();

        $ada = Keranjang::where("id", $request->id)
        ->delete();

        $cekada = Keranjang::where('user_id', $user->id)
        ->where("voucherdet_id", NULL)
        ->count();

        if($cekada == 0){

            $tes = Keranjang::where("user_id", $user->id)
            ->delete();

        }
        
        return response()->json($ada);
    }

    public function count(Request $request)
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

    public function selesaibayar(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $user = Auth::user();
        $date = date('Y-m-d');

        $transx = Transaksi::where("id", $request->trans_id)
        ->first();

        $cekwilayah = Transaksi::select("users.wilayah_id")
        ->leftJoin("transaction_details", "transactions.id", "=", "transaction_details.transaction_id")
        ->leftJoin("posts", "transaction_details.post_id", "=", "posts.id")
        ->leftJoin("users", "posts.user_id", "=", "users.id")
        ->where("transactions.id", $request->trans_id)
        ->first();

        $voucher = Order::select("vouchers.amount","voucher_details.id","orders.id as order_id")
        ->leftJoin("voucher_details", "orders.voucherdet_id", "=", "voucher_details.id")
        ->leftJoin("vouchers", "voucher_details.voucher_id", "=", "vouchers.id")
        ->where("transaction_id", $request->trans_id)
        ->where("voucherdet_id", '!=', NULL)
        ->where("voucher_details.status", '=', NULL)
        ->where("voucher_details.voucher_id", '=', 3)
        ->first();

        $voucherbiasa = Order::select("vouchers.amount","voucher_details.id","orders.id as order_id","vouchers.jenis")
        ->leftJoin("voucher_details", "orders.voucherdet_id", "=", "voucher_details.id")
        ->leftJoin("vouchers", "voucher_details.voucher_id", "=", "vouchers.id")
        ->where("transaction_id", $request->trans_id)
        ->where("voucherdet_id", '!=', NULL)
        ->where("voucher_details.status", '=', NULL)
        ->first();

        // ==== VOUCHER GRAB ====
        if($voucher){

            // ==UPDATE VOUCHER DIAMBIL ==
            $updates = VoucherDetails::where(['id'=>$voucher->id])
            ->update(['status'=> 'selesai']);

            // == UPDATE WILAYAH ==
            $updatesss = Transaksi::where(['id'=>$request->trans_id])
            ->update(['wilayah_id'=>$user->wilayah_id]);

            $postx = Posts::select("posts.id")
            ->leftJoin("users", "posts.user_id", "=", "users.id")
            ->where([
                ['users.wilayah_id', '=', $user->wilayah_id],
                ['posts.code_id', '=', 10],
                ['jenis', '=', 'promo']
            ])
            ->first();

            $updatesss2 = TransaksiDetails::where(['transaction_id'=>$request->trans_id])
            ->update(['post_id'=>$postx->id]);

            $updatesss3 = OrderDetails::where(['order_id'=>$voucher->order_id])
            ->update(['post_id'=>$postx->id]);

            $cekwilayah = Transaksi::select("users.wilayah_id")
            ->leftJoin("transaction_details", "transactions.id", "=", "transaction_details.transaction_id")
            ->leftJoin("posts", "transaction_details.post_id", "=", "posts.id")
            ->leftJoin("users", "posts.user_id", "=", "users.id")
            ->where("transactions.id", $request->trans_id)
            ->first();

            // ==== NOTIFIKASI KE PELANGGAN ====

            $notifuser = Users::where("id", $transx->user_id)
            ->first();

            if($notifuser->fcm_token != NULL){

                $url = 'https://fcm.googleapis.com/fcm/send';
                $client = new \GuzzleHttp\Client;
                $result = $client->post( $url, [
                  'json'    => [
                        'to' => $notifuser->fcm_token,
                        'notification' => [
                            "body" => "Terimakasih sudah melakukan Pembayaran",
                            "title" => "Pembayaran Berhasil",
                            "icon" => "https://warungkoki.id/assets/icon/96x96.png"
                        ]
                  ],
                  'headers' => [
                     'Authorization' => 'key=AAAAvOfjMXs:APA91bHOcotCNaioU_hLul4_6CbHv8NW4Vfoi_vm97rJB3dv0Ff3IcmkOb1h5hpvmEJtiGydFCMBXBeguCi2H3DftknYx-iLAIOMQCVXVqXxK9PO83f6y3yEywYmpqBkLHlU3qQppOM6',
                     'Content-Type'  => 'application/json',
                  ],
                ]);

            }

        } 

        if($voucherbiasa){

            if($voucherbiasa->jenis == null){

                // ==UPDATE VOUCHER DIAMBIL ==
                $updates = VoucherDetails::where(['id'=>$voucherbiasa->id])
                ->update(['status'=> 'selesai']);

            }

        }


        if($cekwilayah->wilayah_id == $user->wilayah_id){

            if($transx->status == 'APPROVED'){

                $transactionz = array(    
                    'status' => '1',
                );
                
                return response()->json($transactionz);
                
            } else {

                $details = TransaksiDetails::select("transaction_details.*","transactions.user_id","posts.type","transactions.status")
                ->leftJoin("transactions", "transaction_details.transaction_id", "=", "transactions.id")
                ->leftJoin("posts", "transaction_details.post_id", "=", "posts.id")
                ->leftJoin('orders', 'transactions.id', '=', 'orders.transaction_id')
                ->where("transaction_details.transaction_id", $request->trans_id)
                ->get();

                $clocks = Transaksi::where(['id'=>$request->trans_id])
                ->update(['status'=>'APPROVED', 'petugas_id'=>$user->id]);

                // === MENJADI MEMBER PETUGAS ====

                $cekmember = UserMembers::where("member_id", $transx->user_id)
                ->first();

                if(!$cekmember){

                    $create = new UserMembers();
                    $create->member_id = $transx->user_id;
                    $create->user_id = $user->id;
                    $create->transaction_id = $request->trans_id;
                    $create->save();

                }

                $orders = Order::where(['transaction_id'=>$request->trans_id])
                ->update(['status'=>'Selesai']);

                $uuid = Uuid::generate();

                $tranc = Transaksi::where("id", $request->trans_id)
                ->first();

                $orderan = Order::select("orders.*","users.email","users.fcm_token","users.name as username")
                ->leftJoin("transactions", "orders.transaction_id", "=", "transactions.id")
                ->leftJoin("users", "transactions.user_id", "=", "users.id")
                ->where("transaction_id", $request->trans_id)
                ->first();

                // ====== KIRIM EMAIL =======

                $transaksis = OrderDetails::select("posts.*","order_details.qty","order_details.amount","product.name as prod_name")
                ->leftJoin("posts", "order_details.post_id", "=", "posts.id")
                ->leftJoin("product", "posts.product_id", "=", "product.id")
                ->where("order_details.order_id", $orderan->id)
                ->get();

                // ===== SELESAI KIRIM EMAIL ====
                foreach($details as $detail){

                    $adasaldo = Saldo::leftJoin("posts", "saldo.post_id", "=", "posts.id")
                    ->where([
                        ['saldo.user_id', '=', $detail->user_id],
                        ['saldo.product_id', '=', $detail->product_id],
                        ['post_id', '=', $detail->post_id],
                        ['status', '=', null],
                    ])
                    ->orderBy("saldo.id", "desc")
                    ->first();
                 
                    $saldo = new Saldo();
                    $saldo->uuid = Uuid::generate();
                    $saldo->user_id = $detail->user_id;
                    $saldo->product_id = $detail->product_id;
                    $saldo->transaction_id = $request->trans_id;
                    $saldo->post_id = $detail->post_id;

                    if(!$adasaldo){

                        $saldo->before = '0';
                        $saldo->sisa = $detail->qty;

                    } else {

                        $saldo->before = $adasaldo->sisa;
                        $saldo->sisa = $detail->qty + $adasaldo->sisa;

                    }
                    $saldo->save();

                    // ===== DAPAT POIN =====

                    $cekpost = Posts::select("post_codes.poin")
                    ->leftJoin("post_codes", "posts.code_id", "=", "post_codes.id")
                    ->where('posts.id', $detail->post_id)
                    ->first();

                    $trsaldo = new TransSaldoPoin();
                    $trsaldo->user_id = $detail->user_id;
                    $trsaldo->transaction_id = $request->trans_id;
                    $trsaldo->type = "in";
                    $trsaldo->amount = $cekpost->poin * $detail->qty;
                    $trsaldo->save();

                    $saldopoin = SaldoPoin::where("user_id", $detail->user_id)
                    ->orderBy("id", "desc")
                    ->first();

                    $saldonya = new SaldoPoin();
                    $saldonya->transpoin_id = $trsaldo->id;
                    $saldonya->user_id = $detail->user_id;
                    if(!$saldopoin){

                        $saldonya->before = '0';
                        $saldonya->sisa = $cekpost->poin * $detail->qty;

                    } else {

                        $saldonya->before = $saldopoin->sisa;
                        $saldonya->sisa = ($cekpost->poin * $detail->qty) + $saldopoin->sisa;

                    }
                    $saldonya->save();


                }

                // ===== JIKA BAYAR SEKALIGUS REEDEM ======

                // if($orderan->reedem == 'Yes'){

                //     $uuide = Uuid::generate();
                //     $codee = substr($uuide,0,8);

                //     $codes = date('d').$codee;

                //     $trans = new Transaksi();
                //     $trans->uuid = $codes;
                //     $trans->user_id = $tranc->user_id;
                //     $trans->type = 'out';
                //     $trans->petugas_id = $tranc->petugas_id;
                //     $trans->wilayah_id = $cekwilayah->wilayah_id;
                //     $trans->status = 'APPROVED';
                //     $trans->ket = 'Reedem Sekarang';
                //     $trans->plan = date('Y-m-d H:i');
                //     $trans->save();

                //     $detailnyas = TransaksiDetails::select("transaction_details.*","transactions.user_id")
                //     ->leftJoin("transactions", "transaction_details.transaction_id", "=", "transactions.id")
                //     ->where("transaction_id", $request->trans_id)
                //     ->get();

                //     foreach($detailnyas as $detailnya){

                //         $transdet = new TransaksiDetails();
                //         $transdet->transaction_id = $trans->id;
                //         $transdet->post_id = $detailnya->post_id;
                //         $transdet->product_id = $detailnya->product_id;
                //         $transdet->qty = $detailnya->qty;
                //         $transdet->save();

                //         $saldoc = Saldo::select("sisa")
                //         ->where([
                //             ['user_id', '=', $detailnya->user_id],
                //             ['post_id', '=', $detailnya->post_id],
                //             ['product_id', '=', $detailnya->product_id],
                //             ['status', '=', null],
                //         ])
                //         ->orderBy("id", "desc")
                //         ->first();

                //         $sisa = $saldoc->sisa - $detailnya->qty;

                //         $transaldo = new Saldo();
                //         $transaldo->user_id = $detailnya->user_id;
                //         $transaldo->product_id = $detailnya->product_id;
                //         $transaldo->transaction_id = $trans->id;
                //         $transaldo->post_id = $detailnya->post_id;
                //         $transaldo->before = $saldoc->sisa;
                //         $transaldo->sisa = $sisa;
                //         $transaldo->save();

                //     }
                // }


                // ==== CEK DAPAT UNDIAN =====

                $orderannya = Order::where("transaction_id", $request->trans_id)
                ->first();

                $totalbayar = (int)$orderannya->amount;

                $undian = Undian::select("undians.*")
                ->whereDate("dari" ,"<=" ,$date)
                ->whereDate("sampai" ,">=" ,$date)
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
                        $undvcr->transaction_id = $request->trans_id;
                        $undvcr->code = date('H').$code.date('i').$i;
                        $undvcr->save();

                    }

                }


                // === CEK DAPAT CASHBACK ====

                if($voucherbiasa){

                    if($voucherbiasa->jenis == "cashback"){

                        $uuid = Uuid::generate();
                        $code = substr($uuid,0,8);

                        $cashb = new SaldoTrans();
                        $cashb->uuid = $code."d";
                        $cashb->user_id = $transx->user_id;
                        $cashb->transaction_id = $transx->id;
                        $cashb->type = "in";
                        $cashb->amount = $voucherbiasa->amount;
                        $cashb->petugas_id = $user->id;
                        $cashb->save();

                        $ceksaldo = SaldoUang::where("user_id", $transx->user_id)
                        ->orderBy("id","desc")
                        ->first();

                        $uangs = new SaldoUang();
                        $uangs->user_id = $transx->user_id;
                        $uangs->saldotrans_id = $cashb->id;
                        if($ceksaldo){
                            $uangs->before = $ceksaldo->sisa;
                            $uangs->sisa = $ceksaldo->sisa + $voucherbiasa->amount;
                        } else {
                            $uangs->before = 0;
                            $uangs->sisa = $voucherbiasa->amount;
                        }    
                        $uangs->save();
                        

                    }

                }


                // ====== SELESAI ====

                $transactionz = array(    
                    'fcm' => $orderan->fcm_token,
                    'name' => $orderan->username,
                    'status' => '0',
                    'reedem' => $orderan->reedem,
                    'wilayah_id' => $cekwilayah->wilayah_id,
                );
                
                return response()->json($transactionz);

            }


        } else {

            $transactionz = array(    
                'status' => '2',
            );
            
            return response()->json($transactionz);

        }

    }

    public function editqty(Request $request)
    {
        $kranjang = Keranjang::select("keranjang.*", "posts.name as post_name")
        ->leftJoin("posts", "keranjang.post_id", "=", "posts.id")
        ->where('keranjang.id',$request->id)
        ->first();

        return response()->json($kranjang);
    }

    public function updateqty(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');

        $updatess = Keranjang::findOrFail($request->id);
        $updatess->qty = $request->qty;
        $updatess->save();

        return response()->json($updatess);

    }

    public function updatekeranjang(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');

        $countss = count($request->id);

        for($i=0; $i < $countss; $i++){

            $postdet = Keranjang::findOrFail($request->id[$i]);
            $postdet->qty = $request->qty[$i];
            if($request->method == 'Local'){
                $postdet->reedem = 'No';
            } else {
                $postdet->reedem = $request->method;
            }

            if($request->method == 'Yes'){
                 $postdet->delivery = NULL;
            } else {
                 $postdet->delivery = 'Y';
            }

            if($request->method == 'Local'){

                $postdet->delivery_amount = 0;
                $postdet->delivery_name = "kurirtoko";
                $postdet->delivery_type = NULL;
            }            

            $postdet->save();

        }

        return response()->json($countss);

    }

    public function min(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $user = Auth::user();


        if($request->qty == "" || $request->qty == 0){
            $qty = 1;
        } else {
            $qty = $request->qty;

        }

        $post = Keranjang::select("posts.*")
        ->leftJoin("posts", "keranjang.post_id", "=", "posts.id")
        ->where("keranjang.id", $request->id)
        ->first();

        if($post->min_qty != NULL){

            if($qty < $post->min_qty){
                $qty = $post->min_qty;
            } else if($qty > $post->max_qty){
                $qty = $post->max_qty;
            } else {
                $qty = $qty;
            }

        } 

        $keranjang = Keranjang::where(['id'=>$request->id])
        ->update(['qty'=>$qty]);

        $userkeranjang = Keranjang::where("id", $request->id)
        ->first();

        // ===CEK TOTAL =====

        if($user->pemegangsaham == 'yes'){

            $pemegangsaham = Services::where('type', 'pemegangsaham')
            ->first();

            $diskon = $pemegangsaham->biaya;

        } else {

            $diskon = 0;

        }

        $kranjangs = Keranjang::select("posts.name","posts.harga_act","keranjang.qty","keranjang.id","product.img as img_name","wilayah.name as wilayah_name","product.name as prod_name","posts.img","posts.jenis","retailers.name as retailer_name","posts.weight","posts.min_qty")
        ->leftJoin("posts", "keranjang.post_id", "=", "posts.id")
        ->leftJoin("users", "posts.user_id", "=", "users.id")
        ->leftJoin("wilayah", "users.wilayah_id", "=", "wilayah.id")
        ->leftJoin("product", "posts.product_id", "=", "product.id")
        ->leftJoin("retailers", "keranjang.retailer_id", "=", "retailers.id")
        ->where([
            ['keranjang.user_id', '=', $userkeranjang->user_id],
            ['voucherdet_id', '=', NULL],
            ['posts.type', '=', 'Products'],
        ])
        ->get();


        $total =0;

        foreach($kranjangs as $kranjang){

            $total += $kranjang->qty * $kranjang->harga_act - ceil($kranjang->harga_act * (float)$diskon / 100);

        }

        $cek = Keranjang::select("vouchers.*","keranjang.voucherdet_id","keranjang.id as keranjangid")
        ->leftJoin("voucher_details", "keranjang.voucherdet_id", "=", "voucher_details.id")
        ->leftJoin("vouchers", "voucher_details.voucher_id", "=", "vouchers.id")
        ->where("keranjang.user_id", $userkeranjang->user_id)
        ->where("keranjang.voucherdet_id", '!=', NULL)
        ->first();

        if($cek){

            $vouc = VoucherDetails::select("voucher_details.id")
            ->join("vouchers", "voucher_details.voucher_id", "=", "vouchers.id")
            ->where([
                ['voucher_details.id', '=', $cek->voucherdet_id],
                ['status', '=', null],
                ['vouchers.dari', '<=', date('Y-m-d')],
                ['vouchers.sampai', '>=', date('Y-m-d')],
            ])
            ->first();

            // === CEK VOUCHERNYA KADALUARSA KAGA ===

            if($vouc){

                if($cek->wilayah == "all"){

                    $voucwilayah = VoucherDetails::select("voucher_details.id")
                    ->join("vouchers", "voucher_details.voucher_id", "=", "vouchers.id")
                    ->where([
                        ['voucher_details.id', '=', $cek->voucherdet_id],
                    ])
                    ->first();

                } else {

                    $vouc = explode(",", $cek->wilayah);

                    $voucwilayah = Users::whereIn('wilayah_id', $vouc)
                    ->where("id", $userkeranjang->user_id)
                    ->first();

                }

                // === CEK WILAYAH NYA ADA KAGA ===

                if($voucwilayah){

                    // ==== CEK JENIS VOUCHER ====

                    if($cek->jenis == "cashback"){

                        $ada = Keranjang::select("posts.id")
                        ->leftJoin("posts", "keranjang.post_id", "=", "posts.id")
                        ->where([
                            ['keranjang.user_id', '=', $userkeranjang->user_id],
                            ['posts.product_id', '=', 16],
                        ])
                        ->first();

                        // ==== CEK PRODUK ====

                        if($ada){

                            $hapus = Keranjang::where("id",$cek->keranjangid)
                            ->delete();

                        } else {

                            // ==== CEK TRANSAKSI ====

                            $cektra = Order::select("transactions.id")
                            ->join("transactions", "orders.transaction_id", "=", "transactions.id")
                            ->where([
                                ['orders.voucherdet_id', '=', $cek->voucherdet_id],
                                ['transactions.user_id', '=', $userkeranjang->user_id],
                            ])
                            ->first();

                            if($cektra){

                                $hapus = Keranjang::where("id",$cek->keranjangid)
                                ->delete();

                            } 


                        }


                    } else {

                        if($cek->product == "satuan"){

                            if($cek->minimal >= $total){

                                $hapus = Keranjang::where("id",$cek->keranjangid)
                                ->delete();

                            } else {

                                $voucod = explode(",", $cek->codes);

                                $adaprod = Keranjang::select("posts.id")
                                ->leftJoin("posts", "keranjang.post_id", "=", "posts.id")
                                ->where('keranjang.user_id', '=', $user->id)
                                ->whereIn('posts.code_id', $voucod)
                                ->first();

                                if(!$adaprod){

                                    $hapus = Keranjang::where("id",$cek->keranjangid)
                                    ->delete();    

                                } 

                            }

                        } else if($cek->product == "except"){


                            if($cek->minimal >= $total){

                                $hapus = Keranjang::where("id",$cek->keranjangid)
                                ->delete();

                            } 


                        } 

                    }


                } else {

                    $hapus = Keranjang::where("id",$cek->keranjangid)
                    ->delete();

                }
  
            } else {

                $hapus = Keranjang::where("id",$cek->keranjangid)
                ->delete();

            }

        } 

        $ker = Keranjang::where("id", $request->id)
        ->first();

        return response()->json($ker);

    }

    public function voucher(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $user = Auth::user();

        $vouchers = VoucherDetails::select("voucher_details.id","vouchers.wilayah","vouchers.jenis","vouchers.product","vouchers.codes","vouchers.minimal")
        ->join("vouchers", "voucher_details.voucher_id", "=", "vouchers.id")
        ->where([
            ['voucher_details.kode', '=', $request->kode],
            ['status', '=', null],
            ['vouchers.type', '=', null],
        ])
        ->first();  

        if($user->pemegangsaham == 'yes'){

            $pemegangsaham = Services::where('type', 'pemegangsaham')
            ->first();

            $diskon = $pemegangsaham->biaya;

        } else {

            $diskon = 0;

        }

        $kranjangs = Keranjang::select("posts.name","posts.harga_act","keranjang.qty","keranjang.id","product.img as img_name","wilayah.name as wilayah_name","product.name as prod_name","posts.img","posts.jenis","retailers.name as retailer_name","posts.weight","posts.min_qty")
        ->leftJoin("posts", "keranjang.post_id", "=", "posts.id")
        ->leftJoin("users", "posts.user_id", "=", "users.id")
        ->leftJoin("wilayah", "users.wilayah_id", "=", "wilayah.id")
        ->leftJoin("product", "posts.product_id", "=", "product.id")
        ->leftJoin("retailers", "keranjang.retailer_id", "=", "retailers.id")
        ->where([
            ['keranjang.user_id', '=', $user->id],
            ['voucherdet_id', '=', NULL],
            ['posts.type', '=', 'Products'],
        ])
        ->get();


        $total =0;

        foreach($kranjangs as $kranjang){

            $total += $kranjang->qty * $kranjang->harga_act - ceil($kranjang->harga_act * (float)$diskon / 100);

        }

        // === CEK ADA APA KAGA ===

        if($vouchers){

            $vouc = VoucherDetails::select("voucher_details.id")
            ->join("vouchers", "voucher_details.voucher_id", "=", "vouchers.id")
            ->where([
                ['voucher_details.kode', '=', $request->kode],
                ['status', '=', null],
                ['voucher_details.dari', '<=', date('Y-m-d')],
                ['voucher_details.sampai', '>=', date('Y-m-d')],
            ])
            ->first();

            // === CEK VOUCHERNYA KADALUARSA KAGA ===

            if($vouc){

                if($vouchers->wilayah == "all"){

                    $voucwilayah = VoucherDetails::select("voucher_details.id")
                    ->join("vouchers", "voucher_details.voucher_id", "=", "vouchers.id")
                    ->where([
                        ['voucher_details.kode', '=', $request->kode],
                    ])
                    ->first();

                } else {

                    $vouc = explode(",", $vouchers->wilayah);

                    $voucwilayah = Users::whereIn('wilayah_id', $vouc)
                    ->where("id", $user->id)
                    ->first();

                }

                // === CEK WILAYAH NYA ADA KAGA ===

                if($voucwilayah){

                    // ==== CEK JENIS VOUCHER ====

                    if($vouchers->jenis == "cashback"){

                        $ada = Keranjang::select("posts.id")
                        ->leftJoin("posts", "keranjang.post_id", "=", "posts.id")
                        ->where([
                            ['keranjang.user_id', '=', $user->id],
                            ['posts.product_id', '=', 16],
                        ])
                        ->first();

                        // ==== CEK PRODUK ====

                        if($ada){

                            $data = 4;

                        } else {

                            // ==== CEK TRANSAKSI ====

                            $cektra = Order::select("transactions.id")
                            ->join("transactions", "orders.transaction_id", "=", "transactions.id")
                            ->where([
                                ['orders.voucherdet_id', '=', $vouchers->id],
                                ['transactions.user_id', '=', $user->id],
                            ])
                            ->first();

                            if($cektra){

                                $data = 5;

                            } else {

                                $del = Keranjang::where("user_id",$user->id)
                                ->where("voucherdet_id","!=",NULL)
                                ->delete();

                                $keranjang = new Keranjang();
                                $keranjang->user_id = $user->id;
                                $keranjang->voucherdet_id = $vouchers->id;
                                $keranjang->save();

                                $data = 1;
                            }


                        }


                    } else {

                        if($vouchers->product == "satuan"){

                            if($vouchers->minimal >= $total){

                                $data = 6;

                            } else {

                                $voucod = explode(",", $vouchers->codes);

                                $adaprod = Keranjang::select("posts.id")
                                ->leftJoin("posts", "keranjang.post_id", "=", "posts.id")
                                ->where('keranjang.user_id', '=', $user->id)
                                ->whereIn('posts.code_id', $voucod)
                                ->first();

                                if($adaprod){

                                    $del = Keranjang::where("user_id",$user->id)
                                    ->where("voucherdet_id","!=",NULL)
                                    ->delete();

                                    $keranjang = new Keranjang();
                                    $keranjang->user_id = $user->id;
                                    $keranjang->voucherdet_id = $vouchers->id;
                                    $keranjang->save();

                                    $data = 1;
                                    

                                } else {

                                    $data = 4;
                                }

                            }

                        } else if($vouchers->product == "except"){


                            if($vouchers->minimal >= $total){

                                $data = 6;

                            } else {


                                $voucod = explode(",", $vouchers->codes);

                                $adaprod = Keranjang::select("posts.id")
                                ->leftJoin("posts", "keranjang.post_id", "=", "posts.id")
                                ->where('keranjang.user_id', '=', $user->id)
                                ->whereIn('posts.code_id', $voucod)
                                ->first();

                                if($adaprod){

                                    $data = 4;

                                } else {

                                    $del = Keranjang::where("user_id",$user->id)
                                    ->where("voucherdet_id","!=",NULL)
                                    ->delete();

                                    $keranjang = new Keranjang();
                                    $keranjang->user_id = $user->id;
                                    $keranjang->voucherdet_id = $vouchers->id;
                                    $keranjang->save();

                                    $data = 1;
                                    
                                }

                            }


                        } else {

                            $del = Keranjang::where("user_id",$user->id)
                            ->where("voucherdet_id","!=",NULL)
                            ->delete();

                            $keranjang = new Keranjang();
                            $keranjang->user_id = $user->id;
                            $keranjang->voucherdet_id = $vouchers->id;
                            $keranjang->save();

                            $data = 1;

                        } 

                    }

                    

                } else {

                    $data = 3;

                }
  
            } else {
                $data = 0;
            }

        } else {

            $data = 2;

        }

        return response()->json($data);

    }

    public function nolbayar(Request $request)
    {

        date_default_timezone_set('Asia/Jakarta');
        $user = Auth::user();
        $dates = date('d');
        $service = Services::first();

        $keranjangs = Keranjang::select("posts.*","posts.img as img_name","keranjang.qty")
        ->leftJoin("posts", "keranjang.post_id", "=", "posts.id")
        ->where([
            ['keranjang.user_id', '=', $user->id],
            ['voucherdet_id', '=', null],
            ['posts.type', '=', 'Products'],
        ])
        ->get();

        $voucher = Keranjang::where([
            ['user_id', '=', $user->id],
            ['voucherdet_id', '!=', null],
        ])
        ->first();

        $uuid = Uuid::generate();
        $code = substr($uuid,0,8);

        $trans = new Transaksi();
        $trans->uuid = $code.$dates;
        $trans->user_id = $user->id;
        $trans->type = 'in';
        $trans->status = 'APPROVED';
        $trans->save();

        $total = 0;

        foreach ($keranjangs as $keranjang) {

            $totalss = $keranjang->harga_act + ceil($keranjang->harga_act * (float)$service->biaya / 100);

            $total += $keranjang->qty * $totalss;

        }

        $donation = new Order();
        $donation->uuid = $uuid;
        $donation->transaction_id = $trans->id;
        $donation->user_id = $user->id;
        $donation->type_bayar = 'ONLINE';
        $donation->status = 'selesai';
        $donation->order_type = 'Pembelian Deals/Product';
        $donation->amount = floatval($total);
        $donation->reedem = $request->reedem;
        $donation->voucherdet_id = $voucher->voucherdet_id;
        $donation->save();

        foreach ($keranjangs as $keranjang) {

            $totalx = $keranjang->harga_act + ceil($keranjang->harga_act * (float)$service->biaya / 100);

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

        try{
            Mail::send('email.bayaronline', ['nama' => $orderan->username, 'amount' => $orderan->amount, 'transaksis' => $transaksis], function ($message) use ($emails)
            {
                $message->subject('Terimakasih sudah Membayar secara ONLINE!');
                $message->from('admin@tomxperience.id', 'Admin Tomxperience.id');
                $message->to($emails);
            });

        }
        catch (Exception $e){
            return response (['status' => false,'errors' => $e->getMessage()]);
        }


        // ========== SELESAI =========
        $trandetails = TransaksiDetails::select("transactions.user_id","transaction_details.product_id","transaction_details.transaction_id","transaction_details.post_id","transaction_details.qty","posts.type")
        ->leftJoin("transactions", "transaction_details.transaction_id", "=", "transactions.id")
        ->leftJoin("posts", "transaction_details.post_id", "=", "posts.id")
        ->where("transaction_details.transaction_id", $trans->id)
        ->get();

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


        if($request->reedem == 'Yes'){

            $codee = substr($trans->uuid,5,5);
            $codesx = '0'.date('d').$codee.'22';

            $tranx = new Transaksi();
            $tranx->uuid = $codesx;
            $tranx->user_id = $user->id;
            $tranx->type = 'out';
            $tranx->status = 'REEDEM';
            $tranx->ket = 'Reedem Sekarang';
            $tranx->plan = date('Y-m-d H:i');
            $tranx->save();

            $detailnyas = TransaksiDetails::select("transaction_details.*","transactions.user_id")
            ->leftJoin("transactions", "transaction_details.transaction_id", "=", "transactions.id")
            ->where("transaction_id", $trans->id)
            ->get();

            foreach($detailnyas as $detailnya){

                $transdet = new TransaksiDetails();
                $transdet->transaction_id = $tranx->id;
                $transdet->post_id = $detailnya->post_id;
                $transdet->product_id = $detailnya->product_id;
                $transdet->qty = $detailnya->qty;
                $transdet->save();

                $saldoc = Saldo::select("sisa")
                ->where([
                    ['user_id', '=', $detailnya->user_id],
                    ['post_id', '=', $detailnya->post_id],
                    ['product_id', '=', $detailnya->product_id],
                    ['status', '=', null],
                ])
                ->orderBy("id", "desc")
                ->first();

                $sisa = $saldoc->sisa - $detailnya->qty;

                $transaldo = new Saldo();
                $transaldo->user_id = $detailnya->user_id;
                $transaldo->product_id = $detailnya->product_id;
                $transaldo->transaction_id = $tranx->id;
                $transaldo->post_id = $detailnya->post_id;
                $transaldo->before = $saldoc->sisa;
                $transaldo->sisa = $sisa;
                $transaldo->save();

            }

            $transactionx = TransaksiDetails::select("transaction_details.*","posts.name as post_name", "product.name as product_name","posts.type","transactions.user_id")
            ->leftJoin("transactions", "transaction_details.transaction_id", "=", "transactions.id")
            ->leftJoin("posts", "transaction_details.post_id", "=", "posts.id")
            ->leftJoin("product", "transaction_details.product_id", "=", "product.id")
            ->where("transactions.id", $tranx->id)
            ->get();

            $wilayah = Transaksi::select("users.wilayah_id","posts.type","wilayah.name","wilayah.alamat")
            ->leftJoin("transaction_details", "transactions.id", "=", "transaction_details.transaction_id")
            ->leftJoin("posts", "transaction_details.post_id", "=", "posts.id")
            ->leftJoin("users", "posts.user_id", "=", "users.id")
            ->leftJoin("wilayah", "users.wilayah_id", "=", "wilayah.id")
            ->where("transactions.id", $tranx->id)
            ->first();

            $emails = $user->email;

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


        }

        $keranjang = VoucherDetails::where(['id'=>$voucher->voucherdet_id])
        ->update(['status'=>'selesai']);

        $keranjanghapus = Keranjang::leftJoin("posts", "keranjang.post_id", "=", "posts.id")
        ->where([
            ['keranjang.user_id', '=', $user->id],
            ['posts.type', '=', 'Products'],
        ])
        ->delete();

        $cekwilayah = Transaksi::select("users.wilayah_id","posts.type","wilayah.name","wilayah.alamat")
        ->leftJoin("transaction_details", "transactions.id", "=", "transaction_details.transaction_id")
        ->leftJoin("posts", "transaction_details.post_id", "=", "posts.id")
        ->leftJoin("users", "posts.user_id", "=", "users.id")
        ->leftJoin("wilayah", "users.wilayah_id", "=", "wilayah.id")
        ->where("transactions.id", $trans->id)
        ->first();

        $trx = array(    
            'reedem' => $request->reedem,
            'wilayah_id' => $cekwilayah->wilayah_id,
        );

        return response()->json($trx);

    }

    public function promo(Request $request)
    {

        date_default_timezone_set('Asia/Jakarta');
        $user = Auth::user();
        $hariini = date('Y-m-d H:i:s');

        $vouchers = Vouchers::where([
            ['dari', '<=', date('Y-m-d')],
            ['sampai', '>=', date('Y-m-d')],
        ])
        ->get();

        if($user->pemegangsaham == 'yes'){

            $pemegangsaham = Services::where('type', 'pemegangsaham')
            ->first();

            $diskon = $pemegangsaham->biaya;

        } else {

            $diskon = 0;

        }

        $kranjangs = Keranjang::select("posts.name","posts.harga_act","keranjang.qty","keranjang.id","product.img as img_name","wilayah.name as wilayah_name","product.name as prod_name","posts.img","posts.jenis","retailers.name as retailer_name","posts.weight","posts.min_qty")
        ->leftJoin("posts", "keranjang.post_id", "=", "posts.id")
        ->leftJoin("users", "posts.user_id", "=", "users.id")
        ->leftJoin("wilayah", "users.wilayah_id", "=", "wilayah.id")
        ->leftJoin("product", "posts.product_id", "=", "product.id")
        ->leftJoin("retailers", "keranjang.retailer_id", "=", "retailers.id")
        ->where([
            ['keranjang.user_id', '=', $user->id],
            ['voucherdet_id', '=', NULL],
            ['posts.type', '=', 'Products'],
        ])
        ->get();


        $total =0;

        foreach($kranjangs as $kranjang){

            $total += $kranjang->qty * $kranjang->harga_act - ceil($kranjang->harga_act * (float)$diskon / 100);

        }

        $adavoucher = VoucherDetails::select("vouchers.id","keranjang.id as kranjangid","vouchers.amount","vouchers.percent")
        ->join("vouchers", "voucher_details.voucher_id", "=", "vouchers.id")
        ->join("keranjang", "voucher_details.id", "=", "keranjang.voucherdet_id")
        ->where("keranjang.user_id", $user->id)
        ->first();


        return view('content.home.users.promo.index', compact('user','vouchers','hariini','total','adavoucher'));
    }


    public function pakaivoucher(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $user = Auth::user();

        $adavoucher = VoucherDetails::where("voucher_id", $request->id)
        ->first();

        $del = Keranjang::where("user_id",$user->id)
        ->where("voucherdet_id","!=",NULL)
        ->delete();

        $keranjang = new Keranjang();
        $keranjang->user_id = $user->id;
        $keranjang->voucherdet_id = $adavoucher->id;
        $keranjang->save();


        return response()->json($keranjang);

    }

    public function removevoucher(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $user = Auth::user();

        $cek = Keranjang::where("user_id", $user->id)
        ->where('voucherdet_id','!=' ,NULL)
        ->first();

        if($cek){

            $keranjang = Keranjang::where(['id'=>$cek->id])
            ->delete();

        } 

        return response()->json($cek);

    }

}
