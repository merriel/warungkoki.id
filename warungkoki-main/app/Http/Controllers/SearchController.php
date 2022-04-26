<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Posts;
use App\UserDaerah;
use App\Product;
use App\Wilayah;
use App\Users;
use Auth;
use DataTables;
use GuzzleHttp\Client;

class SearchController extends Controller
{
    public function caritoko(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d');

        $user = Auth::user();

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

        $datatoko = Wilayah::select("wilayah.*","company.photo","regencies.name as regency_name")
        ->join("company", "wilayah.company_id", "=", "company.id")
        ->join("regencies", "wilayah.regency_id", "=", "regencies.id")
        // ->whereIn("regency_id", $arraywilayah)
        ->where([
            ['wilayah.name', 'like', '%'.$request->id.'%'],
            ['wilayah.active', '=', 'Y'],
        ])
        ->get();

        return response()->json($datatoko);
    }

    public function cariproduk(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d');

        $user = Auth::user();

        // $daerah2 = UserDaerah::select("regencies.*")
        // ->join("regencies", "users_daerah.regency_id", "=", "regencies.id")
        // ->where("user_id", $user->id)
        // ->get();

        // $wilayah = '';

        // foreach($daerah2 as $d){

        //     $wilayah .= $d->id.',';
        // }

        // $potong = substr($wilayah,0,-1);
        // $arraywilayah = explode(",",$potong);

        // $dataproduk = Posts::select("posts.id")
        // ->select("posts.*","imgpost.name as imgname","regencies.name as regency_name", "wilayah.name as wilayah_name","wilayah.id as wilayah_id")
        // ->leftJoin("post_images", "posts.id", "=", "post_images.post_id")
        // ->leftJoin("imgpost", "post_images.img_id", "=", "imgpost.id")
        // ->leftJoin("users", "posts.user_id", "=", "users.id")
        // ->leftJoin("wilayah", "users.wilayah_id", "=", "wilayah.id")
        // ->leftJoin("regencies", "wilayah.regency_id", "=", "regencies.id")
        // // ->whereIn("wilayah.regency_id", $arraywilayah)
        // ->where([
        //     ['posts.name', 'like', '%'.$request->id.'%'],
        //     ['wilayah.active', '=', 'Y'],
        //     ['posts.active', '=', 'Y'],
        //     ['posts.type', '=', 'Products'],
        // ])
        // ->orderBy('posts.id', 'desc')
        // ->get();

        $products = Posts::select("posts.product_id")
          ->leftJoin("users", "posts.user_id", "=", "users.id")
          ->leftJoin("wilayah", "users.wilayah_id", "=", "wilayah.id")
          ->leftJoin("regencies", "wilayah.regency_id", "=", "regencies.id")
          ->leftJoin("product", "posts.product_id", "=", "product.id")
          ->where([
              ["wilayah.id", $user->wilayah_id],
              ["posts.active", "Y"],
              ['wilayah.active', '=', "Y"],
              ['posts.type', '=', 'Products'],
              ['posts.deleted_at', '=', null],
              ['product.name', 'like', '%'.$request->value.'%'],
          ])
          ->orderBy('posts.id', 'desc')
          ->groupBy("posts.product_id")
          ->get();

          $val = $request->value;

          $wilayahid = $user->wilayah_id;

          $iduser = $user->id;

        return view('content.search.index', compact('products','val','wilayahid','iduser'));
    }

    public function pilihtoko(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d');

        $wilayah = Wilayah::select("wilayah.*","company.photo","regencies.name as regency_name")
        ->join("company", "wilayah.company_id", "=", "company.id")
        ->join("regencies", "wilayah.regency_id", "=", "regencies.id")
        ->where("wilayah.id", $request->id)
        ->first();

        return response()->json($wilayah);

    }

    public function pilihtokostore(Request $request)
    {

        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d');

        $usernyah = Auth::user();

        if(!$usernyah){

            $data = 0;

            
        } else {

            $user = Auth::user();

            $updates = Users::findOrFail($user->id);
            $updates->retailer_id = null;
            $updates->wilayah_id = $request->id;
            $updates->save();

            $data = 1;
        }

        $arrayNames = array(    
            'wilayah' => $request->id,
            'status' => $data,
        );

        return response()->json($arrayNames);

    }

    public function notif(Request $request)
    {
        $url = 'https://fcm.googleapis.com/fcm/send';
        $client = new \GuzzleHttp\Client;
        $result = $client->post( $url, [
          'json'    => [
                'to' => 'dOiIxEWBGcBkJrHgCScUBw:APA91bHnq2DqBxdkfLIjD8KZOz4iFlPyHLbQ1futtAKiNH27G3YwhG5Eje1rfdMUjCvaatAdUzH771DNH5durYvtF7eLSLxNTmgwBfVoJkiW--pjHqQSA9Ta01gV3BEHEYnToA5tg0XJ',
                'notification' => [
                    "body" => "INI NOTIFIKASI CUMA TESTING AJA YAA!",
                    "title" => "Tomxperience.id Notification",
                    "icon" => "https://tomxperience.id/assets/icon/96x96.png",
                    "click_action" => "https://tomxperience.id"
                ]
          ],
          'headers' => [
             'Authorization' => 'key=AAAAvOfjMXs:APA91bHOcotCNaioU_hLul4_6CbHv8NW4Vfoi_vm97rJB3dv0Ff3IcmkOb1h5hpvmEJtiGydFCMBXBeguCi2H3DftknYx-iLAIOMQCVXVqXxK9PO83f6y3yEywYmpqBkLHlU3qQppOM6',
             'Content-Type'  => 'application/json',
          ],
        ]);

    }

}
