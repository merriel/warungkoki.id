<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Vouchers;
use App\VoucherDetails;
use App\Order;
use Auth;
use DataTables;
use Uuid;
use PDF;



class VoucherController extends Controller
{
    public function index()
    {
    	date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d');

        $user = Auth::user();

        $vouchers = Vouchers::all();

        return view('content.voucher.index', compact('date','vouchers'));

    }

    public function data(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d');
        $user = Auth::user();

        $vouchers = VoucherDetails::all();

        return Datatables::of($vouchers)->make(true);
    }

    public function pilih(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d');
        $user = Auth::user();

        $vouchers = VoucherDetails::select("voucher_details.*","vouchers.name")
        ->join("vouchers", "voucher_details.voucher_id", "=", "vouchers.id")
        ->where([
            ['status', '=', NULL],
            ['dari', '<=', $date],
            ['sampai', '>=', $date],
        ])
        ->get();

        return Datatables::of($vouchers)->make(true);
    }

    public function store(Request $request)
    {

        date_default_timezone_set('Asia/Jakarta');
        $tanggal = date('d');
        $date = date('Y-m-d');

        for($i=0; $i < $request->banyak; $i++){

        	$uuid = Uuid::generate();
	        $kode = substr($uuid, 0, 4);
	        $belakang = substr($uuid, -4);

            $savedetail = new VoucherDetails();
	        $savedetail->company_id = 1;
	        $savedetail->voucher_id = $request->voucher_id;
	        $savedetail->kode = $kode.$tanggal.$belakang;
	        $savedetail->date = $date;
	        $savedetail->dari = $request->dari;
	        $savedetail->sampai = $request->sampai;
	        $savedetail->save();

        }

        return response()->json($tanggal);
    }

    public function delete(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');

        $kars = VoucherDetails::where('id', $request->id)
        ->delete();

        return response()->json($kars);

    }

    public function cetak(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d');

        $vouc = explode(",", $request->id);

    	$vouchers = VoucherDetails::join("vouchers", "voucher_details.voucher_id", "=", "vouchers.id")
    	->whereIn('voucher_details.id', $vouc)
        ->get();

        $pdf = PDF::loadView('content.voucher.pdf', compact('vouchers'))->setPaper('A4','potrait');
        return $pdf->stream();
    }

    public function cek(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d');

        $kode = $request->kode;

        $voucher = Order::select("voucher_details.status","wilayah.name as wilayah_name","voucher_details.updated_at as waktu","users.name as user_name","vouchers.name as voucher_name","vouchers.amount","transactions.status as trans_status")
        ->join("voucher_details", "orders.voucherdet_id", "=", "voucher_details.id")
        ->join("transactions", "orders.transaction_id", "=", "transactions.id")
        ->join("vouchers", "voucher_details.voucher_id", "=", "vouchers.id")
        ->join("wilayah", "transactions.wilayah_id", "=", "wilayah.id")
        ->join("users", "transactions.user_id", "=", "users.id")
        ->where("voucher_details.kode",$kode)
        ->first();

        $cekvoucher = VoucherDetails::select("vouchers.*")
        ->join("vouchers", "voucher_details.voucher_id", "=", "vouchers.id")
        ->where('voucher_details.kode', $kode)
        ->first();


        return view('content.voucher.cek', compact('date','kode','voucher','cekvoucher'));

    }


}
