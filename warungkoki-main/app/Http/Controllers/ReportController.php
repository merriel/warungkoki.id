<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Exports\ReportExcel;
use App\Order;
use App\Transaksi;
use Auth;

class ReportController extends Controller
{
    public function index()
    {

    	date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d');

        $user = Auth::user();

        return view('content.report.index', compact('date'));

    }

    public function detail(Request $request)
    {

    	date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d');

        $dari = $request->dari;
        $sampai = $request->sampai;
        $jenis = $request->type;

        if($request->type == 'penjualan'){

        	$type = 'Transaksi Penjualan';

	        $trans = Order::leftJoin("transactions", "orders.transaction_id", "=", "transactions.id")
	    	->whereBetween('orders.created_at', [$request->dari, $request->sampai])
	        ->where([
	            ['orders.type_bayar', '=', 'CASH'],
	            ['transactions.status', '=', 'APPROVED']
	        ])
	        ->count();

	        $onlines = Order::leftJoin("transactions", "orders.transaction_id", "=", "transactions.id")
	    	->whereBetween('orders.created_at', [$request->dari, $request->sampai])
	        ->where([
	            ['orders.type_bayar', '=', 'ONLINE'],
	            ['transactions.status', '=', 'APPROVED']
	        ])
	        ->count();

	        $total = Order::leftJoin("transactions", "orders.transaction_id", "=", "transactions.id")
	    	->whereBetween('orders.created_at', [$request->dari, $request->sampai])
	        ->where([
	            ['orders.type_bayar', '=', 'CASH'],
	            ['transactions.status', '=', 'APPROVED']
	        ])
	        ->sum('orders.amount');

	        $totalonlines = Order::leftJoin("transactions", "orders.transaction_id", "=", "transactions.id")
	    	->whereBetween('orders.created_at', [$request->dari, $request->sampai])
	        ->where([
	            ['orders.type_bayar', '=', 'ONLINE'],
	            ['transactions.status', '=', 'APPROVED']
	        ])
	        ->sum('orders.amount');

	        return view('content.report.detail', compact('total','trans','dari','sampai','type','jenis','onlines','totalonlines'));

	    } else {

	    	$type = 'Transaksi Reedem';

	    	$deals = Transaksi::select("transactions.id")
	    	->leftJoin("saldo", "transactions.id", "=", "saldo.transaction_id")
	    	->leftJoin("posts", "saldo.post_id", "=", "posts.id")
	    	->whereBetween('transactions.created_at', [$request->dari, $request->sampai])
	    	->where([
	            ['transactions.type', '=', 'out'],
	            ['transactions.status', '=', 'APPROVED'],
	            ['posts.type', '=', 'Deals'],
	        ])
	        ->count();

	        $dealtotals = Transaksi::select("transactions.id","transaction_details.qty","product.harga")
	        ->leftJoin("transaction_details", "transactions.id", "=", "transaction_details.transaction_id")
	        ->leftJoin("product", "transaction_details.product_id", "=", "product.id")
	    	->leftJoin("saldo", "transactions.id", "=", "saldo.transaction_id")
	    	->leftJoin("posts", "saldo.post_id", "=", "posts.id")
	    	->whereBetween('transactions.created_at', [$request->dari, $request->sampai])
	    	->where([
	            ['transactions.type', '=', 'out'],
	            ['transactions.status', '=', 'APPROVED'],
	            ['posts.type', '=', 'Deals'],
	        ])
	        ->get();

	        $products = Transaksi::select("transactions.id")
	    	->leftJoin("saldo", "transactions.id", "=", "saldo.transaction_id")
	    	->leftJoin("posts", "saldo.post_id", "=", "posts.id")
	    	->whereBetween('transactions.created_at', [$request->dari, $request->sampai])
	    	->where([
	            ['transactions.type', '=', 'out'],
	            ['transactions.status', '=', 'APPROVED'],
	            ['posts.type', '=', 'Products'],
	        ])
	        ->count();

	        $producttotals = Transaksi::select("transactions.id","transaction_details.qty","posts.harga_act")
	        ->leftJoin("transaction_details", "transactions.id", "=", "transaction_details.transaction_id")
	        ->leftJoin("product", "transaction_details.product_id", "=", "product.id")
	    	->leftJoin("saldo", "transactions.id", "=", "saldo.transaction_id")
	    	->leftJoin("posts", "saldo.post_id", "=", "posts.id")
	    	->whereBetween('transactions.created_at', [$request->dari, $request->sampai])
	    	->where([
	            ['transactions.type', '=', 'out'],
	            ['transactions.status', '=', 'APPROVED'],
	            ['posts.type', '=', 'Products'],
	        ])
	        ->get();

	        $rewards = Transaksi::select("transactions.id")
	    	->leftJoin("saldo", "transactions.id", "=", "saldo.transaction_id")
	    	->leftJoin("posts", "saldo.post_id", "=", "posts.id")
	    	->whereBetween('transactions.created_at', [$request->dari, $request->sampai])
	    	->where([
	            ['transactions.type', '=', 'out'],
	            ['transactions.status', '=', 'APPROVED'],
	            ['posts.type', '=', 'Challange'],
	        ])
	        ->count();

	        $total = $deals + $products + $rewards;


	        return view('content.report.detail', compact('deals','rewards','products','dari','sampai','type','jenis','total','dealtotals','producttotals'));

	    }

    }

    public function printexcel(Request $request)
    {	
    	$user = Auth::user();

        return (new ReportExcel($request->dari,$request->sampai,$request->type,$user->id))->download('ReportExcel.xlsx');

    }
}
