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

class CompanyController extends Controller
{
    public function detailhome($id)
    {

        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d');

        $companyprofiles = Posts::select("posts.*","imgpost.name as imgname","wilayah.name as wilayah_name","regencies.name as regency_name","wilayah.id as wilayah_id")
        ->join("post_images", "posts.id", "=", "post_images.post_id")
        ->join("imgpost", "post_images.img_id", "=", "imgpost.id")
        ->join("users", "posts.user_id", "=", "users.id")
        ->join("wilayah", "users.wilayah_id", "=", "wilayah.id")
        ->join("regencies", "wilayah.regency_id", "=", "regencies.id")
        ->where([
            ['posts.type', '=', 'Deals'],
            ['wilayah.id', '=', $id],
            ['posts.sampai', '>=', $date],
            ['posts.active', '=', 'Y'],
        ])
        ->get();

        $companyproducts = Posts::select("posts.*","imgpost.name as imgname","wilayah.name as wilayah_name","regencies.name as regency_name","wilayah.id as wilayah_id")
        ->join("post_images", "posts.id", "=", "post_images.post_id")
        ->join("imgpost", "post_images.img_id", "=", "imgpost.id")
        ->join("users", "posts.user_id", "=", "users.id")
        ->join("wilayah", "users.wilayah_id", "=", "wilayah.id")
        ->join("regencies", "wilayah.regency_id", "=", "regencies.id")
        ->where([
            ['posts.type', '=', 'Products'],
            ['wilayah.id', '=', $id],
            ['posts.active', '=', 'Y'],
        ])
        ->get();

        $companychallanges = Posts::select("posts.*","imgpost.name as imgname","wilayah.name as wilayah_name","regencies.name as regency_name","wilayah.id as wilayah_id")
        ->join("post_images", "posts.id", "=", "post_images.post_id")
        ->join("imgpost", "post_images.img_id", "=", "imgpost.id")
        ->join("users", "posts.user_id", "=", "users.id")
        ->join("wilayah", "users.wilayah_id", "=", "wilayah.id")
        ->join("regencies", "wilayah.regency_id", "=", "regencies.id")
        ->where([
            ['posts.type', '=', 'Challange'],
            ['wilayah.id', '=', $id],
            ['posts.sampai', '>=', $date],
            ['posts.active', '=', 'Y'],
        ])
        ->get();

        $wilayah_id = $id;

        $companies = Company::select("wilayah.alamat","wilayah.name","company.photo","regencies.name as regency_name")
        ->join("wilayah", "company.id", "=", "wilayah.company_id")
        ->join("regencies", "wilayah.regency_id", "=", "regencies.id")
        ->where("wilayah.id", $id)
        ->first();

        $countfollow = Follow::where("wilayah_id", $id)
        ->count();

        $countdeals = Posts::join("users", "posts.user_id", "=", "users.id")
        ->join("wilayah", "users.wilayah_id", "=", "wilayah.id")
        ->where([
            ['type', '=', 'Deals'],
            ['wilayah.id', '=', $id],
            ['posts.sampai', '>=', $date],
            ['posts.active', '=', 'Y'],
        ])
        ->count();

        $countprod = Posts::join("users", "posts.user_id", "=", "users.id")
        ->join("wilayah", "users.wilayah_id", "=", "wilayah.id")
        ->where([
            ['type', '=', 'Products'],
            ['wilayah.id', '=', $id],
            ['posts.active', '=', 'Y'],
        ])
        ->count();

        $countchallanges = Posts::join("users", "posts.user_id", "=", "users.id")
        ->join("wilayah", "users.wilayah_id", "=", "wilayah.id")
        ->where([
            ['type', '=', 'Challange'],
            ['wilayah.id', '=', $id],
            ['posts.sampai', '>=', $date],
            ['posts.active', '=', 'Y'],
        ])
        ->count();

        return view('content.company_profiles.home', compact('companyprofiles','companyproducts','companies','countfollow','countdeals','countprod','countchallanges','wilayah_id','companychallanges'));

    }

    public function detail(Request $request)
    {
    	date_default_timezone_set('Asia/Jakarta');
		$date = date('Y-m-d');

        $cekada = Temporary::where('session_id', csrf_token())
        ->first();

        if($cekada){
            $deletetemporary = Temporary::where("session_id", csrf_token());
            $deletetemporary->delete();
        }

    	$companyprofiles = Posts::select("posts.*","imgpost.name as imgname","wilayah.name as wilayah_name","regencies.name as regency_name","wilayah.id as wilayah_id","wilayah.uuid")
		->join("post_images", "posts.id", "=", "post_images.post_id")
		->join("imgpost", "post_images.img_id", "=", "imgpost.id")
        ->join("users", "posts.user_id", "=", "users.id")
        ->join("wilayah", "users.wilayah_id", "=", "wilayah.id")
        ->join("regencies", "wilayah.regency_id", "=", "regencies.id")
        ->where([
            ['posts.type', '=', 'Deals'],
            ['wilayah.uuid', '=', $request->id],
            ['posts.sampai', '>=', $date],
            ['posts.active', '=', 'Y'],
        ])
		->get();

		$companyproducts = Posts::select("posts.*","imgpost.name as imgname","wilayah.name as wilayah_name","regencies.name as regency_name","wilayah.id as wilayah_id","wilayah.uuid")
		->join("post_images", "posts.id", "=", "post_images.post_id")
		->join("imgpost", "post_images.img_id", "=", "imgpost.id")
        ->join("users", "posts.user_id", "=", "users.id")
        ->join("wilayah", "users.wilayah_id", "=", "wilayah.id")
        ->join("regencies", "wilayah.regency_id", "=", "regencies.id")
        ->where([
            ['posts.type', '=', 'Products'],
            ['wilayah.uuid', '=', $request->id],
            ['kategori_id', '=', '2'],
            ['posts.active', '=', 'Y'],
        ])
		->get();

		$companychallanges = Posts::select("posts.*","imgpost.name as imgname","wilayah.name as wilayah_name","regencies.name as regency_name","wilayah.id as wilayah_id","wilayah.uuid")
		->join("post_images", "posts.id", "=", "post_images.post_id")
		->join("imgpost", "post_images.img_id", "=", "imgpost.id")
        ->join("users", "posts.user_id", "=", "users.id")
        ->join("wilayah", "users.wilayah_id", "=", "wilayah.id")
        ->join("regencies", "wilayah.regency_id", "=", "regencies.id")
        ->where([
            ['posts.type', '=', 'Challange'],
            ['wilayah.uuid', '=', $request->id],
            ['posts.sampai', '>=', $date],
            ['posts.active', '=', 'Y'],
        ])
		->get();

		$user = Auth::user();

		$iduser = $user->id;

        $wilayah = Wilayah::where('uuid',$request->id)
        ->first();

		$wilayah_id = $wilayah->id;

		$companies = Company::select("wilayah.alamat","wilayah.name","company.photo","regencies.name as regency_name")
		->join("wilayah", "company.id", "=", "wilayah.company_id")
		->join("regencies", "wilayah.regency_id", "=", "regencies.id")
		->where("wilayah.uuid", $request->id)
		->first();

		$countfollow = Follow::join("wilayah", "follow.wilayah_id", "=", "wilayah.id")
        ->where("wilayah.uuid", $request->id)
		->count();

		$countdeals = Posts::join("users", "posts.user_id", "=", "users.id")
        ->join("wilayah", "users.wilayah_id", "=", "wilayah.id")
		->where([
            ['type', '=', 'Deals'],
            ['wilayah.uuid', '=', $request->id],
            ['posts.sampai', '>=', $date],
            ['posts.active', '=', 'Y'],
        ])
		->count();

		$countprod = Posts::join("users", "posts.user_id", "=", "users.id")
        ->join("wilayah", "users.wilayah_id", "=", "wilayah.id")
		->where([
            ['type', '=', 'Products'],
            ['wilayah.uuid', '=', $request->id],
            ['posts.active', '=', 'Y'],
        ])
		->count();

		$countchallanges = Posts::join("users", "posts.user_id", "=", "users.id")
        ->join("wilayah", "users.wilayah_id", "=", "wilayah.id")
        ->where([
            ['type', '=', 'Challange'],
            ['wilayah.uuid', '=', $request->id],
            ['posts.sampai', '>=', $date],
            ['posts.active', '=', 'Y'],
        ])
		->count();

        $usersupdate = Users::where(['id'=>$user->id])
        ->update(['wilayah_id'=>$wilayah_id]);

		return view('content.company_profiles.profile', compact('companyprofiles','companyproducts','companies','iduser','countfollow','countdeals','countprod','countchallanges','wilayah_id','companychallanges'));

    }

    public function kategori(Request $request)
    {

        $user = Auth::user();

        $produk = Posts::select("posts.*","product.img as imgname","wilayah.name as wilayah_name","regencies.name as regency_name","wilayah.id as wilayah_id","wilayah.uuid","kategori.name as kategori_name","product.name as prod_name")
        ->join("users", "posts.user_id", "=", "users.id")
        ->join("wilayah", "users.wilayah_id", "=", "wilayah.id")
        ->join("regencies", "wilayah.regency_id", "=", "regencies.id")
        ->join("kategori", "posts.kategori_id", "=", "kategori.id")
        ->join("product", "posts.product_id", "=", "product.id")
        ->where([
            ['posts.type', '=', 'Products'],
            ['wilayah.id', '=', $user->wilayah_id],
            ['kategori_id', '=', $request->id],
            ['posts.active', '=', 'Y'],
        ])
        ->get();

        return response()->json($produk);

    }

    public function cari(Request $request)
    {

        $produk = Posts::select("posts.*","imgpost.name as imgname","wilayah.name as wilayah_name","regencies.name as regency_name","wilayah.id as wilayah_id","wilayah.uuid")
        ->join("post_images", "posts.id", "=", "post_images.post_id")
        ->join("imgpost", "post_images.img_id", "=", "imgpost.id")
        ->join("users", "posts.user_id", "=", "users.id")
        ->join("wilayah", "users.wilayah_id", "=", "wilayah.id")
        ->join("regencies", "wilayah.regency_id", "=", "regencies.id")
        ->where([
            ['posts.type', '=', 'Products'],
            ['wilayah.id', '=', $request->outletid],
            ['posts.name', 'like', '%'.$request->produk.'%'],
            ['posts.active', '=', 'Y'],
        ])
        ->get();

        return response()->json($produk);


    }
}
