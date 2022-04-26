<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\OAuths;
use App\OAuthExps;
use App\Users;
use App\VABills;
use App\VAPayments;
use App\SaldoTrans;
use App\SaldoUang;
use GuzzleHttp\Client;
use Uuid;

class BCAController extends Controller
{
    private static $client;


    public function token(Request $request){

        date_default_timezone_set('Asia/Jakarta');
        $hariini = date('Y-m-d H:i:s');

        self::$client = new \GuzzleHttp\Client;

        $auth = OAuths::first();

        $code = 'Basic '.base64_encode($auth->client_id.':'.$auth->client_secret);

        $auth2 = $request->header('Authorization');
        $grant = $request->header('grant_type');

        if($code == $auth2){

            $uuid = Uuid::generate();
            $code = substr($uuid,0,8);
            $code2 = substr($uuid,24);

            $hasilcode = $code.'DP'.$code2;
            $jam = strtotime($hariini) + 3600;

            $exp = date('Y-m-d H:i:s', $jam);

            $create = new OAuthExps();
            $create->oauth_id = $auth->id;
            $create->access_token = $hasilcode;
            $create->expired = $exp;
            $create->save();

            $respone = array(    
                'access_token' => $hasilcode,
                'token_type' => 'Bearer',
                "expires_in" => 3600,
                "scope" => "resource.WRITE resource.READ"
            );
            

        } else {

            $respone = array(    
                'error_code' => 'ESB-14-002',
                'error_message' => [
                    "indonesian" => "Permintaan tidak valid",
                    "english" => "Invalid Request"
                ]

            );
        }

        

        return response()->json($respone);

    }

    public function bills(Request $request){

        $tokennya = OAuths::first();

        $auth = $request->header('Authorization');
        $tokennow = str_replace("Bearer ","",$auth);

        $apikey = $request->header('X-BCA-Key');
        $timeStamp = $request->header('X-BCA-Timestamp');

        $apikeytom = $tokennya->api_key;
        $signatureBCA = $request->header('X-BCA-Signature');

        $cekauth = OAuthExps::where("access_token", $tokennow)
        ->first();

        // $access_tokens = 'lIWOt2p29grUo59bedBUrBY3pnzqQX544LzYPohcGHOuwn8AUEdUKS';
        $bodyContent = $request->getContent();
        $bodyContent2 = json_decode($request->getContent(), true);

        $newbody = array(    
            "CompanyCode" => $bodyContent2['CompanyCode'],
            "CustomerNumber" => $bodyContent2['CustomerNumber'],
            "RequestID" => $bodyContent2['RequestID'],
            "ChannelType" => $bodyContent2['ChannelType'],
            "TransactionDate" => str_replace(" ", "", $bodyContent2['TransactionDate']),
            "AdditionalData" => str_replace(" ", "", $bodyContent2['AdditionalData']),
        );

        $canonicalize = json_encode($newbody, JSON_UNESCAPED_SLASHES);

        $HTTPMethod = 'POST';
        $relativeUrl = '/va/bill';

        // $secretapi = '22a2d25e-765d-41e1-8d29-da68dcb5698b';

        // ==== SIGNATURE ====

        $RequestBody = strtolower(hash('sha256', $canonicalize));

        $StringToSign = $HTTPMethod . ":" . $relativeUrl . ":" . $cekauth->access_token . ":" . $RequestBody . ":" . $timeStamp;

        $signatureTOM = hash_hmac('sha256',$StringToSign, $tokennya->api_secret);
        
        if($cekauth){

            if($apikey == $apikeytom){

                if($signatureBCA == $signatureTOM){

                    $company = json_decode($bodyContent)->CompanyCode;
                    $customer = json_decode($bodyContent)->CustomerNumber;
                    $requestid = json_decode($bodyContent)->RequestID;
                    $channel = json_decode($bodyContent)->ChannelType;
                    $tanggal = json_decode($bodyContent)->TransactionDate;

                    $remove = str_replace("/","-",$tanggal);

                    $formats = date('d/m/Y H:i:s',strtotime($remove));

                    $user = Users::where('va', $company.$customer)
                    ->first();

                    if($company != ""){

                        if($customer != ""){

                            if($user){

                                if($requestid != ""){

                                    if($channel != ""){

                                        if($tanggal != ""){

                                            if($tanggal == $formats){

                                                $create = new VABills();
                                                $create->company_code = $company;
                                                $create->user_id = $user->id;
                                                $create->request_id = $requestid;
                                                $create->channel_type = $channel;
                                                $create->date = date('Y-m-d H:i:s',strtotime($remove));
                                                $create->save();

                                                $respone = array(    
                                                    'CompanyCode' => $company,
                                                    'CustomerNumber' => $customer,
                                                    'RequestID' => $requestid,
                                                    'InquiryStatus' => '00',
                                                    'InquiryReason' => [
                                                        "Indonesian" => "Sukses",
                                                        "English" => "Success"
                                                    ],
                                                    'CustomerName' => $user->name,
                                                    'CurrencyCode' => "IDR",
                                                    'TotalAmount' => "0.00",
                                                    'SubCompany' => "00000",
                                                    'DetailBills' => [],
                                                    'FreeTexts' => [],
                                                    'AdditionalData' => ''

                                                );


                                            } else {

                                                $respone = array(    
                                                    'CompanyCode' => $company,
                                                    'CustomerNumber' => $customer,
                                                    'RequestID' => $requestid,
                                                    'InquiryStatus' => '01',
                                                    'InquiryReason' => [
                                                        "Indonesian" => "Format Tanggal Tidak Sesuai",
                                                        "English" => "Incorrect Format Date"
                                                    ],
                                                    'CustomerName' => $user->name,
                                                    'CurrencyCode' => "",
                                                    'TotalAmount' => "",
                                                    'SubCompany' => "",
                                                    'DetailBills' => [],
                                                    'FreeTexts' => [],
                                                    'AdditionalData' => ""

                                                );
                                            }

                                        } else {

                                            $respone = array(    
                                                'CompanyCode' => $company,
                                                'CustomerNumber' => $customer,
                                                'RequestID' => $requestid,
                                                'InquiryStatus' => '01',
                                                'InquiryReason' => [
                                                    "Indonesian" => "TransactionDate Kosong",
                                                    "English" => "TransactionDate Empty"
                                                ],
                                                'CustomerName' => $user->name,
                                                'CurrencyCode' => "",
                                                'TotalAmount' => "",
                                                'SubCompany' => "",
                                                'DetailBills' => [],
                                                'FreeTexts' => [],
                                                'AdditionalData' => ""

                                            );

                                        }


                                    } else {

                                        $respone = array(    
                                            'CompanyCode' => $company,
                                            'CustomerNumber' => $customer,
                                            'RequestID' => $requestid,
                                            'InquiryStatus' => '01',
                                            'InquiryReason' => [
                                                "Indonesian" => "ChannelType Kosong",
                                                "English" => "ChannelType Empty"
                                            ],
                                            'CustomerName' => $user->name,
                                            'CurrencyCode' => "",
                                            'TotalAmount' => "",
                                            'SubCompany' => "",
                                            'DetailBills' => [],
                                            'FreeTexts' => [],
                                            'AdditionalData' => ""

                                        );
                                    }


                                } else {

                                    $respone = array(    
                                        'CompanyCode' => $company,
                                        'CustomerNumber' => $customer,
                                        'RequestID' => $requestid,
                                        'InquiryStatus' => '01',
                                        'InquiryReason' => [
                                            "Indonesian" => "RequestID Kosong",
                                            "English" => "RequestID Empty"
                                        ],
                                        'CustomerName' => $user->name,
                                        'CurrencyCode' => "",
                                        'TotalAmount' => "",
                                        'SubCompany' => "",
                                        'DetailBills' => [],
                                        'FreeTexts' => [],
                                        'AdditionalData' => ""

                                    );

                                }


                            } else {

                                $respone = array(    
                                    'CompanyCode' => $company,
                                    'CustomerNumber' => $customer,
                                    'RequestID' => $requestid,
                                    'InquiryStatus' => '01',
                                    'InquiryReason' => [
                                        "Indonesian" => "CustomerNumber Tidak Ada",
                                        "English" => "CustomerNumber Not Found"
                                    ],
                                    'CustomerName' => "",
                                    'CurrencyCode' => "",
                                    'TotalAmount' => "",
                                    'SubCompany' => "",
                                    'DetailBills' => [],
                                    'FreeTexts' => [],
                                    'AdditionalData' => ""

                                );

                            }

                        } else {

                            $respone = array(    
                                'CompanyCode' => $company,
                                'CustomerNumber' => "",
                                'RequestID' => $requestid,
                                'InquiryStatus' => '01',
                                'InquiryReason' => [
                                    "Indonesian" => "CustomerNumber Kosong",
                                    "English" => "CustomerNumber Empty"
                                ],
                                'CustomerName' => "",
                                'CurrencyCode' => "",
                                'TotalAmount' => "",
                                'SubCompany' => "",
                                'DetailBills' => [],
                                'FreeTexts' => [],
                                'AdditionalData' => ""

                            );

                        }

                    } else {

                        $respone = array(    
                            'CompanyCode' => "",
                            'CustomerNumber' => $customer,
                            'RequestID' => $requestid,
                            'InquiryStatus' => '01',
                            'InquiryReason' => [
                                "Indonesian" => "CompanyCode Kosong",
                                "English" => "CompanyCode Empty"
                            ],
                            'CustomerName' => "",
                            'CurrencyCode' => "",
                            'TotalAmount' => "",
                            'SubCompany' => "",
                            'DetailBills' => [],
                            'FreeTexts' => [],
                            'AdditionalData' => ""

                        );

                    }


                } else {

                    $respone = array(    
                        'ErrorCode' => "...",
                        'ErrorMessage' => [
                            "indonesian" => "HMAC tidak cocok",
                            "english" => "HMAC mismatch"
                        ],
                    );


                }

            } else {

                $respone = array(    
                    'ErrorCode' => "...",
                    'ErrorMessage' => [
                        "indonesian" => "HMAC tidak cocok 2",
                        "english" => "HMAC mismatch"
                    ],
                );

            }

        } else {

            $respone = array(    
                'ErrorCode' => "...",
                'ErrorMessage' => [
                    "indonesian" => "HMAC tidak cocok",
                    "english" => "HMAC mismatch"
                ],
            );

        }

        return response()->json($respone);

    }


    public function payments(Request $request){

        $tokennya = OAuths::first();

        $auth = $request->header('Authorization');
        $tokennow = str_replace("Bearer ","",$auth);

        $apikey = $request->header('X-BCA-Key');
        $timeStamp = $request->header('X-BCA-Timestamp');
        $apikeytom = $tokennya->api_key;
        $signatureBCA = $request->header('X-BCA-Signature');

        $cekauth = OAuthExps::where("access_token", $tokennow)
        ->first();

        $bodyContent = $request->getContent();
        $bodyContent2 = json_decode($request->getContent(), true);

        $newbody = array(    
            "CompanyCode" => $bodyContent2['CompanyCode'],
            "CustomerNumber" => $bodyContent2['CustomerNumber'],
            "RequestID" => $bodyContent2['RequestID'],
            "ChannelType" => $bodyContent2['ChannelType'],
            "CustomerName" => str_replace(" ", "", $bodyContent2['CustomerName']),
            "CurrencyCode" => $bodyContent2['CurrencyCode'],
            "PaidAmount" => $bodyContent2['PaidAmount'],
            "TotalAmount" => $bodyContent2['TotalAmount'],
            "SubCompany" => $bodyContent2['SubCompany'],
            "TransactionDate" => str_replace(" ", "", $bodyContent2['TransactionDate']),
            "Reference" => $bodyContent2['Reference'],
            "DetailBills" => [null],
            "FlagAdvice" => $bodyContent2['FlagAdvice'],
            "AdditionalData" => str_replace(" ", "", $bodyContent2['AdditionalData']),
        );

        $canonicalize = json_encode($newbody, JSON_UNESCAPED_SLASHES);

        $HTTPMethod = 'POST';
        $relativeUrl = '/va/payments';

        // ==== SIGNATURE ====

        $RequestBody = strtolower(hash('sha256', $canonicalize));

        $StringToSign = $HTTPMethod . ":" . $relativeUrl . ":" . $cekauth->access_token . ":" . $RequestBody . ":" . $timeStamp;
        $signatureTOM = hash_hmac('sha256', $StringToSign, $tokennya->api_secret);

        // dd($signatureTOM);

        if($cekauth){

            if($apikey == $apikeytom){

                if($signatureBCA == $signatureTOM){

                    $company = json_decode($bodyContent)->CompanyCode;
                    $customer = json_decode($bodyContent)->CustomerNumber;
                    $customername = json_decode($bodyContent)->CustomerName;
                    $currency = json_decode($bodyContent)->CurrencyCode;
                    $requestid = json_decode($bodyContent)->RequestID;
                    $channel = json_decode($bodyContent)->ChannelType;
                    $tanggal = json_decode($bodyContent)->TransactionDate;
                    $paid = json_decode($bodyContent)->PaidAmount;
                    $total = json_decode($bodyContent)->TotalAmount;
                    $reference = json_decode($bodyContent)->Reference;
                    $advice = json_decode($bodyContent)->FlagAdvice;
                    $subcompany = json_decode($bodyContent)->SubCompany;

                    $remove = str_replace("/","-",$tanggal);

                    $formats = date('d/m/Y H:i:s',strtotime($remove));

                    $user = Users::where('va', $company.$customer)
                    ->first();

                    if($company != ""){

                        if($customer != ""){

                            if($user){

                                if($requestid != ""){

                                    if($channel != ""){

                                        if($customername != ""){

                                            if($currency != ""){

                                                if($paid != ""){

                                                    if($total != ""){

                                                        if($tanggal != ""){

                                                            if($tanggal == $formats){

                                                                if($advice != ""){

                                                                    if($advice == "Y" || $advice == "N"){

                                                                        if($subcompany != ""){

                                                                            if($reference != ""){

                                                                                $create = new VAPayments();
                                                                                $create->company_code = $company;
                                                                                $create->user_id = $user->id;
                                                                                $create->request_id = $requestid;
                                                                                $create->channel_type = $channel;
                                                                                $create->date = date("Y-m-d H:i:s", strtotime($remove));
                                                                                $create->currency_code = $currency;
                                                                                $create->paid = $paid;
                                                                                $create->total = $total;
                                                                                $create->subcompany = $subcompany;
                                                                                $create->reference = $reference;
                                                                                $create->flag_advice = $advice;
                                                                                $create->save();

                                                                                $dates = date('d');

                                                                                $uuid = Uuid::generate();
                                                                                $code = substr($uuid,0,8);

                                                                                $trans = new SaldoTrans();
                                                                                $trans->uuid = $code.$dates;
                                                                                $trans->user_id = $user->id;
                                                                                $trans->payment_id = $create->id;
                                                                                $trans->type = 'in';
                                                                                $trans->amount = $total-1000;
                                                                                $trans->save();

                                                                                $adasaldo = SaldoUang::where("user_id", $user->id)
                                                                                ->orderBy("id", "desc")
                                                                                ->first();

                                                                                $sald = new SaldoUang();
                                                                                $sald->user_id = $user->id;
                                                                                $sald->saldotrans_id = $trans->id;
                                                                                
                                                                                if(!$adasaldo){

                                                                                    $sald->before = '0';
                                                                                    $sald->sisa = $total-1000;

                                                                                } else {

                                                                                    $sald->before = $adasaldo->sisa;
                                                                                    $sald->sisa = ($total-1000) + $adasaldo->sisa;

                                                                                }
                                                                                
                                                                                $sald->save();

                                                                                $respone = array(    
                                                                                    'CompanyCode' => $company,
                                                                                    'CustomerNumber' => $customer,
                                                                                    'RequestID' => $requestid,
                                                                                    'PaymentFlagStatus' => '00',
                                                                                    'PaymentFlagReason' => [
                                                                                        "Indonesian" => "Sukses",
                                                                                        "English" => "Success"
                                                                                    ],
                                                                                    'CustomerName' => $user->name,
                                                                                    'CurrencyCode' => "IDR",
                                                                                    'PaidAmount' => $paid,
                                                                                    'TotalAmount' => $total,
                                                                                    'TransactionDate' => $tanggal,
                                                                                    'DetailBills' => [],
                                                                                    'FreeTexts' => [],
                                                                                    'AdditionalData' => ''

                                                                                );

                                                                            } else {

                                                                                $respone = array(    
                                                                                    'CompanyCode' => $company,
                                                                                    'CustomerNumber' => $customer,
                                                                                    'RequestID' => $requestid,
                                                                                    'PaymentFlagStatus' => '01',
                                                                                    'PaymentFlagReason' => [
                                                                                        "Indonesian" => "Reference Kosong",
                                                                                        "English" => "Reference Empty"
                                                                                    ],
                                                                                    'CustomerName' => "",
                                                                                    'CurrencyCode' => "",
                                                                                    'PaidAmount' => "",
                                                                                    'TotalAmount' => "",
                                                                                    'TransactionDate' => "",
                                                                                    'DetailBills' => [],
                                                                                    'FreeTexts' => [],
                                                                                    'AdditionalData' => ''

                                                                                );

                                                                            }

                                                                        } else {

                                                                            $respone = array(    
                                                                                'CompanyCode' => $company,
                                                                                'CustomerNumber' => $customer,
                                                                                'RequestID' => $requestid,
                                                                                'PaymentFlagStatus' => '01',
                                                                                'PaymentFlagReason' => [
                                                                                    "Indonesian" => "SubCompany Kosong",
                                                                                    "English" => "SubCompany Empty"
                                                                                ],
                                                                                'CustomerName' => "",
                                                                                'CurrencyCode' => "",
                                                                                'PaidAmount' => "",
                                                                                'TotalAmount' => "",
                                                                                'TransactionDate' => "",
                                                                                'DetailBills' => [],
                                                                                'FreeTexts' => [],
                                                                                'AdditionalData' => ''

                                                                            );

                                                                        }

                                                                    } else {

                                                                        $respone = array(    
                                                                            'CompanyCode' => $company,
                                                                            'CustomerNumber' => $customer,
                                                                            'RequestID' => $requestid,
                                                                            'PaymentFlagStatus' => '01',
                                                                            'PaymentFlagReason' => [
                                                                                "Indonesian" => "FlagAdvice Tidak Sesuai",
                                                                                "English" => "Incorrect FlagAdvice"
                                                                            ],
                                                                            'CustomerName' => "",
                                                                            'CurrencyCode' => "",
                                                                            'PaidAmount' => "",
                                                                            'TotalAmount' => "",
                                                                            'TransactionDate' => "",
                                                                            'DetailBills' => [],
                                                                            'FreeTexts' => [],
                                                                            'AdditionalData' => ''

                                                                        );

                                                                    }

                                                                } else {

                                                                    $respone = array(    
                                                                        'CompanyCode' => $company,
                                                                        'CustomerNumber' => $customer,
                                                                        'RequestID' => $requestid,
                                                                        'PaymentFlagStatus' => '01',
                                                                        'PaymentFlagReason' => [
                                                                            "Indonesian" => "FlagAdvice Kosong",
                                                                            "English" => "FlagAdvice Empty"
                                                                        ],
                                                                        'CustomerName' => "",
                                                                        'CurrencyCode' => "",
                                                                        'PaidAmount' => "",
                                                                        'TotalAmount' => "",
                                                                        'TransactionDate' => "",
                                                                        'DetailBills' => [],
                                                                        'FreeTexts' => [],
                                                                        'AdditionalData' => ''

                                                                    );

                                                                }


                                                            } else {

                                                                $respone = array(    
                                                                    'CompanyCode' => $company,
                                                                    'CustomerNumber' => $customer,
                                                                    'RequestID' => $requestid,
                                                                    'PaymentFlagStatus' => '01',
                                                                    'PaymentFlagReason' => [
                                                                        "Indonesian" => "Format Tanggal Tidak Sesuai",
                                                                        "English" => "Incorrect Format Date"
                                                                    ],
                                                                    'CustomerName' => "",
                                                                    'CurrencyCode' => "",
                                                                    'PaidAmount' => "",
                                                                    'TotalAmount' => "",
                                                                    'TransactionDate' => "",
                                                                    'DetailBills' => [],
                                                                    'FreeTexts' => [],
                                                                    'AdditionalData' => ''

                                                                );
                                                            }

                                                        } else {

                                                            $respone = array(    
                                                                'CompanyCode' => $company,
                                                                'CustomerNumber' => $customer,
                                                                'RequestID' => $requestid,
                                                                'PaymentFlagStatus' => '01',
                                                                'PaymentFlagReason' => [
                                                                    "Indonesian" => "CurrencyCode Kosong",
                                                                    "English" => "CurrencyCode Empty"
                                                                ],
                                                                'CustomerName' => "",
                                                                'CurrencyCode' => "",
                                                                'PaidAmount' => "",
                                                                'TotalAmount' => "",
                                                                'TransactionDate' => "",
                                                                'DetailBills' => [],
                                                                'FreeTexts' => [],
                                                                'AdditionalData' => ''

                                                            );

                                                        }

                                                    } else {

                                                        $respone = array(    
                                                            'CompanyCode' => $company,
                                                            'CustomerNumber' => $customer,
                                                            'RequestID' => $requestid,
                                                            'PaymentFlagStatus' => '01',
                                                            'PaymentFlagReason' => [
                                                                "Indonesian" => "TotalAmount Kosong",
                                                                "English" => "TotalAmount Empty"
                                                            ],
                                                            'CustomerName' => "",
                                                            'CurrencyCode' => "",
                                                            'PaidAmount' => "",
                                                            'TotalAmount' => "",
                                                            'TransactionDate' => "",
                                                            'DetailBills' => [],
                                                            'FreeTexts' => [],
                                                            'AdditionalData' => ''

                                                        );

                                                    }

                                                } else {

                                                    $respone = array(    
                                                        'CompanyCode' => $company,
                                                        'CustomerNumber' => $customer,
                                                        'RequestID' => $requestid,
                                                        'PaymentFlagStatus' => '01',
                                                        'PaymentFlagReason' => [
                                                            "Indonesian" => "PaidAmount Kosong",
                                                            "English" => "PaidAmount Empty"
                                                        ],
                                                        'CustomerName' => "",
                                                        'CurrencyCode' => "",
                                                        'PaidAmount' => "",
                                                        'TotalAmount' => "",
                                                        'TransactionDate' => "",
                                                        'DetailBills' => [],
                                                        'FreeTexts' => [],
                                                        'AdditionalData' => ''

                                                    );

                                                }

                                            } else {

                                                $respone = array(    
                                                    'CompanyCode' => $company,
                                                    'CustomerNumber' => $customer,
                                                    'RequestID' => $requestid,
                                                    'PaymentFlagStatus' => '01',
                                                    'PaymentFlagReason' => [
                                                        "Indonesian" => "TransactionDate Kosong",
                                                        "English" => "TransactionDate Empty"
                                                    ],
                                                    'CustomerName' => "",
                                                    'CurrencyCode' => "",
                                                    'PaidAmount' => "",
                                                    'TotalAmount' => "",
                                                    'TransactionDate' => "",
                                                    'DetailBills' => [],
                                                    'FreeTexts' => [],
                                                    'AdditionalData' => ''

                                                );


                                            }

                                        } else {

                                            $respone = array(    
                                                'CompanyCode' => $company,
                                                'CustomerNumber' => $customer,
                                                'RequestID' => $requestid,
                                                'PaymentFlagStatus' => '01',
                                                'PaymentFlagReason' => [
                                                    "Indonesian" => "CustomerName Kosong",
                                                    "English" => "CustomerName Empty"
                                                ],
                                                'CustomerName' => "",
                                                'CurrencyCode' => "",
                                                'PaidAmount' => "",
                                                'TotalAmount' => "",
                                                'TransactionDate' => "",
                                                'DetailBills' => [],
                                                'FreeTexts' => [],
                                                'AdditionalData' => ''

                                            );

                                        }


                                    } else {

                                        $respone = array(    
                                            'CompanyCode' => $company,
                                            'CustomerNumber' => $customer,
                                            'RequestID' => $requestid,
                                            'PaymentFlagStatus' => '01',
                                            'PaymentFlagReason' => [
                                                "Indonesian" => "ChannelType Kosong",
                                                "English" => "ChannelType Empty"
                                            ],
                                            'CustomerName' => "",
                                            'CurrencyCode' => "",
                                            'PaidAmount' => "",
                                            'TotalAmount' => "",
                                            'TransactionDate' => "",
                                            'DetailBills' => [],
                                            'FreeTexts' => [],
                                            'AdditionalData' => ''

                                        );
                                    }


                                } else {

                                    $respone = array(    
                                        'CompanyCode' => $company,
                                        'CustomerNumber' => $customer,
                                        'RequestID' => "",
                                        'PaymentFlagStatus' => '01',
                                        'PaymentFlagReason' => [
                                            "Indonesian" => "RequestID Kosong",
                                            "English" => "RequestID Empty"
                                        ],
                                        'CustomerName' => "",
                                        'CurrencyCode' => "",
                                        'PaidAmount' => "",
                                        'TotalAmount' => "",
                                        'TransactionDate' => "",
                                        'DetailBills' => [],
                                        'FreeTexts' => [],
                                        'AdditionalData' => ''

                                    );

                                }


                            } else {

                                $respone = array(    
                                    'CompanyCode' => $company,
                                    'CustomerNumber' => $customer,
                                    'RequestID' => $requestid,
                                    'PaymentFlagStatus' => '01',
                                    'PaymentFlagReason' => [
                                        "Indonesian" => "CustomerNumber Tidak Ada",
                                        "English" => "CustomerNumber Not Found"
                                    ],
                                    'CustomerName' => "",
                                    'CurrencyCode' => "",
                                    'PaidAmount' => "",
                                    'TotalAmount' => "",
                                    'TransactionDate' => "",
                                    'DetailBills' => [],
                                    'FreeTexts' => [],
                                    'AdditionalData' => ''

                                );

                            }

                        } else {

                            $respone = array(    
                                'CompanyCode' => $company,
                                'CustomerNumber' => "",
                                'RequestID' => $requestid,
                                'PaymentFlagStatus' => '01',
                                'PaymentFlagReason' => [
                                    "Indonesian" => "CustomerNumber Kosong",
                                    "English" => "CustomerNumber Empty"
                                ],
                                'CustomerName' => "",
                                'CurrencyCode' => "",
                                'PaidAmount' => "",
                                'TotalAmount' => "",
                                'TransactionDate' => "",
                                'DetailBills' => [],
                                'FreeTexts' => [],
                                'AdditionalData' => ''

                            );

                        }

                    } else {

                        $respone = array(    
                            'CompanyCode' => "",
                            'CustomerNumber' => $customer,
                            'RequestID' => $requestid,
                            'PaymentFlagStatus' => '01',
                            'PaymentFlagReason' => [
                                "Indonesian" => "CompanyCode Kosong",
                                "English" => "CompanyCode Empty"
                            ],
                            'CustomerName' => "",
                            'CurrencyCode' => "",
                            'PaidAmount' => "",
                            'TotalAmount' => "",
                            'TransactionDate' => "",
                            'DetailBills' => [],
                            'FreeTexts' => [],
                            'AdditionalData' => ''

                        );

                    }


                } else {

                    $respone = array(    
                        'ErrorCode' => "...",
                        'ErrorMessage' => [
                            "Indonesian" => "HMAC tidak cocok",
                            "English" => "HMAC mismatch"
                        ],
                    );


                }

            } else {

                $respone = array(    
                    'ErrorCode' => "...",
                    'ErrorMessage' => [
                        "Indonesian" => "HMAC tidak cocok",
                        "English" => "HMAC mismatch"
                    ],
                );

            }

        } else {

            $respone = array(    
                'ErrorCode' => "...",
                'ErrorMessage' => [
                    "indonesian" => "HMAC tidak cocok",
                    "English" => "HMAC mismatch"
                ],
            );

        }

        return response()->json($respone);

    }
}
