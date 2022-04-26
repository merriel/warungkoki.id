<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Wilayah;
use App\WSRoom;
use App\WSDesk;
use App\Users;
use App\WSTransaksi;
use App\WSOrder;
use App\WSTimes;
use App\WSImages;
use Auth;
use DataTables;
use View;
use Hash;
use Uuid;

class WorkingSpaceController extends Controller
{
    public function index()
    {
    	date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d');

        $user = Auth::user();

        $rooms = WSRoom::select("ws-room.*","regencies.name as regency_name","wilayah.name as wilayah_name","wilayah.alamat")
        ->leftJoin("wilayah", "ws-room.wilayah_id", "=", "wilayah.id")
        ->leftJoin("regencies", "wilayah.regency_id", "=", "regencies.id")
        ->get();

        return view('working-space.home.index', compact('date','rooms','user'));

    }

    public function detail(Request $request)
    {
    	date_default_timezone_set('Asia/Jakarta');

    	$detailroom = WSRoom::select("ws-room.*","regencies.name as regency_name","wilayah.name as wilayah_name","wilayah.alamat")
        ->leftJoin("wilayah", "ws-room.wilayah_id", "=", "wilayah.id")
        ->leftJoin("regencies", "wilayah.regency_id", "=", "regencies.id")
        ->where("ws-room.uuid", $request->uuid)
        ->first();

        $images = WSImages::where("room_id", $detailroom->id)
        ->get();

        return view('working-space.home.detail', compact('detailroom','images'));

    }

    public function booked(Request $request)
    {
    	date_default_timezone_set('Asia/Jakarta');
    	$date = date('Y-m-d');

    	$detailroom = WSRoom::select("ws-room.*","regencies.name as regency_name","wilayah.name as wilayah_name","wilayah.alamat")
        ->leftJoin("wilayah", "ws-room.wilayah_id", "=", "wilayah.id")
        ->leftJoin("regencies", "wilayah.regency_id", "=", "regencies.id")
        ->where("ws-room.uuid", $request->uuid)
        ->first();

        return view('working-space.home.booked', compact('detailroom','date'));

    }

    public function caridesk(Request $request)
    {
    	date_default_timezone_set('Asia/Jakarta');

    	if($request->type == 'hour'){

	    	$cari = WSTransaksi::select("ws-transaksi.desk_id")
	    	->leftJoin("ws-desk", "ws-transaksi.desk_id", "=", "ws-desk.id")
	    	->leftJoin("ws-room", "ws-desk.room_id", "=", "ws-room.id")
	    	->leftJoin("ws-times", "ws-transaksi.id", "=", "ws-times.trans_id")
	    	->where([
	            ['ws-desk.room_id', '=', $request->room_id],
	            ['date', '=', $request->tanggal],
	            ['ws-times.time', 'LIKE', substr($request->dari,0,2).'%'],
	        ])
	        ->orWhere([
	            ['ws-desk.room_id', '=', $request->room_id],
	            ['date', '=', $request->tanggal],
	            ['ws-times.time', '=', substr($request->dari,0,2).'%'],
	        ])
	        ->get();

	    } else {

	    	$cari = WSTransaksi::select("ws-transaksi.desk_id")
	    	->leftJoin("ws-desk", "ws-transaksi.desk_id", "=", "ws-desk.id")
	    	->leftJoin("ws-room", "ws-desk.room_id", "=", "ws-room.id")
	    	->leftJoin("ws-times", "ws-transaksi.id", "=", "ws-times.trans_id")
	    	->where([
	            ['ws-desk.room_id', '=', $request->room_id],
	            ['date', '=', $request->tanggal],
	        ])
	        ->get();

	    }

        return response()->json($cari);


    }

    public function pilih(Request $request)
    {
    	date_default_timezone_set('Asia/Jakarta');

    	$desk = WSDesk::where("id", $request->id)
        ->first();

        return response()->json($desk);

    }

    public function total(Request $request)
    {
    	date_default_timezone_set('Asia/Jakarta');

    	$room = WSRoom::where('id', $request->room_id)
    	->first();

    	if($request->type == 'day'){

    		$total = $room->harga_day;

    	} else {

    		$awal  = date_create($request->dari);
    		$akhir  = date_create($request->sampai);

    		$diff  = date_diff( $awal, $akhir );
    		$jam = $diff->h;
            $menit = $diff->i;

            if($menit > 0){

                $jam2 = $jam + 1;

            } else {

                $jam2 = $jam;

            }

    		$total = $jam2 * $room->harga_hour;

    	}

    	return response()->json($total);

    }

    public function __construct(Request $request)
    {
        $this->request = $request;
 
        // Set midtrans configuration
        \Midtrans\Config::$serverKey = config('services.midtrans.serverKey');
        \Midtrans\Config::$isProduction = config('services.midtrans.isProduction');
        \Midtrans\Config::$isSanitized = config('services.midtrans.isSanitized');
        \Midtrans\Config::$is3ds = config('services.midtrans.is3ds');

    }

    public function order()
    {

        date_default_timezone_set('Asia/Jakarta');
        $dates = date('d');

        \DB::transaction(function(){
            // Save donasi ke database
            $user = Auth::user();

            $uuid = Uuid::generate();
            $code = substr($uuid,0,8);

            $trans = new WSTransaksi();
            $trans->uuid = $code.date('d');
            $trans->user_id = $user->id;
            $trans->desk_id = $this->request->desk_id;
            $trans->date = $this->request->date;
            $trans->dari = $this->request->dari;
            $trans->sampai = $this->request->sampai;
            $trans->type = $this->request->type;
            $trans->status = 'BELUM DIBAYAR';
            $trans->save();

            $getroom = WSRoom::select('ws-room.*','ws-desk.desk_code')
            ->leftJoin("ws-desk", "ws-room.id", "=", "ws-desk.room_id")
            ->where('ws-desk.id', $this->request->desk_id)
            ->first();

            $awal  = date_create($this->request->dari);
    		$akhir  = date_create($this->request->sampai);

    		$diff  = date_diff( $awal, $akhir );
    		$jam = $diff->h;

           if($this->request->type == 'hour'){
           		$harga = $getroom->harga_hour;
           		$qty = $jam;

           		$dr = intval(substr($this->request->dari, 0,2));
           		$smp = intval(substr($this->request->sampai, 0,2));

           		for ($x = $dr; $x < $smp; $x++) {

           			if(strlen($x) == 1){
           				$jam = '0'.$x.':00';
           			} else {
           				$jam = $x.':00';
           			}
				  
           			$times = new WSTimes();
		            $times->trans_id = $trans->id;
		            $times->time = $jam;
		            $times->save();

				}


           } else {
           		$harga = $getroom->harga_day;
           		$qty = '1';

           		$dr = intval(substr($getroom->open, 0,2));
           		$smp = intval(substr($getroom->close, 0,2));

           		for ($x = $dr; $x < $smp; $x++) {

           			if(strlen($x) == 1){
           				$jam = '0'.$x.':00';
           			} else {
           				$jam = $x.':00';
           			}
				  
           			$times = new WSTimes();
		            $times->trans_id = $trans->id;
		            $times->time = $jam;
		            $times->save();

				}

           }

           	$orders = new WSOrder();
            $orders->uuid = $uuid;
            $orders->transaction_id = $trans->id;
            $orders->type_bayar = 'ONLINE';
            $orders->amount = $this->request->amount;
            $orders->status = 'pending';
            $orders->save();
 
            // Buat transaksi ke midtrans kemudian save snap tokennya.
            $payload = [
                'transaction_details' => [
                    'order_id'      => $code.date('d'),
                    'gross_amount'  => $this->request->amount,
                ],
                'customer_details' => [
                    'first_name'    => $user->name,
                    'email'         => $user->email,
                    // 'phone'         => '08888888888',
                    // 'address'       => '',
                ],
                'item_details' => [
                    [
                        'id'       => $getroom->uuid,
                        'price'    => $harga,
                        'quantity' => $qty,
                        'name'     => ucwords(str_replace('_', ' ', $getroom->desk_code))
                    ]
                ]
            ];

            $snapToken = \Midtrans\Snap::getSnapToken($payload);
            $orders->snap_token = $snapToken;
            $orders->save();
 
            // Beri response snap token
            $this->response['snap_token'] = $snapToken;
        });
 
        return response()->json($this->response);
    }


    public function history()
    {
    	date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d');

        $user = Auth::user();

        $transaksis = WSTransaksi::select("ws-transaksi.*","users.name as username","users.email","ws-orders.amount","wilayah.alamat","ws-room.room_name","ws-desk.desk_code","regencies.name as regency_name")
        ->leftJoin("ws-orders", "ws-transaksi.id", "=", "ws-orders.transaction_id")
        ->leftJoin("ws-desk", "ws-transaksi.desk_id", "=", "ws-desk.id")
        ->leftJoin("ws-room", "ws-desk.room_id", "=", "ws-room.id")
        ->leftJoin("wilayah", "ws-room.wilayah_id", "=", "wilayah.id")
        ->leftJoin("regencies", "wilayah.regency_id", "=", "regencies.id")
        ->leftJoin("users", "ws-transaksi.user_id", "=", "users.id")
        ->where("ws-transaksi.user_id", $user->id)
        ->orderBy("ws-transaksi.id", "desc")
        ->get();

        return view('working-space.history.index', compact('date','user','transaksis'));

    }

    public function detailtransaksi(Request $request)
    {

    	$barcode = WSTransaksi::where("uuid", $request->uuid)
    	->first();

    	return view('working-space.history.detail', compact('barcode'));

    }
}
