<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Diskusi;
use App\Komentar;
use Auth;

class KomentarController extends Controller
{
    public function index()
    {
    	date_default_timezone_set('Asia/Jakarta');
		$date = date('Y-m-d');

		$user = Auth::user();

        $userid = $user->id;

		$disscuss = Diskusi::select("diskusi.*","imgpost.name as img","posts.name as post_name","posts.type as post_type", "diskusi.read","posts.id as post_id")
		->leftJoin("posts", "diskusi.post_id", "=", "posts.id")
        ->leftJoin("post_images", "posts.id", "=", "post_images.post_id")
        ->leftJoin("imgpost", "post_images.img_id", "=", "imgpost.id")
        ->leftJoin("user_companies", "posts.company_id", "=", "user_companies.company_id")
        ->leftJoin("users", "user_companies.user_id", "=", "users.id")
		->where([
            ['users.id', '=', $user->id],
            ['role_id', '=', '2'],
        ])
        ->orderBy("diskusi.read", "asc")
        ->limit(10)
		->get();

		return view('content.home.principle.komentar.index', compact('date','disscuss','userid'));

    }


    public function detail($id)
    {

        $diskusi = Diskusi::select("diskusi.*","users.name as user_name","posts.name as post_name", "imgpost.name as img","posts.type as post_type")
        ->leftJoin("users", "diskusi.user_id", "=", "users.id")
        ->leftJoin("posts", "diskusi.post_id", "=", "posts.id")
        ->leftJoin("post_images", "posts.id", "=", "post_images.post_id")
        ->leftJoin("imgpost", "post_images.img_id", "=", "imgpost.id")
        ->where("diskusi.id", $id)
        ->first();

        return view('content.home.principle.komentar.detail', compact('diskusi'));

    }

    public function bacadiskusi(Request $request)
    {
        $reads = Diskusi::where(['id'=>$request->id])
        ->update(['read'=> '1']);

        $ada = Komentar::where("diskusi_id",$request->id)
        ->get();

        if($ada){

            $komens = Komentar::where(['diskusi_id'=>$request->id])
            ->update(['read'=>'1']);
        }
        
        return response()->json($reads);

    }

    public function komentar()
    {

        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d');

        $user = Auth::user();

        $userid = $user->id;

        $komentars = Komentar::select("komentar.diskusi_id","posts.name as post_name","imgpost.name as img","posts.type as post_type")
        ->leftJoin("diskusi", "komentar.diskusi_id", "=", "diskusi.id")
        ->leftJoin("posts", "diskusi.post_id", "=", "posts.id")
        ->leftJoin("post_images", "posts.id", "=", "post_images.post_id")
        ->leftJoin("imgpost", "post_images.img_id", "=", "imgpost.id")
        ->where("diskusi.user_id", $userid)
        ->groupBy("komentar.diskusi_id","post_name","img","post_type")
        ->get();

        return view('content.home.users.komentar.index', compact('komentars','userid'));
    }

    public function bacadiskusiusers(Request $request)
    {
        
        $komens = Komentar::where(['diskusi_id'=>$request->id])
        ->update(['read'=>'1']);
        
        return response()->json($komens);

    }

    public function detailusers($id)
    {

        $diskusi = Diskusi::select("diskusi.*","users.name as user_name","posts.name as post_name", "imgpost.name as img","posts.type as post_type")
        ->leftJoin("users", "diskusi.user_id", "=", "users.id")
        ->leftJoin("posts", "diskusi.post_id", "=", "posts.id")
        ->leftJoin("post_images", "posts.id", "=", "post_images.post_id")
        ->leftJoin("imgpost", "post_images.img_id", "=", "imgpost.id")
        ->where("diskusi.id", $id)
        ->first();

        return view('content.home.users.komentar.detail', compact('diskusi'));

    }

}
