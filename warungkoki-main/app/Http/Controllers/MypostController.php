<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\UserCompany;
use App\Posts;
use App\Kategori;
use App\ImagesPost;
use App\PostImages;
use Auth;
use DataTables;
use Validator;
use Image;

class MypostController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $getpostdeals = Posts::select("posts.*","imgpost.name as img_name")
        ->leftJoin("users", "posts.user_id", "=", "users.id")
        ->leftJoin("post_images", "posts.id", "=", "post_images.post_id")
        ->leftJoin("imgpost", "post_images.img_id", "=", "imgpost.id")
        ->where([
            ['type', '=', 'Deals'],
            ['users.wilayah_id', '=', $user->wilayah_id],
        ])
        ->get();

        $getpostchallanges = Posts::select("posts.*","imgpost.name as img_name")
        ->leftJoin("users", "posts.user_id", "=", "users.id")
        ->leftJoin("post_images", "posts.id", "=", "post_images.post_id")
        ->leftJoin("imgpost", "post_images.img_id", "=", "imgpost.id")

        ->where([
            ['type', '=', 'Challange'],
            ['users.wilayah_id', '=', $user->wilayah_id],
        ])
        ->get();

        $getpostproducts = Posts::select("posts.*","imgpost.name as img_name")
        ->leftJoin("users", "posts.user_id", "=", "users.id")
        ->leftJoin("post_images", "posts.id", "=", "post_images.post_id")
        ->leftJoin("imgpost", "post_images.img_id", "=", "imgpost.id")
        ->where([
            ['type', '=', 'Products'],
            ['users.wilayah_id', '=', $user->wilayah_id],
        ])
        ->orderBy("posts.id", "desc")
        ->get();

        return view('content.mypost.index', compact('getpostdeals','getpostchallanges','getpostproducts','user'));

    }

    public function getdatadeals()
    {

    	$user = Auth::user();

        $getposts = Posts::where([
            ['company_id', '=', $user->company_id],
            ['type', '=', 'Deals'],
        ])
        ->get();

        return Datatables::of($getposts)->make(true);
    }

    public function getdatachallanges()
    {

    	$user = Auth::user();

        $getpost = Posts::where([
            ['company_id', '=', $user->company_id],
            ['type', '=', 'Challange'],
        ])
        ->get();

        return Datatables::of($getpost)->make(true);
    }

    public function hapuspost(Request $request)
    {
        $user = Auth::user();

        $postdelete = Posts::where("id", $request->id)
        ->delete();

        return response()->json($postdelete);

    }

    public function edit(Request $request)
    {
        $user = Auth::user();

        $kategoris = Kategori::all();

        $detailposts = Posts::select("posts.*","imgpost.name as img_name")
        ->leftJoin("users", "posts.user_id", "=", "users.id")
        ->leftJoin("post_images", "posts.id", "=", "post_images.post_id")
        ->leftJoin("imgpost", "post_images.img_id", "=", "imgpost.id")
        ->where("posts.id", $request->id)
        ->first();

        return view('content.mypost.edit', compact('detailposts','kategoris'));

    }

    public function gantigambar(Request $request)
    {   
        date_default_timezone_set('Asia/Jakarta');

        $validation = Validator::make($request->all(), [
            'file' => 'mimes:jpeg,bmp,png,svg,pdf',
        ]);

        if($validation->passes()) {

            $image = $request->file('file');
            $input['imagename'] = rand() . '.' . $image->getClientOriginalExtension();

            $destinationPath = public_path('assets/img_post');

            $img = Image::make($image->getRealPath());
            $img->resize(400, 400, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath.'/'.$input['imagename']);

            $user = Auth::user();

            $imgs = new ImagesPost();
            $imgs->company_id = $user->company_id;
            $imgs->name = $input['imagename'];
            $imgs->save();

            $updates = PostImages::where(['post_id'=>$request->id])
            ->update(['img_id'=>$imgs->id]);

            return response()->json([
                'message'  => 'Upload Anda Tersimpan',
                'icon' => 'success',
                'name' => $input['imagename'],
                'status' => '1',
            ]);

        } else {

            return response()->json([
                'message' => $validation->errors()->all(),
                'icon' => 'error',
                'status' => '0',
            ]);
        }

    }

    public function update(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');

        if($request->type == 'Deals'){

            $updatedeal  = Posts::findOrFail($request->id);
            $updatedeal->name = $request->judul;
            $updatedeal->dari = $request->dari;
            $updatedeal->sampai = $request->sampai;
            $updatedeal->kategori_id = $request->kategori_id;
            $updatedeal->banyaknya = $request->banyaknya;
            $updatedeal->desc = $request->desc;
            $updatedeal->harga_act = $request->harga_act;
            $updatedeal->harga_crt = $request->harga_crt;
            $updatedeal->active = $request->active;
            $updatedeal->save();

        } else if($request->type == 'Products'){

            $updatedeal  = Posts::findOrFail($request->id);
            $updatedeal->name = $request->judul;
            $updatedeal->kategori_id = $request->kategori_id;
            $updatedeal->banyaknya = $request->stock;
            $updatedeal->deliver = $request->deliver;
            $updatedeal->po = $request->po;
            $updatedeal->desc = $request->desc;
            $updatedeal->harga_act = $request->harga_act;
            $updatedeal->active = $request->active;
            $updatedeal->save();

        } else {

            $updatedeal  = Posts::findOrFail($request->id);
            $updatedeal->name = $request->judul;
            $updatedeal->dari = $request->dari;
            $updatedeal->sampai = $request->sampai;
            $updatedeal->kategori_id = $request->kategori_id;
            $updatedeal->banyaknya = $request->banyaknya;
            $updatedeal->desc = $request->desc;
            $updatedeal->dari_reward = $request->dari_reward;
            $updatedeal->sampai_reward = $request->sampai_reward;
            $updatedeal->active = $request->active;
            $updatedeal->save();

        }

        return response()->json($updatedeal);

    }

}
