<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services;
use App\Keranjang;
use App\Users;
use App\Transaksi;
use App\TransaksiDetails;
use App\Order;
use App\OrderDetails;
use App\VoucherDetails;
use App\Vouchers;
use App\TransSaldoPoin;
use GuzzleHttp\Client;
use App\Saldo;
use App\SaldoPoin;
use App\Posts;
use App\UndianVouchers;
use App\Undian;
use Uuid;
use Auth;

class DokuController extends Controller
{
    private static $hostUrl = 'https://api.doku.com/';
    private static $client;

    public function __construct(){
        self::$client = new \GuzzleHttp\Client;
    }

    public function payment(Request $request){

        date_default_timezone_set('Asia/Jakarta');
        $user = Auth::user();

        $service = Services::first();

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

        $totals = Keranjang::select("keranjang.qty","posts.harga_act")
        ->leftJoin("posts", "keranjang.post_id", "=", "posts.id")
        ->where([
            ['keranjang.user_id', '=', $user->id],
            ['posts.type', '=', 'Products'],
        ])
        ->get();

        $sums = 0;
        foreach ($totals as $total ) {
            
            $tots = $total->harga_act - ceil($total->harga_act * (float)$diskon / 100);
            $sums += $total->qty * $tots;
        }

        $grandtotal = $sums;

        $adavoucher = Keranjang::select("vouchers.amount","keranjang.voucherdet_id","vouchers.jenis")
        ->leftJoin("voucher_details", "keranjang.voucherdet_id", "=", "voucher_details.id")
        ->leftJoin("vouchers", "voucher_details.voucher_id", "=", "vouchers.id")
        ->where("voucherdet_id","!=",NULL)
        ->where("user_id", $user->id)
        ->first();

        if($adavoucher){

            if($adavoucher->jenis == "cashback"){

                $grandtotal = (int)$sums;

            } else {

                $grandtotal = (int)$sums - (int)$adavoucher->amount;

            }        

        } else {

            $grandtotal = (int)$sums;

        }

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

        $trans = new Transaksi();
        $trans->uuid = $code.date('d');
        $trans->user_id = $user->id;
        $trans->wilayah_id = $wilayah->wilayah_id;
        $trans->type = 'in';
        $trans->status = 'NOT APPROVED';
        $trans->save();

        $reedem = Keranjang::leftJoin("posts", "keranjang.post_id", "=", "posts.id")
        ->where([
            ['keranjang.user_id', '=', $user->id],
            ['posts.type', '=', 'Products'],
        ])
        ->first();

        $donation = new Order();
        $donation->uuid = $uuid;
        $donation->transaction_id = $trans->id;
        $donation->user_id = $user->id;
        $donation->type_bayar = 'OVO';
        $donation->status = 'pending';
        $donation->amount = floatval($grandtotal);
        $donation->reedem = $reedem->reedem;
        $donation->voucherdet_id = $adavoucher ? $adavoucher->voucherdet_id : NULL;
        $donation->save();

        foreach ($keranjangs as $keranjang) {

            $totalss = $keranjang->harga_act - ceil($keranjang->harga_act * (float)$diskon / 100);

            $transorder = new OrderDetails();
            $transorder->order_id = $donation->id;
            $transorder->post_id = $keranjang->id;
            $transorder->qty = $keranjang->qty;
            $transorder->amount = $keranjang->qty * $totalss;
            $transorder->save();

            $transdet = new TransaksiDetails();
            $transdet->transaction_id = $trans->id;
            $transdet->post_id = $keranjang->id;
            $transdet->product_id = $keranjang->product_id;
            $transdet->qty = $keranjang->qty;
            $transdet->save();            
        }

        // ===== INI AKSES KE DOKU NYA ======

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

        // ===== INI AKSES KE DOKU NYA ======

        if($request->id == 3 || $request->id == 4){

            $clientId = "MCH-1259-8045231688420";
            $requestId = substr($donation->uuid,0,36);
            $dateTime = gmdate("Y-m-d H:i:s");
            $isoDateTime = date(DATE_ISO8601, strtotime($dateTime));
            $dateTimeFinal = substr($isoDateTime, 0, 19) . "Z";
            $targetPath = "/checkout/v1/payment"; // For merchant request to Jokul, use Jokul path here. For HTTP Notification, use merchant path here
            $secretKey = "SK-jCtFiEQPhZTRmS6f4Ler";

            if($request->id == 3){
                $method = 'VIRTUAL_ACCOUNT_BCA';
            } else {
                $method = 'VIRTUAL_ACCOUNT_BANK_MANDIRI';
            }

            $requestBody = array (
                'order' => array (
                    'amount' => $grandtotal,
                    'invoice_number' => 'INV'.date('ymd').$codenya.$codexx,
                ),
                'payment' => array (
                    'payment_due_date' => 60,
                    'payment_method_types' =>
                    array (
                    0 => $method,
                    ),
                ),
            );

            // Generate Digest
            $digestValue = base64_encode(hash('sha256', json_encode($requestBody), true));

            // Prepare Signature Component
            $componentSignature = "Client-Id:" . $clientId . "\n" . 
                                  "Request-Id:" . $requestId . "\n" .
                                  "Request-Timestamp:" . $dateTimeFinal . "\n" . 
                                  "Request-Target:" . $targetPath . "\n" .
                                  "Digest:" . $digestValue;

            $signature = base64_encode(hash_hmac('sha256', $componentSignature, $secretKey, true));


            $jayParsedAry2 = [
                "order" => [
                    'amount' => $grandtotal,
                    'invoice_number' => 'INV-'.date('Ymd').$codenya,
                ],
                "payment" => [
                    'payment_due_date' => 60,
                    'payment_method_types' => [
                        0 => $method,
                    ],
                ],
             ]; 

            $output = self::$client->request('POST', self::$hostUrl . '/checkout/v1/payment', [
                'headers' => [
                     'Client-Id' => 'MCH-0047-1633472116240',
                     'Content-Type'  => 'application/json',
                     'Request-Id'  => substr($donation->uuid,0,36),
                     'Request-Timestamp'  => $dateTimeFinal,
                     'Signature'  => "HMACSHA256=" .$signature,
                ],
                'json' => $jayParsedAry2,
            ]);

            $output = json_decode($output->getBody(), true);

            $result = $output['response']['payment']['url'];
            $token = $output['response']['payment']['token_id'];

            $orderzz = Transaksi::where(['id'=>$trans->id])
            ->update(['doku'=>$token]);

        } else if($request->id == 1){

            // === OVO ====
             date_default_timezone_set('Asia/Jakarta');

            $clientId = "MCH-1259-8045231688420";
            $requestId = substr($donation->uuid,0,36);
            $dateTime = gmdate("Y-m-d H:i:s");
            $isoDateTime = date(DATE_ISO8601, strtotime($dateTime));
            $dateTimeFinal = substr($isoDateTime, 0, 19) . "Z";
            $targetPath = "/ovo-emoney/v1/payment"; // For merchant request to Jokul, use Jokul path here. For HTTP Notification, use merchant path here
            $secretKey = "SK-jCtFiEQPhZTRmS6f4Ler";
            $invoicenumber = 'INV'.date('ymd').$codenya.$codexx;
            $ovoid = $user->ovo;
            $gabungan = $grandtotal.$clientId.$invoicenumber.$ovoid.$secretKey;

            $cheksum = hash('sha256', $gabungan);

            $requestBody = array (
                'client' => array (
                    "id" => $clientId,
                ),
                'order' => array (
                    "invoice_number" => $invoicenumber,
                    "amount" => $grandtotal,
                ),
                'ovo_info' => array (
                    "ovo_id" => $ovoid,
                ),
                'security' => array (
                    "check_sum" => $cheksum,
                )
            );

            // Generate Digest
            $digestValue = base64_encode(hash('sha256', json_encode($requestBody), true));

            // Prepare Signature Component
            $componentSignature = "Client-Id:" . $clientId . "\n" . 
                                  "Request-Id:" . $requestId . "\n" .
                                  "Request-Timestamp:" . $dateTimeFinal . "\n" . 
                                  "Request-Target:" . $targetPath . "\n" .
                                  "Digest:" . $digestValue;

            $signature = base64_encode(hash_hmac('sha256', $componentSignature, $secretKey, true));

            $jayParsedAry2 = [
                "client" => [
                    'id' => $clientId,
                ],
                "order" => [
                    'invoice_number' => $invoicenumber,
                    'amount' => $grandtotal,
                ],
                "ovo_info" => [
                    'ovo_id' => $ovoid,
                ],
                "security" => [
                    'check_sum' => $cheksum,
                ],
             ];


            $output = self::$client->request('POST', self::$hostUrl . '/ovo-emoney/v1/payment', [
                'headers' => [
                     'Client-Id' => $clientId,
                     'Content-Type'  => 'application/json',
                     'Request-Id'  => $requestId,
                     'Request-Timestamp'  => $dateTimeFinal,
                     'Signature'  => "HMACSHA256=" .$signature,
                ],
                'json' => $jayParsedAry2,
            ]);

            $output = json_decode($output->getBody(), true);

            $result = array(    
                'status' => $output['ovo_payment']['status'],
                'transactionid' => $invoicenumber,
            );


        } else if($request->id == 2){

            // === SHOPPEE PAY ====

            $clientId = "MCH-1259-8045231688420";
            $requestId = substr($donation->uuid,0,36);
            $dateTime = gmdate("Y-m-d H:i:s");
            $isoDateTime = date(DATE_ISO8601, strtotime($dateTime));
            $dateTimeFinal = substr($isoDateTime, 0, 19) . "Z";
            $targetPath = "/shopeepay-emoney/v2/order"; // For merchant request to Jokul, use Jokul path here. For HTTP Notification, use merchant path here
            $secretKey = "SK-DCrO3TFQuVgyTPQUPdVm";


            $requestBody = array (
                'order' => array (
                    "invoice_number" => 'INV-'.date('Ymd').'-'.$codenya,
                    "amount" => $grandtotal
                )
            );

            // Generate Digest
            $digestValue = base64_encode(hash('sha256', json_encode($requestBody), true));

            // Prepare Signature Component
            $componentSignature = "Client-Id:" . $clientId . "\n" . 
                                  "Request-Id:" . $requestId . "\n" .
                                  "Request-Timestamp:" . $dateTimeFinal . "\n" . 
                                  "Request-Target:" . $targetPath . "\n" .
                                  "Digest:" . $digestValue;

            $signature = base64_encode(hash_hmac('sha256', $componentSignature, $secretKey, true));

            $jayParsedAry2 = [
                "order" => [
                    "invoice_number" => 'INV-'.date('Ymd').'-'.$codenya,
                    "amount" => $grandtotal
                ]
             ]; 

             // === CURL ===
            $url = self::$hostUrl . $targetPath;
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($requestBody));
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Client-Id:' . $clientId,
                'Request-Id:' . $requestId,
                'Request-Timestamp:' . $dateTimeFinal,
                'Signature:' . "HMACSHA256=" . $signature,
            ));
            // Set response json
            $responseJson = curl_exec($ch);
            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if (is_string($responseJson) && $httpcode == 200) {
                //echo $responseJson;
                $content=json_decode($responseJson,true);
                $result = $content['shopeepay_payment']['redirect_url_http'];

            } else {

                $result = 0;

            }

        }

        $keranjang = Keranjang::leftJoin("posts", "keranjang.post_id", "=", "posts.id")
        ->where('keranjang.user_id', '=', $user->id)
        ->delete();

        return response()->json($result);

    }

    public function payment2(Request $request){

        date_default_timezone_set('Asia/Jakarta');
        $user = Auth::user();

        // ===== INI AKSES KE DOKU NYA ======

        date_default_timezone_set('Asia/Jakarta');

        $transaksi = Transaksi::select("transactions.*","orders.amount","orders.uuid as orderuuid")
        ->leftJoin("orders", "transactions.id", "=", "orders.transaction_id")
        ->where("transactions.id", $request->id)
        ->first();

        $uuidnya = Uuid::generate();

        $panjang = strlen($transaksi->uuid);

        if($panjang == 18){

            $newinv = $transaksi->uuid.'1';

        } else if($panjang == 19) {

            $terakhir = substr($transaksi->uuid,-1);
            $tambah = $terakhir + 1;

            $newinv = $transaksi->uuid.$tambah;

        } else {

            $terakhir = substr($transaksi->uuid,-2);
            $tambah = $terakhir + 1;

            $newinv = $transaksi->uuid.$tambah;

        }

        $update = Transaksi::where(['id'=>$request->id])
        ->update(['uuid'=>$newinv]);


        $grandtotal = (int)$transaksi->amount;

        $clientId = "MCH-1259-8045231688420";
        $requestId = substr($uuidnya,0,36);
        $dateTime = gmdate("Y-m-d H:i:s");
        $isoDateTime = date(DATE_ISO8601, strtotime($dateTime));
        $dateTimeFinal = substr($isoDateTime, 0, 19) . "Z";
        $targetPath = "/ovo-emoney/v1/payment"; // For merchant request to Jokul, use Jokul path here. For HTTP Notification, use merchant path here
        $secretKey = "SK-jCtFiEQPhZTRmS6f4Ler";
        $invoicenumber = $newinv;
        $ovoid = $user->ovo;
        $gabungan = $grandtotal.$clientId.$invoicenumber.$ovoid.$secretKey;

        $cheksum = hash('sha256', $gabungan);

        $requestBody = array (
            'client' => array (
                "id" => $clientId,
            ),
            'order' => array (
                "invoice_number" => $invoicenumber,
                "amount" => $grandtotal,
            ),
            'ovo_info' => array (
                "ovo_id" => $ovoid,
            ),
            'security' => array (
                "check_sum" => $cheksum,
            )
        );

        // Generate Digest
        $digestValue = base64_encode(hash('sha256', json_encode($requestBody), true));

        // Prepare Signature Component
        $componentSignature = "Client-Id:" . $clientId . "\n" . 
                              "Request-Id:" . $requestId . "\n" .
                              "Request-Timestamp:" . $dateTimeFinal . "\n" . 
                              "Request-Target:" . $targetPath . "\n" .
                              "Digest:" . $digestValue;

        $signature = base64_encode(hash_hmac('sha256', $componentSignature, $secretKey, true));

        $jayParsedAry2 = [
            "client" => [
                'id' => $clientId,
            ],
            "order" => [
                'invoice_number' => $invoicenumber,
                'amount' => $grandtotal,
            ],
            "ovo_info" => [
                'ovo_id' => $ovoid,
            ],
            "security" => [
                'check_sum' => $cheksum,
            ],

         ];


        $output = self::$client->request('POST', self::$hostUrl . '/ovo-emoney/v1/payment', [
            'headers' => [
                 'Client-Id' => $clientId,
                 'Content-Type'  => 'application/json',
                 'Request-Id'  => $requestId,
                 'Request-Timestamp'  => $dateTimeFinal,
                 'Signature'  => "HMACSHA256=" .$signature,
            ],
            'json' => $jayParsedAry2,
        ]);

        $output = json_decode($output->getBody(), true);

        $result = array(    
            'status' => $output['ovo_payment']['status'],
            'transactionid' => $invoicenumber,
        );

        return response()->json($result);

    }

    public function ovoid(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');

        $user = Auth::user();

        $update = Users::where(['id'=>$user->id])
        ->update(['ovo'=>$request->ovo]);
        
        return response()->json($update);
    }

    public function ovosukses(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');

        $user = Auth::user();

        $transs = Transaksi::select("orders.id as order_id","transactions.*","orders.amount")
        ->leftJoin("orders", "transactions.id", "=", "orders.transaction_id")
        ->where("transactions.uuid", $request->uuid)
        ->first();

        $orderzz = Order::where(['id'=>$transs->order_id])
        ->update(['status'=>'selesai']);

        $cekorder = Order::where("id", $transs->order_id)
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

        $transupdate = Transaksi::where(['id'=>$transs->id])
        ->update(['status'=>'REEDEM','cash'=> NULL]);

        $trandetails = TransaksiDetails::select("transactions.user_id","transaction_details.product_id","transaction_details.transaction_id","transaction_details.post_id","transaction_details.qty","posts.type")
        ->leftJoin("transactions", "transaction_details.transaction_id", "=", "transactions.id")
        ->leftJoin("posts", "transaction_details.post_id", "=", "posts.id")
        ->where("transaction_details.transaction_id", $transs->id)
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

        // === DAPAT UNDIAN VOUCHER ====

        $totalbayar = (int)$transs->amount;

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
                $undvcr->transaction_id = $transs->id;
                $undvcr->code = date('H').$code.date('i').$i;
                $undvcr->save();

            }

        }
        
        return response()->json($transs);
    }

    public function notifications(Request $request) {
        
        $notificationHeader = getallheaders();
        $notificationBody = file_get_contents('php://input');
        $notificationPath = '/doku/notification/handler'; // Adjust according to your notification path
        $secretKey = 'SK-DCrO3TFQuVgyTPQUPdVm'; // Adjust according to your secret key

        $digest = base64_encode(hash('sha256', $notificationBody, true));
        $rawSignature = "Client-Id:" . $notificationHeader['Client-Id'] . "\n"
            . "Request-Id:" . $notificationHeader['Request-Id'] . "\n"
            . "Request-Timestamp:" . $notificationHeader['Request-Timestamp'] . "\n"
            . "Request-Target:" . $notificationPath . "\n"
            . "Digest:" . $digest;

        $signature = base64_encode(hash_hmac('sha256', $rawSignature, $secretKey, true));
        $finalSignature = 'HMACSHA256=' . $signature;

        if ($finalSignature == $notificationHeader['Signature']) {
            // TODO: Process if Signature is Valid

            $orderzz = Transaksi::where(['uuid'=>$notificationBody['order']['invoice_number']])
            ->update(['status'=>"APPROVED"]);

            $trancc = Transaksi::where("uuid",$notificationBody['order']['invoice_number'])
            ->first();

            $trandetails = TransaksiDetails::select("transactions.user_id","transaction_details.product_id","transaction_details.transaction_id","transaction_details.post_id","transaction_details.qty","posts.type")
            ->leftJoin("transactions", "transaction_details.transaction_id", "=", "transactions.id")
            ->leftJoin("posts", "transaction_details.post_id", "=", "posts.id")
            ->where("transaction_details.transaction_id", $trancc->id)
            ->get();

            foreach($trandetails as $details){
                 
                $adasaldo = Saldo::leftJoin("posts", "saldo.post_id", "=", "posts.id")
                ->where([
                    ['saldo.user_id', '=', $details->user_id],
                    ['saldo.product_id', '=', $details->product_id],
                    ['post_id', '=', $details->post_id],
                    ['status', '=', null],
                ])
                ->orderBy("saldo.id", "desc")
                ->first();
    
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

            // ===== JIKA BAYAR SEKALIGUS REEDEM ======

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
            ->where("transaction_id", $trancc->id)
            ->get();

            foreach($detailnyas as $detailnya){

                $transdet = new TransaksiDetails();
                $transdet->transaction_id = $trans->id;
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
                $transaldo->transaction_id = $trans->id;
                $transaldo->post_id = $detailnya->post_id;
                $transaldo->before = $saldoc->sisa;
                $transaldo->sisa = $sisa;
                $transaldo->save();

            }

            return response('OK', 200)->header('Content-Type', 'text/plain');

            // TODO: Do update the transaction status based on the `transaction.status`
        } else {
            // TODO: Response with 400 errors for Invalid Signature
            return response('Invalid Signature', 400)->header('Content-Type', 'text/plain');
        }
    }
}
