<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Posts;
use App\Wilayah;
use App\StockTransactions;
use App\StockTransactionDetails;
use Auth;
use DataTables;

class StocksController extends Controller
{
    public function index(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d');

        $user = Auth::user();   
        
        $wilayah = Wilayah::where("active","Y")
        ->get();    

        if($request->uuid != NULL){
            $wils = Wilayah::where('uuid', $request->uuid)
            ->first();
            $tanggal = $request->date;
        } else {
            $wils = Wilayah::first();
            $tanggal = $date;
        }

        $posts = Posts::select("posts.name","post_codes.kode","product.name as prod_name","posts.id")
        ->join("product", "posts.product_id", "=", "product.id")
        ->join("users", "posts.user_id", "=", "users.id")
        ->join("wilayah", "users.wilayah_id", "=", "wilayah.id")
        ->join("post_codes", "posts.code_id", "=", "post_codes.id")
        ->where("wilayah.id", $wils->id)
        ->distinct()
        ->orderBy("post_codes.kode","asc")
        ->get();

        $pagi = StockTransactions::select("stock_transactions.*")
        ->join("wilayah", "stock_transactions.wilayah_id", "=", "wilayah.id")
        ->where("type","cek")
        ->where("jenis","awal")
        ->where("wilayah_id",$wils->id)
        ->where("date",$tanggal)
        ->where("status",NULL)
        ->orderBy("stock_transactions.id","desc")
        ->first();

        $masuk = StockTransactions::select("stock_transactions.*")
        ->join("wilayah", "stock_transactions.wilayah_id", "=", "wilayah.id")
        ->where("type","in")
        ->where("jenis","pemasukan")
        ->where("wilayah_id",$wils->id)
        ->where("date",$tanggal)
        ->where("status",NULL)
        ->orderBy("stock_transactions.id","desc")
        ->first();

        $retur = StockTransactions::select("stock_transactions.*")
        ->join("wilayah", "stock_transactions.wilayah_id", "=", "wilayah.id")
        ->where("type","out")
        ->where("jenis","retur")
        ->where("wilayah_id",$wils->id)
        ->where("date",$tanggal)
        ->where("status",NULL)
        ->orderBy("stock_transactions.id","desc")
        ->first();

        $intratokokeluar = StockTransactions::select("stock_transactions.*")
        ->join("wilayah", "stock_transactions.wilayah_id", "=", "wilayah.id")
        ->where("type","out")
        ->where("jenis","intratoko")
        ->where("wilayah_id",$wils->id)
        ->where("date",$tanggal)
        ->where("status",NULL)
        ->orderBy("stock_transactions.id","desc")
        ->first();

        $intratokomasuk = StockTransactions::select("stock_transactions.*")
        ->join("wilayah", "stock_transactions.wilayah_id", "=", "wilayah.id")
        ->where("type","in")
        ->where("jenis","intratoko")
        ->where("wilayah_id",$wils->id)
        ->where("date",$tanggal)
        ->where("status",NULL)
        ->orderBy("stock_transactions.id","desc")
        ->first();

        $malam = StockTransactions::select("stock_transactions.*")
        ->join("wilayah", "stock_transactions.wilayah_id", "=", "wilayah.id")
        ->where("type","cek")
        ->where("jenis","akhir")
        ->where("wilayah_id",$wils->id)
        ->where("date",$tanggal)
        ->where("status",NULL)
        ->orderBy("stock_transactions.id","desc")
        ->first();

        return view('content.stocks.index', compact('wilayah','wils','posts','tanggal','pagi','masuk','retur','intratokokeluar','intratokomasuk','malam'));
    }

    public function view(Request $request)
    {

        $stock = Stocks::select("stocks.*","products.name","products.uuid","transactions.date2","transactions.time","types.name as type_name","transactions.wilayah_id as wil_id")
        ->join("products", "stocks.product_id", "=", "products.id")
        ->join("transactions", "stocks.transaction_id", "=", "transactions.id")
        ->join("types", "transactions.type_id", "=", "types.id")
        ->where([
          ['stocks.product_id', '=', $request->product_id],
          ['stocks.wilayah_id', '=', $request->wilayah_id],
        ])
        ->orderBy('stocks.id', 'asc')
        ->limit(5)
        ->get();

        return response()->json($stock);

    }
}
