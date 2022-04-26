<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Inboxes;
use App\InboxUsers;
use App\SaldoPoin;
use App\SaldoTransPoin;
use Auth;

class MessagesController extends Controller
{
    public function index()
    {
	    date_default_timezone_set('Asia/Jakarta');
		$date = date('Y-m-d');

		$user = Auth::user();

		$inboxes = Inboxes::where("user_id", $user->id)
		->orWhere("user_id", NULL)
		->orderBy('id', 'desc')
		->get();

		$userid = $user->id;

		return view('content.messages.index', compact('date','inboxes','userid'));

	}


	public function show(Request $request)
    {
	    date_default_timezone_set('Asia/Jakarta');
		$date = date('Y-m-d');

		$user = Auth::user();

		$inbox = Inboxes::where("id", $request->id)
		->first();

		$cek = InboxUsers::where("user_id", $user->id)
		->where("inbox_id", $request->id)
		->first();

		if(!$cek){

			$inb = new InboxUsers();
	        $inb->user_id = $user->id;
	        $inb->inbox_id = $request->id;
	        $inb->save();

		}

		return response()->json($inbox);

	}

	public function super()
    {
	    date_default_timezone_set('Asia/Jakarta');
		$date = date('Y-m-d');

		$user = Auth::user();

		$inbox = Inboxes::where("sampai",'>', $date)
		->where("type", "superurgent")
		->first();

		return response()->json($inbox);

	}

	public function count()
    {
	    date_default_timezone_set('Asia/Jakarta');
		$date = date('Y-m-d');

		$user = Auth::user();

		$inboxes = Inboxes::where("user_id", $user->id)
		->orWhere("user_id", NULL)
		->get();

		$terbaca = InboxUsers::where("user_id",'=', $user->id)
		->get();

		$count = $inboxes->count() - $terbaca->count(); 

		return response()->json($count);

	}

	public function poin(Request $request)
    {
	    date_default_timezone_set('Asia/Jakarta');
		$date = date('Y-m-d');

		$user = Auth::user();

		$trsaldo = new SaldoTransPoin();
        $trsaldo->user_id = $user->id;
        $trsaldo->message_id = $request->id;
        $trsaldo->type = "in";
        $trsaldo->amount = $request->poin;
        $trsaldo->save();

        $saldopoin = SaldoPoin::where("user_id", $user->id)
        ->orderBy("id", "desc")
        ->first();

        $saldonya = new SaldoPoin();
        $saldonya->transpoin_id = $trsaldo->id;
        $saldonya->user_id = $user->id;
        if(!$saldopoin){

            $saldonya->before = '0';
            $saldonya->sisa = $request->poin;

        } else {

            $saldonya->before = $saldopoin->sisa;
            $saldonya->sisa = $request->poin + $saldopoin->sisa;

        }
        $saldonya->save();

		return response()->json($trsaldo);

	}

	public function cekpoin(Request $request)
    {
	    date_default_timezone_set('Asia/Jakarta');
		$date = date('Y-m-d');

		$inbox = Inboxes::where("id", $request->id)
		->first();

		$tigahari = date('Y-m-d', strtotime( $inbox->created_at . " +3 days"));

		$user = Auth::user();

		$cek = SaldoTransPoin::where("user_id", $user->id)
		->where("message_id", $request->id)
        ->first();

        if(strtotime($tigahari) > strtotime($date)){

	        if($cek){

	        	$data = 1;
	        } else {

	        	$data=0;
	        }

	    } else {
	    	$data=2;

	    }

        $transactionz = array(    
            'status' => $data,
        );

		return response()->json($transactionz);

	}
}
