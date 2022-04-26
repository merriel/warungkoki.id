<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Users;
use App\Product;
use App\UserCompany;
use App\Garansi;
use App\Posts;
use App\UpdateStocks;
use App\UpdateStockDetails;
use App\UserMembers;
use App\Wilayah;
use Auth;
use DataTables;
use View;

class ProductController extends Controller
{

    public function index()
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d');

        $user = Auth::user();

        $getprods = Product::select('product.name','product.id','product.garansi_id','product.harga')
        ->where('company_id', $user->company_id)
        ->orderBy('product.id', 'desc')
        ->get();

        $garansis = Garansi::where('company_id', $user->company_id)
        ->get();

        return view('content.produk.index', compact('date','getprods','garansis'));
    }


    public function getproduk()
    {

        $user = Auth::user();

        $getprod = Product::where('company_id', $user->company_id)
        ->get();

        return response()->json($getprod);
    }

    public function store(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');

    	$user = Auth::user();

    	$getcompany = UserCompany::where('user_id', $user->id)
    	->first();

        $ada = Product::where('name', $request->nama)
        ->first();

        if ($ada){

            $notif = '1';

        } else {

            $createprod = new Product();
            $createprod->name = $request->nama;
            $createprod->garansi_id = $request->garansi;
            $createprod->company_id = $getcompany->company_id;
            $createprod->harga = $request->harga;
            $createprod->save();

            $notif = '0';

        }

        return response()->json($notif);

    }

    public function update(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
           
        $prods = Product::findOrFail($request->id);
        $prods->name = $request->nama;
        $prods->harga = $request->harga;
        $prods->save();

        return response()->json($prods);
    }

    public function delete(Request $request)
    {
        $proddel = Product::findOrFail($request->id);
        $proddel->delete();

        return response()->json($proddel);
    }

    public function varian(Request $request)
    {
        $prods = Posts::where('id', $request->id)
        ->first();

        return response()->json($prods);

    }

    public function stock(Request $request)
    {   
        date_default_timezone_set('Asia/Jakarta');
        $user = Auth::user();
        $date = date('Y-m-d');

        $stocks = UpdateStocks::where([
            ['user_id', '=', $user->id],
            ['date', '=', $date],
        ])
        ->first();

        $products = Posts::select("posts.*","product.name as prod_name")
        ->leftJoin("users", "posts.user_id", "=", "users.id")
        ->leftJoin("product", "posts.product_id", "=", "product.id")
        ->where('users.wilayah_id', $user->wilayah_id)
        ->where("jenis", NULL)
        ->where("type", "Products")
        ->get();

        $userid = $user->id;

        return view('content.home.petugas.stock', compact('products','stocks'));

    }

    public function stock2(Request $request)
    {   
        date_default_timezone_set('Asia/Jakarta');
        $user = Auth::user();
        $date = date('Y-m-d');

        $stocks = UpdateStocks::where([
            ['user_id', '=', $user->id],
            ['date', '=', $date],
        ])
        ->first();

        $products = Posts::select("posts.*","product.name as prod_name")
        ->leftJoin("users", "posts.user_id", "=", "users.id")
        ->leftJoin("product", "posts.product_id", "=", "product.id")
        ->where('users.wilayah_id', $user->wilayah_id)
        ->where("jenis", NULL)
        ->where("type", "Products")
        ->get();

        $userid = $user->id;

        return view('content.home.petugas.stock2', compact('products','stocks'));

    }

    public function stocknotready(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d');
        $user = Auth::user();

        $stocks = UpdateStocks::where([
            ['user_id', '=', $user->id],
            ['date', '=', $date],
        ])
        ->first();

        if(!$stocks){

            $create = new UpdateStocks();
            $create->user_id = $user->id;
            $create->date = $date;
            $create->save();

            $createdetail = new UpdateStockDetails();
            $createdetail->updatestock_id = $create->id;
            $createdetail->post_id = $request->id;
            $createdetail->save();


        } else {

            $createdetail = new UpdateStockDetails();
            $createdetail->updatestock_id = $stocks->id;
            $createdetail->post_id = $request->id;
            $createdetail->save();

        }

        return response()->json($user);

    }

    public function stockready(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d');
        $user = Auth::user();

        $stocks = UpdateStocks::where([
            ['user_id', '=', $user->id],
            ['date', '=', $date],
        ])
        ->first();

        $delete = UpdateStockDetails::where([
            ['updatestock_id', '=', $stocks->id],
            ['post_id', '=', $request->id],
        ])
        ->delete();


        return response()->json($user);

    }

    public function stocknotready2(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d');
        $user = Auth::user();

        $updates = Posts::findOrFail($request->id);
        $updates->active = 'Y';
        $updates->save();

        return response()->json($updates);

    }

    public function stockready2(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d');
        $user = Auth::user();

        $updates = Posts::findOrFail($request->id);
        $updates->active = 'N';
        $updates->save();

        return response()->json($updates);

    }

    public function konfirmasi(Request $request)
    { 
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d');
        $user = Auth::user();

        $stocks = UpdateStocks::where([
            ['user_id', '=', $user->id],
            ['date', '=', $date],
        ])
        ->first();

        if($stocks){

            $details = UpdateStockDetails::select("posts.*","product.name as prod_name")
            ->leftJoin("posts", "updatestock_details.post_id", "=", "posts.id")
            ->leftJoin("product", "posts.product_id", "=", "product.id")
            ->where('updatestock_id', $stocks->id)
            ->get();

        } else {

            $details = '0';

        }

        return view('content.home.petugas.konfirmasi', compact('details','stocks'));

    }

    public function updatestock()
    { 
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d');
        $user = Auth::user();

        $stocks = UpdateStocks::where([
            ['user_id', '=', $user->id],
            ['date', '=', $date],
        ])
        ->first();

        $adminusers = Users::where([
            ['role_id', '=', '5'],
            ['wilayah_id', '=', $user->wilayah_id],
        ])
        ->first();

        $updateactive = Posts::where(['user_id'=>$adminusers->id, 'jenis'=> NULL])
        ->update(['active'=>'Y']);

        if(!$stocks){

            $create = new UpdateStocks();
            $create->user_id = $user->id;
            $create->date = $date;
            $create->status = 'selesai';
            $create->save();
            

        } else {

            $details = UpdateStockDetails::where('updatestock_id', $stocks->id)
            ->get();

            foreach($details as $detail){

                $updateactive = Posts::where(['id'=>$detail->post_id])
                ->update(['active'=>'N']);

            }

            $updateactive = UpdateStocks::where(['id'=>$stocks->id])
            ->update(['status'=>'selesai']);

        }

        return response()->json($adminusers);

    }

    public function manual(){

        $rows = [

            ['1078','5','13','telurreguler12.jpg','12 Butir','24000'],
            ['1078','5','13','telurreguler36.jpg','36 Butir','52000'],
            ['1078','5','14','telurcurah.jpg','','22000'],

            ['1078','4','7','telursegar12.jpg','12 Butir','27000'],
            ['1078','4','7','telursegar12.jpg','36 Butir','54000'],
            ['1078','4','15','telursegarcurah.jpg','','22000'],


            ['1077','5','13','telurreguler12.jpg','12 Butir','24000'],
            ['1077','5','13','telurreguler36.jpg','36 Butir','52000'],
            ['1077','5','14','telurcurah.jpg','','22000'],

            ['1077','4','7','telursegar12.jpg','12 Butir','27000'],
            ['1077','4','7','telursegar12.jpg','36 Butir','54000'],
            ['1077','4','15','telursegarcurah.jpg','','22000'],


            ['1025','5','13','telurreguler12.jpg','12 Butir','24000'],
            ['1025','5','13','telurreguler36.jpg','36 Butir','52000'],
            ['1025','5','14','telurcurah.jpg','','22000'],

            ['1025','4','7','telursegar12.jpg','12 Butir','27000'],
            ['1025','4','7','telursegar12.jpg','36 Butir','54000'],
            ['1025','4','15','telursegarcurah.jpg','','22000'],

            ['45','5','13','telurreguler12.jpg','12 Butir','24000'],
            ['45','5','13','telurreguler36.jpg','36 Butir','52000'],
            ['45','5','14','telurcurah.jpg','','22000'],

            ['45','4','7','telursegar12.jpg','12 Butir','27000'],
            ['45','4','7','telursegar12.jpg','36 Butir','54000'],
            ['45','4','15','telursegarcurah.jpg','','22000'],

            ['46','5','13','telurreguler12.jpg','12 Butir','24000'],
            ['46','5','13','telurreguler36.jpg','36 Butir','52000'],
            ['46','5','14','telurcurah.jpg','','22000'],

            ['46','4','7','telursegar12.jpg','12 Butir','27000'],
            ['46','4','7','telursegar12.jpg','36 Butir','54000'],
            ['46','4','15','telursegarcurah.jpg','','22000'],


        ];


        foreach ($rows as $data) {

            $userid = $data[0];
            $kategori = $data[1];
            $produk = $data[2];
            $name = $data[4];
            $harga = $data[5];
            $img = $data[3];

            $prod = Product::where('id',$produk)
            ->first();

            $create = new Posts();
            $create->user_id = $userid;
            $create->kategori_id = $kategori;
            $create->product_id = $produk;
            $create->img = $img;
            if($produk == 14 || $produk == 15){
                $create->jenis = 'kg';
            } 
            
            $create->deliver = 'no';
            $create->po = 'no';
            $create->type = 'Products';
            $create->name = $name;
            $create->banyaknya = '500';
            $create->harga_act = $harga;
            $create->active = 'Y';
            $create->save();


        }

    }

    public function barcode(Request $request)
    {
        $prod = Posts::select("posts.*","product.name as prod_name")
        ->leftJoin("product", "posts.product_id", "=", "product.id")
        ->where("posts.id", $request->prod)
        ->first();

        $barcode = $request->barcode;

        $b = explode("|", $barcode);

        $hasil = $b[3];

        $rep = str_replace("kg","",$hasil);

        $arrayNames = array(    
            'name' => $prod->prod_name.' '.$prod->name,
            'harga' => rupiah($prod->harga_act),
            'kg' => $rep,
            'total' => rupiah($rep*$prod->harga_act),
        );

        return response()->json($arrayNames);

    }

    public function db(Request $request){

        $posts = Posts::where("user_id", 1025)
        ->get();

        foreach($posts as $post){

            $create = new Posts();
            $create->user_id = $request->id;
            $create->kategori_id = $post->kategori_id;
            $create->product_id = $post->product_id;
            $create->code_id = $post->code_id;
            $create->img = $post->img;
            $create->deliver = 'no';
            $create->po = 'no';
            $create->type = 'Products';
            $create->name = $post->name;
            $create->banyaknya = $post->banyaknya;
            $create->harga_act = $post->harga_act;
            $create->active = $post->active;
            $create->length = $post->length;
            $create->width = $post->width;
            $create->height = $post->height;
            $create->weight = $post->weight;
            $create->save();


        }


    }

    public function members(){

        $rows = [

           
            ['16229','16209','31241'],
            ['19493','16199','31242'],



        ];


        foreach ($rows as $data) {

            $memberid = $data[0];
            $userid = $data[1];
            $transaksi = $data[2];

            $cek = UserMembers::where("member_id", $memberid)
            ->first();

            if(!$cek){

                $create = new UserMembers();
                $create->member_id = $memberid;
                $create->user_id = $userid;
                $create->transaction_id = $transaksi;
                $create->save();


            }      

        }

    }

    public function productpromo(Request $request){

       $wilayah = Wilayah::select("wilayah.id", "users.id as user_id")
       ->leftJoin("users", "wilayah.id", "=", "users.wilayah_id")
       ->where("wilayahcategory_id", '!=', 4)
       ->where("users.role_id", 5)
       ->get();

        foreach($wilayah as $c){

            $create = new Posts();
            $create->user_id = $c->user_id;
            $create->kategori_id = 1;
            $create->product_id = 33;
            $create->code_id = 27;
            $create->img = "tissue.jpg";
            $create->deliver = "no";
            $create->po = "no";
            $create->type = "Products";
            $create->name = "250 Gram";
            $create->harga_act = 12500;
            $create->active = "N";
            $create->length = 35;
            $create->width = 25;
            $create->height = 9;
            $create->weight = 250;
            $create->save();

            $create = new Posts();
            $create->user_id = $c->user_id;
            $create->kategori_id = 1;
            $create->product_id = 33;
            $create->code_id = 28;
            $create->img = "tissue.jpg";
            $create->deliver = "no";
            $create->po = "no";
            $create->type = "Products";
            $create->name = "660 Gram";
            $create->harga_act = 25000;
            $create->active = "Y";
            $create->length = 35;
            $create->width = 25;
            $create->height = 9;
            $create->weight = 660;
            $create->save();

        }

    }
}
