<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Stocks;
use App\StockTransactions;
use App\StockTransactionDetails;
use App\Wilayah;
use App\Posts;
use App\Regency;
use App\Product;
use App\Users;
use Auth;
use DB;

class StockController extends Controller
{
    public function index()
    {
        date_default_timezone_set('Asia/Jakarta');
        $user = Auth::user();
        $date = date('Y-m-d');

        $stocks = StockTransactions::where([
            ['wilayah_id', '=', $user->wilayah_id],
            ['date', '=', $date],
            ['type', '=', 'cek'],
        ])
        ->first();

        $products = Product::select("product.id","product.name","posts.user_id")
        ->leftJoin("posts", "product.id", "=", "posts.product_id")
        ->leftJoin("users", "posts.user_id", "=", "users.id")
        ->where('users.wilayah_id', $user->wilayah_id)
        ->where("posts.jenis", NULL)
        ->where("posts.type", "Products")
        ->where("posts.code_id", '!=', NULL)
        ->distinct()
        ->get();

        $userid = $user->id;

        return view('content.home.petugas.stock', compact('products','stocks'));
    }

    public function edit(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $user = Auth::user();
        $date = date('Y-m-d');

        $stock = StockTransactions::where("id", $request->id)
        ->first();

        $products = Product::select("product.id","product.name","posts.user_id")
        ->leftJoin("posts", "product.id", "=", "posts.product_id")
        ->leftJoin("users", "posts.user_id", "=", "users.id")
        ->where('users.wilayah_id', $user->wilayah_id)
        ->where("posts.jenis", NULL)
        ->where("posts.type", "Products")
        ->where("posts.code_id", '!=', NULL)
        ->distinct()
        ->get();

        return view('content.home.petugas.stockedit', compact('stock','products'));
    }

    public function notready(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d');
        $user = Auth::user();

        $updateactive = Posts::where(['id'=>$request->id])
        ->update(['active'=>'N']);

        return response()->json($user);

    }

    public function ready(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d');
        $user = Auth::user();

        $updateactive = Posts::where(['id'=>$request->id])
        ->update(['active'=>'Y']);

        return response()->json($user);

    }

    public function update(Request $request)
    { 
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d');
        $user = Auth::user();

        $create = new StockTransactions();
        $create->user_id = $user->id;
        $create->wilayah_id = $user->wilayah_id;

        if($request->jenis == "intratoko"){
            $create->destination_id = $request->wilayahid;
        }

        $create->date = $date;
        $create->type = $request->type;
        $create->jenis = $request->jenis;
        if($request->jenis == "intratoko"){
            $create->status = "pending";
        }
        $create->save();

        $countposts = count($request->postid);

        for($i=0; $i < $countposts; $i++){

            $postdet = new StockTransactionDetails();
            $postdet->stocktransaction_id = $create->id;
            $postdet->post_id = $request->postid[$i];
            $postdet->qty = $request->qty[$i];
            $postdet->save();

        }

        return response()->json($create);

    }


    public function editupdate(Request $request)
    { 
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d');
        $user = Auth::user();

        $create = new StockTransactions();
        $create->user_id = $user->id;
        $create->wilayah_id = $user->wilayah_id;

        if($request->jenis == "intratoko"){
            $create->destination_id = $request->wilayahid;
        }

        $create->date = $date;
        $create->type = $request->type;
        $create->jenis = $request->jenis;
        $create->status = "notapproved";
        $create->save();

        $countposts = count($request->postid);

        for($i=0; $i < $countposts; $i++){

            $postdet = new StockTransactionDetails();
            $postdet->stocktransaction_id = $create->id;
            $postdet->post_id = $request->postid[$i];
            $postdet->qty = $request->qty[$i];
            $postdet->save();

        }

        return response()->json($create);

    }

    public function inbound()
    {
        date_default_timezone_set('Asia/Jakarta');
        $user = Auth::user();
        $date = date('Y-m-d');

        $products = Product::select("product.id","product.name","posts.user_id")
        ->leftJoin("posts", "product.id", "=", "posts.product_id")
        ->leftJoin("users", "posts.user_id", "=", "users.id")
        ->where('users.wilayah_id', $user->wilayah_id)
        ->where("posts.jenis", NULL)
        ->where("posts.type", "Products")
        ->where("posts.code_id", '!=', NULL)
        ->distinct()
        ->get();

        $userid = $user->id;

        return view('content.home.petugas.inbound', compact('products'));
    }

    public function retur()
    {
        date_default_timezone_set('Asia/Jakarta');
        $user = Auth::user();
        $date = date('Y-m-d');

        $products = Product::select("product.id","product.name","posts.user_id")
        ->leftJoin("posts", "product.id", "=", "posts.product_id")
        ->leftJoin("users", "posts.user_id", "=", "users.id")
        ->where('users.wilayah_id', $user->wilayah_id)
        ->where("posts.jenis", NULL)
        ->where("posts.type", "Products")
        ->where("posts.code_id", '!=', NULL)
        ->distinct()
        ->get();

        $userid = $user->id;

        return view('content.home.petugas.inboundretur', compact('products'));
    }

    public function intratoko()
    {
        date_default_timezone_set('Asia/Jakarta');
        $user = Auth::user();
        $date = date('Y-m-d');

        $products = Product::select("product.id","product.name","posts.user_id")
        ->leftJoin("posts", "product.id", "=", "posts.product_id")
        ->leftJoin("users", "posts.user_id", "=", "users.id")
        ->where('users.wilayah_id', $user->wilayah_id)
        ->where("posts.jenis", NULL)
        ->where("posts.type", "Products")
        ->where("posts.code_id", '!=', NULL)
        ->distinct()
        ->get();

        $wils = Wilayah::where("id",'!=', $user->wilayah_id)
        ->get();

        $userid = $user->id;

        return view('content.home.petugas.intratoko', compact('products','wils'));
    }

    public function confirm(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d');
        $user = Auth::user();

        $details = StockTransactionDetails::select("stock_transaction_details.qty","posts.name as post_name","product.name as prod_name","wilayah.name as wilayah_name")
        ->leftJoin("stock_transactions", "stock_transaction_details.stocktransaction_id", "=", "stock_transactions.id")
        ->leftJoin("wilayah", "stock_transactions.wilayah_id", "=", "wilayah.id")
        ->leftJoin("posts", "stock_transaction_details.post_id", "=", "posts.id")
        ->leftJoin("product", "posts.product_id", "=", "product.id")
        ->where('stocktransaction_id',$request->id)
        ->get();

        return response()->json($details);

    }

    public function approve(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d');
        $user = Auth::user();

        $updateactive = StockTransactions::where(['id'=>$request->id])
        ->update(['status'=>NULL]);

        $create = new StockTransactions();
        $create->user_id = $user->id;
        $create->wilayah_id = $user->wilayah_id;
        $create->date = $date;
        $create->type = "in";
        $create->jenis = "intratoko";
        $create->save();

        $details = StockTransactionDetails::where("stocktransaction_id", $request->id)
        ->get();

        foreach($details as $det){

            $postnya = Posts::select("code_id")
            ->where('id', $det->post_id)
            ->first();

            $postuser = Users::select("id")
            ->where("role_id", 5)
            ->where("wilayah_id", $user->wilayah_id)
            ->first();

            $cekpostnya = Posts::select("posts.id")
            ->where("code_id",$postnya->code_id)
            ->where("user_id", $postuser->id)
            ->first();

            $postdet = new StockTransactionDetails();
            $postdet->stocktransaction_id = $create->id;
            $postdet->post_id = $cekpostnya->id;
            $postdet->qty = $det->qty;
            $postdet->save();

        }

        return response()->json($details);

    }

    public function rincian(Request $request)
    {

        $stocks = StockTransactionDetails::select("posts.name as post_name", "stock_transaction_details.*","product.name as prod_name","posts.id as post_id")
        ->leftJoin("posts", "stock_transaction_details.post_id", "=", "posts.id")
        ->leftJoin("product", "posts.product_id", "=", "product.id")
        ->where("stocktransaction_id", $request->id)
        ->get();

        $transaksiid = $request->id;

        $trs = StockTransactions::where("id", $transaksiid)
        ->first();

        $sebelumnya = StockTransactions::where("date", $trs->date)
        ->where("type", $trs->type)
        ->where("jenis", $trs->jenis)
        ->where("status", NULL)
        ->first();

        return view('content.home.supervisor.rincian', compact('stocks','transaksiid','sebelumnya'));

    }

    public function perubahanstock(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');

        $updateactive = StockTransactions::where(['id'=>$request->id])
        ->update(['status'=>NULL]);

        $updateactive22 = StockTransactions::where(['id'=>$request->sebelumnyaid])
        ->update(['status'=>"edited"]);

        return response()->json($updateactive);

    }

    public function tolakstock(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');

        $updateactive = StockTransactions::where(['id'=>$request->id])
        ->update(['status'=>"tolak"]);


        return response()->json($updateactive);

    }
}
