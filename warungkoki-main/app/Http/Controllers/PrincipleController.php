<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ImagesPost;
use App\UserCompany;
use App\Product;
use App\Wilayah;
use App\Posts;
use App\PostAreas;
use App\PostDetails;
use App\PostRewards;
use App\PostImages;
use App\Users;
use App\Diskusi;
use App\Komentar;
use App\Kategori;
use App\Transaksi;
use App\TransaksiDetails;
use Auth;
use Validator;
use Hash;
use Image;
use DB;


class PrincipleController extends Controller
{
    public function index()
    {
    	date_default_timezone_set('Asia/Jakarta');
    	$date = date('Y-m-d');

    	$user = Auth::user();

        $reedemhariini = Transaksi::join("users", "transactions.petugas_id", "=", "users.id")
        ->where([
            ['type', '=', 'out'],
            ['status', '=', 'APPROVED'],
            ['users.wilayah_id', '=', $user->wilayah_id],
        ])
        ->whereDate('transactions.created_at', $date)
        ->count();

        $prodreedems = TransaksiDetails::select("transaction_details.qty","transactions.updated_at","product.name as prod_name","posts.name as post_name","transactions.uuid")
        ->join("transactions", "transaction_details.transaction_id", "=", "transactions.id")
        ->join("users", "transactions.petugas_id", "=", "users.id")
        ->join("posts", "transaction_details.post_id", "=", "posts.id")
        ->join("product", "posts.product_id", "=", "product.id")
        ->where([
            ['transactions.type', '=', 'out'],
            ['transactions.status', '=', 'APPROVED'],
            ['users.wilayah_id', '=', $user->wilayah_id],
        ])
        ->whereDate('transactions.created_at', $date)
        ->count();

    	$prods = Product::where('company_id', $user->company_id)
    	->get();

        $prod2s = Posts::select("product.*")
        ->leftJoin("post_details", "posts.id", "=", "post_details.post_id")
        ->leftJoin("product", "post_details.product_id", "=", "product.id")
        ->where([
            ['product.company_id', '=', $user->company_id],
            ['posts.type', '=', 'Products'],
        ])
        ->get();

        $kategoris = Kategori::all();

    	$areas = Wilayah::where('company_id', $user->company_id)
    	->get();

        $transaksihariini = Transaksi::join("orders", "transactions.id", "=", "orders.transaction_id")
        ->where([
            ['transactions.type', '=', 'in'],
            ['transactions.status', '=', 'APPROVED'],
        ])
        ->whereDate('transactions.created_at', $date)
        ->count();

        $transaksirupiah = DB::table('transactions')
        ->join("orders", "transactions.id", "=", "orders.transaction_id")
        ->where([
            ['transactions.type', '=', 'in'],
            ['transactions.status', '=', 'APPROVED'],
        ])
        ->whereDate('transactions.created_at', $date)
        ->sum('orders.amount');

    	return view('content.home.principle.index', compact('date','prods','areas','kategoris','transaksihariini','transaksirupiah','prod2s','reedemhariini','prodreedems'));

    }

    public function upload(Request $request)
    {	
    	date_default_timezone_set('Asia/Jakarta');
    	$hari = date('Y-m-d');
    	$time = date("H:i:s");

    	$user = Auth::user();

        $validation = Validator::make($request->all(), [
        'file' => 'required|image|mimes:jpeg,png,jpg,gif'
        ]);

        if($validation->passes()) {

            $image = $request->file('file');
            $input['imagename'] = rand() . '.' . $image->getClientOriginalExtension();

            $destinationPath = public_path('assets/img_post');

            $img = Image::make($image->getRealPath());
            $img->resize(430, 430, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath.'/'.$input['imagename']);

            $imgs = new ImagesPost();
            $imgs->company_id = $user->company_id;
            $imgs->name = $input['imagename'];
            $imgs->save();

            // $image->move(public_path('/assets/img_post'), $new_name);

            return response()->json([
                'message'   => 'success',
                'img'   => $input['imagename'],
                'id'	=> $imgs->id,
            ]);

        } else {

            return response()->json([                                                                                                                    
            'message'   => $validation->errors()->all(),
            ]);
        }

    }

    public function cancel(Request $request)
    {

    	$cancelimg = ImagesPost::findOrFail($request->id);
        $cancelimg->delete();

        unlink(public_path($request->imgs));

        return response()->json($cancelimg);

    }

    public function store(Request $request) {

    	date_default_timezone_set('Asia/Jakarta');

    	$user = Auth::user();

        $names = Posts::where("name", $request->name)
        ->first();     

        $getprods = Product::where('id', $request->product_id)
        ->first();

		$post = new Posts();
        $post->user_id = $user->id;
        $post->type = $request->type;
        $post->desc = $request->desc;
        $post->banyaknya = $request->banyaknya;
        $post->active = 'Y';

        if($request->type == 'Products'){

            $post->name = $getprods->name;
            $post->kategori_id = $request->kategori;
            $post->harga_act = $request->harga_act;
            $post->deliver = $request->deliver;
            $post->po = $request->po;

        } else if($request->type == 'Deals'){

            $post->dari = $request->dari;
            $post->sampai = $request->sampai;
            $post->harga_crt = $request->harga_crt;
            $post->name = $request->name;
            $post->kategori_id = $request->kategori;
            $post->harga_act = $request->harga_act;

        } else {

            $post->dari = $request->dari;
            $post->sampai = $request->sampai;
            $post->name = $request->name;
            $post->dari_reward = $request->dari_reward;
            $post->sampai_reward = $request->sampai_reward;
            $post->jenis_challange = $request->jenis;

            if($request->jenis == 'global'){
               $post->value_challange = $request->value; 
            }

        }
        
        $post->save();

        $imgpost = new PostImages();
        $imgpost->post_id = $post->id;
        $imgpost->img_id = $request->img_id;
        $imgpost->save();

        if($request->type != 'Products'){

            if($request->type == 'Challange' && $request->jenis == 'global'){

                $countprod = count($request->prod_id);

                for($i=0; $i < $countprod; $i++){

                    $postdet = new PostDetails();
                    $postdet->post_id = $post->id;
                    $postdet->product_id = $request->prod_id[$i];
                    $postdet->save();

                }

            } else {

                $countprod = count($request->product);

                for($i=0; $i < $countprod; $i++){

                    $postdet = new PostDetails();
                    $postdet->post_id = $post->id;
                    $postdet->product_id = $request->product[$i];
                    $postdet->qty = $request->prodqty[$i];
                    $postdet->save();

                }

            }

            

        } else {

            $postdet = new PostDetails();
            $postdet->post_id = $post->id;
            $postdet->product_id = $request->product_id;
            $postdet->qty = '1';
            $postdet->save();

        }

        if($request->type == 'Challange'){

	        $countward = count($request->reward);

	        for($i=0; $i < $countward; $i++){

	        	$postward = new PostRewards();
	            $postward->post_id = $post->id;
	            $postward->product_id = $request->reward[$i];
	            $postward->qty = $request->qtyreward[$i];
	            $postward->save();

	        }
	    }

	    return response()->json($names);
    }

    public function createpetugas()
    {
        $user = Auth::user();

        $getcompany = Users::where('id', $user->id)
        ->first();

        $areas = Wilayah::where('company_id', $getcompany->company_id)
        ->get();

        $petugass = Users::select('users.*','wilayah.name as wilayah_name', 'wilayah.id as wilayah_id')
        ->leftJoin("wilayah", "users.wilayah_id", "=", "wilayah.id")
        ->where([
            ['users.role_id', '=', '3'],
            ['users.company_id', '=', $getcompany->company_id],
        ])
        ->orderBy('users.id', 'desc')
        ->get();

        return view('content.home.principle.petugas.index', compact('areas','petugass'));
    }

    public function storepetugas(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');

        $user = Auth::user();

        $getcompany = Users::where('id', $user->id)
        ->first();

        $ada = Users::where([
            ['users.email', '=', $request->username]
        ])
        ->first();

        if ($ada){

            $notif = '1';

        } else {

            $createpet = new Users();
            $createpet->name = $request->nama;
            $createpet->role_id = '3';
            $createpet->company_id = $getcompany->company_id;
            $createpet->wilayah_id = $request->cabang;
            $createpet->jenkel = $request->jenkel;
            $createpet->tanggal_lahir = $request->tgl_lhr;
            $createpet->no_hp = $request->no_hp;
            $createpet->alamat = $request->alamat;
            $createpet->email = $request->username;
            $createpet->password = Hash::make($request->pass);
            $createpet->save();

            $notif = '0';

        }

        return response()->json($notif);

    }

    public function deletepetugas(Request $request)
    {
        $userdel = Users::findOrFail($request->id);
        $userdel->delete();

        return response()->json($userdel);
    }

    public function updatepetugas(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');

        $updatespet = Users::findOrFail($request->id);
        $updatespet->name = $request->nama;
        $updatespet->jenkel = $request->jenkel;
        $updatespet->tanggal_lahir = $request->tgl_lahir;
        $updatespet->no_hp = $request->nohp;
        $updatespet->alamat = $request->alamat;
        $updatespet->save();

        $userss = UserCompany::where(['user_id'=>$request->id])
        ->update(['wilayah_id'=>$request->wilayah_id]);

        return response()->json($updatespet);
    }

    public function resetpetugas(Request $request)
    {
        $userreset= Users::findOrFail($request->id);
        $userreset->password = Hash::make('123');
        $userreset->update();

        return response()->json($userreset);
    }

    public function countpesan()
    {   

        $user = Auth::user();

        $disscuss = Diskusi::select("diskusi.*")
        ->leftJoin("posts", "diskusi.post_id", "=", "posts.id")
        ->leftJoin("user_companies", "posts.company_id", "=", "user_companies.company_id")
        ->leftJoin("users", "user_companies.user_id", "=", "users.id")
        ->where([
            ['users.id', '=', $user->id],
            ['role_id', '=', '2'],
            ['read', '=', '0'],
        ])
        ->count();

        return response()->json($disscuss);

    }

    public function countpesanusers()
    { 
        $user = Auth::user();

        $komentar = Komentar::where([
            ['user_id', '!=', $user->id],
            ['read', '=', '0'],
        ])
        ->count();

        return response()->json($komentar);
    }

}
