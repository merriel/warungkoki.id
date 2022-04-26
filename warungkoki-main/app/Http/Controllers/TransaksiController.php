<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Exports\TransactionExcel;
use App\UserCompany;
use App\Posts;
use App\PostDetails;
use App\TransaksiDetails;
use App\Transaksi;
use App\Keranjang;
use App\Order;
use App\WSTransaksi;
use App\OrderDetails;
use App\Users;
use App\Saldo;
use App\Tours;
use App\Services;
use App\TransactionRetur;
use App\TransactionDelivery;
use App\Wilayah;
use Auth;
use Uuid;
use Mail;
use DB;
use \Midtrans\Config;
use \Midtrans\Transaction;
use DataTables; 
use PDF;
use Image;
use Validator;

class TransaksiController extends Controller
{
    /**
     * Make request global.
     *
     * @var \Illuminate\Http\Request
     */
    protected $request;
    /**
     * Class constructor.
     *
     * @param \Illuminate\Http\Request $request User Request
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
 
        // Set midtrans configuration
        \Midtrans\Config::$serverKey = config('services.midtrans.serverKey');
        \Midtrans\Config::$isProduction = config('services.midtrans.isProduction');
        \Midtrans\Config::$isSanitized = config('services.midtrans.isSanitized');
        \Midtrans\Config::$is3ds = config('services.midtrans.is3ds');
    }

    public function index()
    {
        $user = Auth::user();

        $getcompany = UserCompany::where('user_id', $user->id)
        ->first(); 

        return view('content.transaksi.index', compact('getcompany','ada'));

    }

    public function data(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d');

        $user = Auth::user();

        $getcompany = UserCompany::where('user_id', $user->id)
        ->first();

        $datas = Transaksi::select(DB::raw('DATE_FORMAT(orders.created_at, "%d %b %Y") as date'),"posts.name as post_name", "orders.type_bayar","orders.amount","orders.status","orders.created_at","users.name as user_name")
        ->leftJoin("transaction_details", "transactions.id", "=", "transaction_details.transaction_id")
        ->leftJoin("orders", "transactions.id", "=", "orders.transaction_id")
        ->leftJoin("posts", "transaction_details.post_id", "=", "posts.id")
        ->leftJoin("users", "transactions.user_id", "=", "users.id")
        ->where([
            ['transactions.type', '=', 'in'],
            ['posts.company_id', '=', $getcompany->company_id],
        ])
        ->get();

        return Datatables::of($datas)->make(true);
    }

    public function reedem(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d');

        $user = Auth::user();

        $getcompany = UserCompany::where('user_id', $user->id)
        ->first();

        $datas = Transaksi::select(DB::raw('DATE_FORMAT(transactions.created_at, "%d %b %Y") as date'),"posts.name as post_name","product.name as prod_name","transaction_details.qty","transactions.status","users.name as user_name","transactions.created_at")
        ->leftJoin("transaction_details", "transactions.id", "=", "transaction_details.transaction_id")
        ->leftJoin("posts", "transaction_details.post_id", "=", "posts.id")
        ->leftJoin("users", "transactions.petugas_id", "=", "users.id")
        ->leftJoin("product", "transaction_details.product_id", "=", "product.id")
        ->where([
            ['transactions.type', '=', 'out'],
            ['posts.company_id', '=', $getcompany->company_id],
            ['transactions.status', '=', 'APPROVED'],
        ])
        ->get();

        return Datatables::of($datas)->make(true);
    }

    public function cash()
    {
        date_default_timezone_set('Asia/Jakarta');
        $user = Auth::user();
        $dates = date('d');

        $keranjangs = Keranjang::select("posts.*","imgpost.name as img_name","keranjang.qty")
        ->leftJoin("posts", "keranjang.post_id", "=", "posts.id")
        ->leftJoin("post_images", "posts.id", "=", "post_images.post_id")
        ->leftJoin("imgpost", "post_images.img_id", "=", "imgpost.id")
        ->where("keranjang.user_id", $user->id)
        ->get();

        $uuid = Uuid::generate();
        $code = substr($uuid,0,8);

        $trans = new Transaksi();
        $trans->uuid = $code.$dates;
        $trans->user_id = $user->id;
        $trans->type = 'in';
        $trans->status = 'NOT APPROVED';
        $trans->save();


        $total = 0;

        foreach ($keranjangs as $keranjang) {

            $total += $keranjang->qty * $keranjang->harga_act;

            // $posts = PostDetails::where("post_id", $keranjang->id)
            // ->get();

            // foreach($posts as $post){   

                $transdet = new TransaksiDetails();
                $transdet->transaction_id = $trans->id;
                $transdet->post_id = $keranjang->id;
                $transdet->product_id = $keranjang->product_id;
                $transdet->qty = $keranjang->qty;
                $transdet->save();

            // } 
            
        }

        $reedem = Keranjang::where("user_id", $user->id)
        ->first();

        $trans2 = new Order();
        $trans2->uuid = $uuid;
        $trans2->transaction_id = $trans->id;
        $trans2->user_id = $user->id;
        $trans2->type_bayar = 'CASH';
        $trans2->amount = $total;
        $trans2->status = 'pending';
        $trans2->reedem = $reedem->reedem;
        $trans2->save();

        foreach ($keranjangs as $keranjang) {

            $transorder = new OrderDetails();
            $transorder->order_id = $trans2->id;
            $transorder->post_id = $keranjang->id;
            $transorder->qty = $keranjang->qty;
            $transorder->amount = $keranjang->qty * $keranjang->harga_act;
            $transorder->save();

        }

        $transaksis = OrderDetails::select("posts.*","order_details.qty","order_details.amount","product.name as prod_name")
        ->leftJoin("posts", "order_details.post_id", "=", "posts.id")
        ->leftJoin("product", "posts.product_id", "=", "product.id")
        ->where("order_details.order_id", $trans2->id)
        ->get();

        $keranjanghapus = Keranjang::where("user_id", $user->id)
        ->delete();

        $emails = $user->email;

        try{
            Mail::send('email.belicash', ['nama' => $user->name, 'amount' => $total, 'transaksis' => $transaksis], function ($message) use ($emails)
            {
                $message->subject('Segera Bayar Cash Pembelian Anda ke Petugas Kami!');
                $message->from('admin@iolosmart.com', 'Admin Babantos');
                $message->to($emails);
            });

        }
        catch (Exception $e){
            return response (['status' => false,'errors' => $e->getMessage()]);
        }

        return response()->json($trans);

    }

    public function transaksiusers()
    {
        date_default_timezone_set('Asia/Jakarta');
        $user = Auth::user();

        $transaksins = Transaksi::select('transactions.*','orders.type_bayar','undians.name as undian_name')
        ->leftJoin("orders", "transactions.id", "=", "orders.transaction_id")
        ->leftJoin("undian_hadiahs", "transactions.id", "=", "undian_hadiahs.transaction_id")
        ->leftJoin("undians", "undian_hadiahs.undian_id", "=", "undians.id")
        ->where([
            ['transactions.user_id', '=', $user->id],
        ])
        ->orderBy("transactions.id","desc")
        ->limit(10)
        ->get();

        $transaksouts = Transaksi::select('transactions.*','orders.type_bayar')->where([
            ['transactions.user_id', '=', $user->id],
            ['transactions.alamat_id', '=', null],
        ])
        ->leftJoin("orders", "transactions.id", "=", "orders.transaction_id")
        ->orderBy("transactions.id","desc")
        ->limit(10)
        ->get();

        $transaksidelivers = Transaksi::where([
            ['user_id', '=', $user->id],
            ['alamat_id', '!=', null],
        ])
        ->orderBy("transactions.id","desc")
        ->limit(10)
        ->get();

        $sum = Transaksi::where([
            ['user_id', '=', $user->id],
        ])
        ->count();

        $sumdel = Transaksi::where([
            ['user_id', '=', $user->id],
            ['alamat_id', '!=', null],
        ])
        ->count();

        $tour = Tours::where("user_id", $user->id)
        ->first();

        if($transaksins->count() >= 1){

            $sudahtour = Tours::where(['user_id'=>$user->id])
            ->update(['transaksi'=>'1']);

        }
        $ada = 0;

        return view('content.transaksi.users', compact('transaksins','transaksouts','sum','transaksidelivers','tour','ada'));

    }

    public function transaksiuserdetails(Request $request)
    {   
        $trans = Transaksi::select("transactions.*","orders.type_bayar","regencies.name as regency_name","provinces.name as prov_name","regencies.postal_code","districts.name as district_name","alamat.penerima","alamat.nohp","alamat.alamat","orders.jam","orders.delivery_name","orders.delivery_type","orders.diskon","undians.name as undian_name")
        ->leftJoin("orders", "transactions.id", "=", "orders.transaction_id")
        ->leftJoin("alamat", "transactions.alamat_id", "=", "alamat.id")
        ->leftJoin("districts", "alamat.district_id", "=", "districts.id")
        ->leftJoin("regencies", "districts.regency_id", "=", "regencies.id")
        ->leftJoin("provinces", "regencies.province_id", "=", "provinces.id")
        ->leftJoin("undian_hadiahs", "transactions.id", "=", "undian_hadiahs.transaction_id")
        ->leftJoin("undians", "undian_hadiahs.undian_id", "=", "undians.id")
        ->where("transactions.uuid", $request->uuid)
        ->first();

        date_default_timezone_set('Asia/Jakarta');
        $usernyah = Auth::user();

        if(!$usernyah){
            $user = Users::where("clubsmart", csrf_token())
            ->first();
        } else {
            $user = Auth::user();
        }

        $service = Services::first();

        $wilayah = TransaksiDetails::select("wilayah.name","retailers.name as retailer_name")
        ->leftJoin("transactions", "transaction_details.transaction_id", "=", "transactions.id")
        ->leftJoin("posts", "transaction_details.post_id", "=", "posts.id")
        ->leftJoin("users", "posts.user_id", "=", "users.id")
        ->leftJoin("wilayah", "users.wilayah_id", "=", "wilayah.id")
        ->leftJoin("retailers", "transactions.retailer_id", "=", "retailers.id")
        ->where("transactions.uuid", $request->uuid)
        ->first();

        if($trans->status == "REEDEM"){
            $jenis = 'Pengambilan Barang';
        } else {
            $jenis = 'Pembelian';

        }


        if($trans->status != "REEDEM"){

            $saldos = OrderDetails::select("posts.*","order_details.qty","order_details.amount","transactions.id as trans_id","orders.amount as total","transactions.status","product.name as prod_name","orders.delivery as delivery","orders.delivery_name","orders.delivery_type")
            ->leftJoin("orders", "order_details.order_id", "=", "orders.id")
            ->leftJoin("transactions", "orders.transaction_id", "=", "transactions.id")
            ->leftJoin("posts", "order_details.post_id", "=", "posts.id")
            ->leftJoin("product", "posts.product_id", "=", "product.id")
            ->where("transactions.uuid", $request->uuid)
            ->get();

        } else {


            $saldos = TransaksiDetails::select("posts.*","transaction_details.qty","transactions.id as trans_id","product.name as prod_name","transactions.status","transaction_details.status as detail_status")
            ->leftJoin("transactions", "transaction_details.transaction_id", "=", "transactions.id")
            ->leftJoin("posts", "transaction_details.post_id", "=", "posts.id")
            ->leftJoin("product", "transaction_details.product_id", "=", "product.id")
            ->where("transactions.uuid", $request->uuid)
            ->get();

        }


        $tour = Tours::where("user_id", $user->id)
        ->first();


        $sudahtour = Tours::where(['user_id'=>$user->id])
        ->update(['transdetail'=>'1']);

        $retur = TransactionRetur::where("transaction_id", $trans->id)
        ->first();

        $ada = 1;

        $transdel = TransactionDelivery::select("transaction_delivery.*","users.name as user_name","users.no_hp")
        ->leftJoin("users", "transaction_delivery.user_id", "=", "users.id")
        ->where('transaction_delivery.transaction_id', $trans->id)
        ->first();

        $potongan = Order::select("vouchers.*")
        ->leftJoin("voucher_details", "orders.voucherdet_id", "=", "voucher_details.id")
        ->leftJoin("vouchers", "voucher_details.voucher_id", "=", "vouchers.id")
        ->where("transaction_id", $trans->id)
        ->where("voucherdet_id", '!=', NULL)
        ->first();


        return view('content.transaksi.detail', compact('saldos','jenis','trans','wilayah','tour','service','retur','ada','transdel','potongan','user'));

    }

    public function getdata(Request $request)
    {

        $trans = Transaksi::where("id", $request->id)
        ->first();

        return response()->json($trans);

    }

    public function validasikadaluarsa(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d', strtotime(' -3 day'));
        $hariini = date('Y-m-d H:i:s');
        $hari = date('Y-m-d');

        $user = Auth::user();

        $trans = Transaksi::where([
            ['created_at', '<', $hariini],
            ['status', '=', 'BELUM BAYAR'],
            ['user_id', '=', $user->id],
        ])
        ->get();

        foreach ($trans as $tran) {

            $datetime1 = $tran->created_at;
            $datetime2 = date('Y-m-d H:i:s', strtotime($datetime1 .' +1 day'));
            
            if(strtotime($hariini) > strtotime($datetime2)){

                $updates = Transaksi::findOrFail($tran->id);
                $updates->status = 'KADALUARSA';
                $updates->save();

            }

        }

        return response()->json($trans);

    }

    public function printexcel(Request $request)
    {
        $user = Auth::user();

        return (new TransactionExcel($request->dari,$request->sampai,$request->type,$user->id))->download('TransactionExcel.xlsx');

    }

    public function invoice(Request $request)
    {

        date_default_timezone_set('Asia/Jakarta');
        $hari = date('Y-m-d');

        // ===========

        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d');

        $detailtransaction = OrderDetails::select("order_details.*","product.name as prod_name", "posts.name as post_name")
        ->leftJoin("posts", "order_details.post_id", "=", "posts.id")
        ->leftJoin("product", "posts.product_id", "=", "product.id")
        ->leftJoin("orders", "order_details.order_id", "=", "orders.id")
        ->where("orders.transaction_id", $request->id)
        ->get();

        $transaction = Transaksi::select("transactions.*","users.name as user_name", "orders.amount","orders.delivery","orders.delivery_name","delivery_type","transactions.alamat_id","wilayah.name as wilayah_name","users.email","orders.type_bayar","orders.diskon","orders.voucherdet_id","vouchers.amount as voucher_amount","vouchers.id as voucherid","vouchers.percent")
        ->leftJoin("orders", "transactions.id", "=", "orders.transaction_id")
        ->leftJoin('users', 'transactions.user_id', '=', 'users.id')
        ->leftJoin('wilayah', 'transactions.wilayah_id', '=', 'wilayah.id')
        ->leftJoin('voucher_details', 'orders.voucherdet_id', '=', 'voucher_details.id')
        ->leftJoin('vouchers', 'voucher_details.voucher_id', '=', 'vouchers.id')
        ->where("orders.transaction_id", $request->id)
        ->first();

        $pdf = PDF::loadView('content.transaksi.invoice', compact('transaction','detailtransaction'))->setPaper('A4','potrait');
        return $pdf->stream();

        // return view('content.transaksi.invoice', compact('invoices'));
    }

    public function upload(Request $request)
    {   
        date_default_timezone_set('Asia/Jakarta');
        $user = Auth::user();

        $validation = Validator::make($request->all(), [
            'file' => 'mimes:jpeg,bmp,png,svg,pdf',
        ]);

        if($validation->passes()) {

            $image = $request->file('file');
            $input['imagename'] = rand() . '.' . $image->getClientOriginalExtension();

            $destinationPath = public_path('assets/img_retur');

            $img = Image::make($image->getRealPath());
            $img->resize(400, 400, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath.'/'.$input['imagename']);

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

    public function uploadktp(Request $request)
    {   
        date_default_timezone_set('Asia/Jakarta');
        $user = Auth::user();

        $validation = Validator::make($request->all(), [
            'file' => 'mimes:jpeg,bmp,png,svg,pdf',
        ]);

        if($validation->passes()) {

            $image = $request->file('file');
            $input['imagename'] = rand() . '.' . $image->getClientOriginalExtension();

            $destinationPath = 'assets/img_ktp';

            $img = Image::make($image->getRealPath());
            $img->resize(400, 400, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath.'/'.$input['imagename']);

            $approve = Users::where('id',$user->id);
            $approve->update(['fotoktp'=>$input['imagename']]);

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

    public function storeretur(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');

        $user = Auth::user();

        $createprod = new TransactionRetur();
        $createprod->transaction_id = $request->id;
        $createprod->img = $request->img;
        $createprod->ket = $request->ket;
        $createprod->status = "DIPROSES";
        $createprod->save();

        return response()->json($createprod);

    }

    public function petugasApprove(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');

        $user = Auth::user();

        $approve = Transaksi::where('uuid',$request->uuid);

        $approve->update(['status'=>'reedem']);

        return response()->json($approve);
    }

    public function supervisorpenjualan()
    {
        date_default_timezone_set('Asia/Jakarta');
        $user = Auth::user();

        $sites = Wilayah::where("active", "Y")
        ->get();

        $hariini = date('Y-m-d');
        $blnawal = date('Y-m-01', strtotime($hariini));
        $blnakhir = date('Y-m-t', strtotime($hariini));

        return view('content.transaksi.supervisor', compact('sites','blnawal','blnakhir'));

    }

    public function datapenjualan(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d');
        $user = Auth::user();
        $blnawal = date('Y-m-01', strtotime($date));
        $blnakhir = date('Y-m-t', strtotime($date));
        $sampai = date('Y-m-d', strtotime( $request->sampai . " +1 days"));

        if($request->wilayah == "all" || $request->wilayah == ""){

            if(strtotime($sampai) > strtotime('2022-02-01')){

                $transaction = Transaksi::select('transactions.*', 'users.name as user_name','users.id as user_id', 'orders.amount', "orders.type_bayar",DB::raw('DATE_FORMAT(transactions.created_at,"%d-%m-%Y %H:%i") as tanggal'),'wilayah.name as wilayah_name')
                ->leftjoin('users', 'transactions.user_id', '=', 'users.id')
                ->leftjoin('orders', 'transactions.id', '=', 'orders.transaction_id')
                ->leftjoin('wilayah', 'transactions.wilayah_id', '=', 'wilayah.id')
                ->where([
                    ['transactions.status', '=', 'APPROVED'],
                    ['transactions.type', '=', 'in'],
                    ['orders.type_bayar', '!=', 'testing'],
                ])
                ->whereBetween('transactions.created_at', [$request->dari, $sampai])
                ->get();

            } else {

                $transaction = Transaksi::select('transactions.*', 'users.name as user_name','users.id as user_id', 'orders.amount', "orders.type_bayar",DB::raw('DATE_FORMAT(transactions.updated_at,"%d-%m-%Y %H:%i") as tanggal'),'wilayah.name as wilayah_name')
                ->leftjoin('users', 'transactions.user_id', '=', 'users.id')
                ->leftjoin('orders', 'transactions.id', '=', 'orders.transaction_id')
                ->leftjoin('wilayah', 'transactions.wilayah_id', '=', 'wilayah.id')
                ->where([
                    ['transactions.status', '=', 'APPROVED'],
                    ['transactions.type', '=', 'in'],
                    ['orders.type_bayar', '!=', 'testing'],
                ])
                ->whereBetween('transactions.updated_at', [$request->dari, $sampai])
                ->get();

            }

        } else {

            if(strtotime($sampai) > strtotime('2022-02-01')){

                $transaction = Transaksi::select('transactions.*', 'users.name as user_name','users.id as user_id', 'orders.amount', "orders.type_bayar",DB::raw('DATE_FORMAT(transactions.created_at,"%d-%m-%Y %H:%i") as tanggal'),'wilayah.name as wilayah_name')
                ->leftjoin('users', 'transactions.user_id', '=', 'users.id')
                ->leftjoin('orders', 'transactions.id', '=', 'orders.transaction_id')
                ->leftjoin('wilayah', 'transactions.wilayah_id', '=', 'wilayah.id')
                ->where([
                    ['transactions.status', '=', 'APPROVED'],
                    ['transactions.type', '=', 'in'],
                    ['transactions.wilayah_id', '=', $request->wilayah],
                    ['orders.type_bayar', '!=', 'testing'],
                ])
                ->whereBetween('transactions.created_at', [$request->dari, $sampai])
                ->get();

            } else {

                $transaction = Transaksi::select('transactions.*', 'users.name as user_name','users.id as user_id', 'orders.amount', "orders.type_bayar",DB::raw('DATE_FORMAT(transactions.updated_at,"%d-%m-%Y %H:%i") as tanggal'),'wilayah.name as wilayah_name')
                ->leftjoin('users', 'transactions.user_id', '=', 'users.id')
                ->leftjoin('orders', 'transactions.id', '=', 'orders.transaction_id')
                ->leftjoin('wilayah', 'transactions.wilayah_id', '=', 'wilayah.id')
                ->where([
                    ['transactions.status', '=', 'APPROVED'],
                    ['transactions.type', '=', 'in'],
                    ['transactions.wilayah_id', '=', $request->wilayah],
                    ['orders.type_bayar', '!=', 'testing'],
                ])
                ->whereBetween('transactions.updated_at', [$request->dari, $sampai])
                ->get();

            }

        }

        return Datatables::of($transaction)->make(true);
    }

    public function viewpenjualan(Request $request)
    {
        $transaction = OrderDetails::select("order_details.*","product.name as prod_name", "posts.name as post_name", "users.name as user_name", "orders.amount as total","orders.delivery","orders.delivery_name","delivery_type","transactions.alamat_id","wilayah.name as wilayah_name",DB::raw('DATE_FORMAT(transactions.updated_at,"%d %M %Y %H:%i") as tanggal'), "transactions.id as trans_id","orders.diskon","vouchers.amount as voucher_amount","voucher_details.kode as vouch_kode","vouchers.percent as voucher_percent","petugas.name as petugas")
        ->leftJoin("posts", "order_details.post_id", "=", "posts.id")
        ->leftJoin("product", "posts.product_id", "=", "product.id")
        ->leftJoin("orders", "order_details.order_id", "=", "orders.id")
        ->leftJoin("transactions", "orders.transaction_id", "=", "transactions.id")
        ->leftJoin("voucher_details", "orders.voucherdet_id", "=", "voucher_details.id")
        ->leftJoin("vouchers", "voucher_details.voucher_id", "=", "vouchers.id")
        ->leftJoin('users', 'transactions.user_id', '=', 'users.id')
        ->leftJoin('wilayah', 'transactions.wilayah_id', '=', 'wilayah.id')
        ->leftJoin('users as petugas', 'transactions.petugas_id', '=', 'petugas.id')
        ->where("transactions.id", $request->transaction_id)
        ->get();

        return response()->json($transaction);

    }

}
