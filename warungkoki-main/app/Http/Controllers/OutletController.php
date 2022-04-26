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
use Auth;
use Validator;
use Hash;
use Image;
use DB;

class OutletController extends Controller
{
    public function index()
    {
    	date_default_timezone_set('Asia/Jakarta');
    	$date = date('Y-m-d');

    	$user = Auth::user();

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

        $reedemhariini = Transaksi::select("transactions.id")
        ->join("transaction_details", "transactions.id", "=", "transaction_details.transaction_id")
        ->join("posts", "transaction_details.post_id", "=", "posts.id")
        ->distinct()
        ->where([
            ['transactions.type', '=', 'out'],
            ['transactions.status', '=', 'APPROVED'],
            ['posts.user_id', '=', $user->id],
        ])
        ->whereDate('transactions.created_at', $date)
        ->get();

        $transaksihariini = Transaksi::select("transactions.id")
        ->join("transaction_details", "transactions.id", "=", "transaction_details.transaction_id")
        ->join("posts", "transaction_details.post_id", "=", "posts.id")
        ->distinct()
        ->where([
            ['transactions.type', '=', 'in'],
            ['transactions.status', '=', 'APPROVED'],
            ['posts.user_id', '=', $user->id],
        ])
        ->whereDate('transactions.created_at', $date)
        ->get();

        $transaksirupiah = DB::table('transactions')
        ->select("orders.amount")
        ->join("orders", "transactions.id", "=", "orders.transaction_id")
        ->join("transaction_details", "transactions.id", "=", "transaction_details.transaction_id")
        ->join("posts", "transaction_details.post_id", "=", "posts.id")
        ->distinct()
        ->where([
            ['transactions.type', '=', 'in'],
            ['transactions.status', '=', 'APPROVED'],
            ['posts.user_id', '=', $user->id],
        ])
        ->whereDate('transactions.created_at', $date)
        ->sum('orders.amount');

    	return view('content.home.outlet.index', compact('date','prods','areas','kategoris','transaksihariini','transaksirupiah','prod2s','reedemhariini'));

    }
}
