<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Favorite;
use App\Users;
use App\Services;
use Auth;

class FavoriteController extends Controller
{
    public function index()
    {
    	date_default_timezone_set('Asia/Jakarta');
		$date = date('Y-m-d');

		$user = Auth::user();

        $iduser = $user->id;

		$favs = Favorite::select("posts.*","product.name as prod_name","wilayah.name as wilayah_name","regencies.name as regency_name","product.img as prod_img","wilayah.uuid")
		->leftJoin("posts", "favorite.post_id", "=", "posts.id")
        ->leftJoin("users", "posts.user_id", "=", "users.id")
        ->leftJoin("wilayah", "users.wilayah_id", "=", "wilayah.id")
        ->leftJoin("regencies", "wilayah.regency_id", "=", "regencies.id")
        ->leftJoin("product", "posts.product_id", "=", "product.id")
        ->where([
            ['favorite.user_id', '=', $user->id],
            ['posts.active', '=', 'Y'],
            ['posts.type', '=', 'Products'],
        ])
		->get();

		$ada = Favorite::where("user_id", $user->id)
		->count();

        if($user->pemegangsaham == 'yes'){

            $pemegangsaham = Services::where('type', 'pemegangsaham')
            ->first();

            $diskon = $pemegangsaham->biaya;

        } else {

            $diskon = 0;

        }

        $service = Services::first();

		return view('content.favorite.index', compact('date','favs','ada','iduser','service','diskon'));

    }

    public function masuk(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');

        $user = Auth::user();

    	$fav = new Favorite();
        $fav->user_id = $user->id;
        $fav->post_id = $request->post_id;
        $fav->save();
        
        return response()->json($fav);
    }

    public function keluar(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');

        $user = Auth::user();

    	$keluarkan = Favorite::where([
            ['user_id', '=', $user->id],
            ['post_id', '=', $request->post_id],
        ])
        ->delete();
        
        return response()->json($keluarkan);
    }

}
