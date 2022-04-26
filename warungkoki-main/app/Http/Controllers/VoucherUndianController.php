<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\UndianVouchers;
use App\Undian;
use App\UndianHadiah;
use Auth;

class VoucherUndianController extends Controller
{
    public function index()
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d');

        $user = Auth::user();

        $vouchers = UndianVouchers::select("undian_vouchers.code","undians.name","undians.diundi","undian_vouchers.id")
        ->leftJoin("undians", "undian_vouchers.undian_id", "=", "undians.id")
        ->leftJoin("transactions", "undian_vouchers.transaction_id", "=", "transactions.id")
        ->whereDate("undians.dari" ,"<=" ,$date)
        ->whereDate("undians.sampai" ,">=" ,$date)
        ->where("transactions.user_id", $user->id)
        ->get();

        $keranjang = UndianVouchers::leftJoin("transactions", "undian_vouchers.transaction_id", "=", "transactions.id")
        ->where(['transactions.user_id'=>$user->id])
        ->update(['view'=>1]);

        return view('content.voucher_undian.index',compact('vouchers'));

    }

    public function detail(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d');

        $user = Auth::user();

        $vouchers = UndianVouchers::select("undian_vouchers.code","undians.*")
        ->leftJoin("undians", "undian_vouchers.undian_id", "=", "undians.id")
        ->leftJoin("transactions", "undian_vouchers.transaction_id", "=", "transactions.id")
        ->where("undian_vouchers.id", $request->id)
        ->first();

        $hadiah = UndianHadiah::where("undian_id", $vouchers->id)
        ->get();

        return view('content.voucher_undian.detail',compact('vouchers','hadiah'));

    }

}
