<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Posts;
use App\Company;
use App\Temporary;
use App\Follow;
use App\Wilayah;
use App\Users;
use Auth;
use GuzzleHttp\Client;


class BCAController extends Controller
{
    private static $hostUrl = 'http://localhost';
    // $hostUrl = 'https://api.klikbca.com:8065';
    private static $clientID = 'ec0f18eb-3a44-4420-b562-71a0b42abd83';
    private static $clientSecret = '076b4031-4b67-40e7-ab10-4ab359c71db3';
    private static $APIKey = '4393bc74-0f90-4f32-8ae7-e3b9c709f1ec';
    private static $APISecret = '205f97ae-c0c1-4f1d-905d-b57fdd8f93eb';
    private static $accessToken = null;
    private static $timeStamp = null;
    private static $client;

    // public function __construct(){
    //     self::$timeStamp = date('o-m-d') . 'T' . date('H:i:s') . '.' . substr(date('u'), 0, 3) . date('P');
    //     self::$client = new \GuzzleHttp\Client;
    //     $this->initialToken();
    // }

    public function initialToken(){ 

        $output = self::$client->request('POST', self::$hostUrl . '/api/oauth/token', [
            'verify' => false,
            'headers' => [
                 'Content-Type'  => 'application/x-www-form-urlencoded',
                 'Authorization' => 'Basic '.base64_encode(self::$clientID.':'.self::$clientSecret)
            ],
            'form_params' => [
                'grant_type' => 'client_credentials'
            ]
        ]);
        $output = json_decode($output->getBody(), true);
        return self::$accessToken = $output['access_token'];
    }

    private function getSignature($HTTPMethod, $relativeUrl, $RequestBody = ''){
        $RequestBody = strtolower(hash('sha256', $RequestBody));
        $StringToSign = $HTTPMethod . ":" . $relativeUrl . ":" . self::$accessToken . ":" . $RequestBody . ":" . self::$timeStamp;
        $signature = hash_hmac('sha256', $StringToSign, self::$APISecret);
        return $signature;
    }

    public function getStatements($payload = array()){

        $path = '/va/payments?CompanyCode=80888&CustomerNumber=8161964775';
        $method = 'GET';

        $output = self::$client->request($method, self::$hostUrl . $path, [
            'verify' => false,
            'headers' => [
                 'Authorization' => 'Bearer ' . self::$accessToken,
                 'Content-Type' => 'application/json',
                 'Origin' => 'tomxperience.id',
                 'X-BCA-Key' => self::$APIKey,
                 'X-BCA-Timestamp' => self::$timeStamp,
                 'X-BCA-Signature' => $this->getSignature($method, $path),
            ]
        ]);
        // echo '<pre>';
        // print_r(json_decode($output->getBody(), true));
        // echo '</pre>';
        // echo $output->getBody(); // response
        // exit;
        $arrayNames = array(    
            'Authorization' => 'Bearer ' . self::$accessToken,
             'Content-Type' => 'application/json',
             'Origin' => 'tomxperience.id',
             'X-BCA-Key' => self::$APIKey,
             'X-BCA-Timestamp' => self::$timeStamp,
             'X-BCA-Signature' => $this->getSignature($method, $path),
        );

        echo response()->json($arrayNames);
        echo $output->getBody();
        exit;
    }

    public function redirect(){

        $queries = http_build_query([
            'client_id' => '1',
            'redirect_uri' => 'http://localhost://oauth/callback',
            'response_type' => 'code',
        ]);

        return redirect('http://localhost/auth/autorize?' . $queries);
    }

    public function callback(Request $request){

        $response = self::$client->request('POST', 'http://localhost/oauth/token', [
            'verify' => false,
            'client_id' => '1',
            'client_secret' => 'DNO0PN9gtjGmslLkAS9mS56xQomckZLYrBgBpR1t',
            'access_token' => $request->code,
        ]);

        dd($response->json());

    }

    
}
