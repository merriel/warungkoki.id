<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Favorite;
use App\Users;
use App\Follow;
use App\UserDaerah;
use App\Wilayah;
use App\Posts;
use App\Regency;
use App\Product;
use App\Kategori;
use App\Transaksi;
use App\TransaksiMission;
use App\Missions;
use App\Rewards;
use App\Hadiahs;
use App\Temporary;
use App\VoucherDetails;
use Auth;
use DB;
use Uuid;
use Mail;
use PDF;

class XMissionController extends Controller
{
    public function index()
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d');

        $user = Auth::user();

        $missions = Missions::where([
            ['dari', '<=', $date],
            ['sampai', '>=', $date],
        ])
        ->get();


        return view('xmission.home.index', compact('date','missions'));

    }

    public function detail(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');

        $mission = Missions::where("uuid", "=", $request->uuid)
        ->first();

        $cekada = Temporary::where('session_id', csrf_token())
        ->first();

        if($cekada){
            $hapus = Temporary::where('id', $cekada->id)
            ->delete();
        }

        return view('xmission.home.detail', compact('mission'));

    }

    public function ikut(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $user = Auth::user();

        $ada = TransaksiMission::where([
            ['user_id', '=', $user->id],
            ['date', '=', date('Y-m-d')],
        ])
        ->first();

        $udahikutan = TransaksiMission::where([
            ['user_id', '=', $user->id],
            ['mission_id', '=', $request->id],
            ['status', '=', "ON PROGRESS"],
        ])
        ->first();

        $banyak = Rewards::leftJoin("transaction_mission", "rewards.transaction_mission_id", "=", "transaction_mission.id")
        ->where([
            ['user_id', '=', $user->id],
            ['mission_id', '=', $request->id],
        ])
        ->get();

        $misi = Missions::where("id", $request->id)
        ->first();

        if($ada){

             $data = 1;

        } else {

            if($udahikutan){

                $data = 2;

            } else {

                if($banyak->count() == $misi->max){

                    $data = 3;

                } else {

                    $uuid = Uuid::generate();
                    $code = substr($uuid,0,8);

                    $trans = new TransaksiMission();
                    $trans->uuid = $code.date('d');
                    $trans->user_id = $user->id;
                    $trans->mission_id = $request->id;
                    $trans->date = date('Y-m-d');
                    $trans->status = 'ON PROGRESS';
                    $trans->save();

                    $data = 0;
                    
                }         

            }       

        }

        return response()->json($data);

    }

    public function count(){

        date_default_timezone_set('Asia/Jakarta');
        $user = Auth::user();

        $ada = TransaksiMission::where([
            ['user_id', '=', $user->id],
            ['status', '=', 'ON PROGRESS'],
        ])
        ->get();

        $mission = $ada->count();

        return response()->json($mission);

    }

    public function countreward(){

        date_default_timezone_set('Asia/Jakarta');
        $user = Auth::user();

        $ada = Rewards::select("rewards.*")
        ->leftJoin("transaction_mission", "rewards.transaction_mission_id", "=", "transaction_mission.id")
        ->where([
            ['transaction_mission.user_id', '=', $user->id],
            ['rewards.status', '!=', 'SELESAI'],
        ])
        ->get();

        $mission = $ada->count();

        return response()->json($mission);

    }

    public function proses()
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d');

        $user = Auth::user();

        $missions = TransaksiMission::select("missions.*","transaction_mission.date","transaction_mission.uuid as transuuid")
        ->leftJoin("missions", "transaction_mission.mission_id", "=", "missions.id")
        ->where([
            ['user_id', '=', $user->id],
            ['transaction_mission.status', '=', 'ON PROGRESS'],
        ])
        ->get();


        return view('xmission.proses.index', compact('date','missions'));

    }

    public function prosesdetail(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');

        $mission = TransaksiMission::select("missions.*","transaction_mission.date","transaction_mission.uuid as transuuid")
        ->leftJoin("missions", "transaction_mission.mission_id", "=", "missions.id")
        ->where([
            ['transaction_mission.uuid', '=', $request->uuid],
            ['transaction_mission.status', '=', 'ON PROGRESS'],
        ])
        ->first();

        return view('xmission.proses.detail', compact('mission'));

    }

    public function approve(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $user = Auth::user();

        $cek = TransaksiMission::where([
            ['transaction_mission.user_id', '=', $user->id],
            ['transaction_mission.status', '=', 'ON PROGRESS'],
        ])
        ->first();

        if(!$cek){

            $data = 0;

            $sudahtour = TransaksiMission::where(['id'=>$request->id])
            ->update(['status'=>'SELESAI', 'wilayah_id'=>$user->wilayah_id]);

            $mission = TransaksiMission::select("missions.*")
            ->leftJoin("missions", "transaction_mission.mission_id", "=", "missions.id")
            ->where("transaction_mission.id", $request->id)
            ->first();

            $uuid = Uuid::generate();
            $code = substr($uuid,0,8);

            $trans = new Rewards();
            $trans->uuid = $code.date('d');
            $trans->transaction_mission_id = $request->id;
            $trans->status = 'BELUM DI CLAIM';
            $trans->dari = $mission->reward_dari;
            $trans->sampai = $mission->reward_sampai;
            $trans->save();

        } else {

            $data = 1;

        }

        return response()->json($data);

    }

    public function reward()
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d');

        $user = Auth::user();

        $rewards = Rewards::select("transaction_mission.*","rewards.hadiah_id","rewards.id as reward_id","missions.name as mission_name","hadiah.name as hadiah_name","rewards.uuid as rewarduuid","rewards.sampai as sampaireward")
        ->leftJoin("transaction_mission", "rewards.transaction_mission_id", "=", "transaction_mission.id")
        ->leftJoin("missions", "transaction_mission.mission_id", "=", "missions.id")
        ->leftJoin("hadiah", "rewards.hadiah_id", "=", "hadiah.id")
        ->where([
            ['transaction_mission.user_id', '=', $user->id],
            ['rewards.status', '!=', 'SELESAI'],
        ])
        ->get();

        return view('xmission.rewards.index', compact('rewards'));

    }

    public function rewarddetail(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');

        $rewards = Rewards::select("transaction_mission.*","rewards.hadiah_id","rewards.id as reward_id","missions.name as mission_name","hadiah.name as hadiah_name","rewards.uuid as rewarduuid")
        ->leftJoin("transaction_mission", "rewards.transaction_mission_id", "=", "transaction_mission.id")
        ->leftJoin("missions", "transaction_mission.mission_id", "=", "missions.id")
        ->leftJoin("hadiah", "rewards.hadiah_id", "=", "hadiah.id")
        ->where([
            ['rewards.uuid', '=', $request->uuid],
            ['rewards.status', '!=', 'SELESAI'],
        ])
        ->first();

        return view('xmission.rewards.detail', compact('rewards'));

    }

    public function claim(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $user = Auth::user();

        $cek = Rewards::leftJoin("transaction_mission", "rewards.transaction_mission_id", "=", "transaction_mission.id")
        ->where([
            ['transaction_mission.user_id', '=', $user->id],
            ['rewards.status', '=', 'SELESAI'],
        ])
        ->first();

        if(!$cek){

            $data=0;

            $sudahtour = Rewards::where(['id'=>$request->id])
            ->update(['status'=>'SELESAI', 'wilayah_id'=>$user->wilayah_id]);

            $claim = Rewards::select("users.email","hadiah.name as hadiah_name","users.name as user_name","missions.name as mission_name","rewards.updated_at","wilayah.name as wilayah_name")
            ->leftJoin("transaction_mission", "rewards.transaction_mission_id", "=", "transaction_mission.id")
            ->leftJoin("users", "transaction_mission.user_id", "=", "users.id")
            ->leftJoin("hadiah", "rewards.hadiah_id", "=", "hadiah.id")
            ->leftJoin("missions", "transaction_mission.mission_id", "=", "missions.id")
            ->leftJoin("wilayah", "rewards.wilayah_id", "=", "wilayah.id")
            ->where("rewards.id", $request->id)
            ->first();

            $emails = $claim->email;

            try{
                Mail::send('email.claimhadiah', ['claim' => $claim], function ($message) use ($emails)
                {
                    $message->subject('Anda Berhasil Claim Reward dari Tomxperience.id!');
                    $message->from('admin@tomxperience.id', 'Admin Tomxperience.id');
                    $message->to($emails);
                });

            }
            catch (Exception $e){
                return response (['status' => false,'errors' => $e->getMessage()]);
            }

        } else {

            $data=1;

        }

        return response()->json($data);

    }

    public function hadiah(Request $request)
    {

        date_default_timezone_set('Asia/Jakarta');


        if($request->voucher == "no"){

            for ($i=0; $i <20 ; $i++) { 
            
                $trans = new Hadiahs();
                $trans->name = "Kopiko 78C Coffe Latte 240 ml";
                $trans->img = "kopiko.jpg";
                $trans->save();

            }

        } else {

            for ($i=0; $i <3 ; $i++) { 

                $uuid = Uuid::generate();
                $code = substr($uuid,0,8);
            
                $hadiah = new Hadiahs();
                $hadiah->name = "Voucher Fuels Rp. 10.000";
                $hadiah->img = "voucher10.jpg";
                $hadiah->type = "voucher";
                $hadiah->save();

                $mission = Missions::where('id', 1)
                ->first();

                $savedetail = new VoucherDetails();
                $savedetail->company_id = 1;
                $savedetail->voucher_id = '4';
                $savedetail->hadiah_id = $hadiah->id;
                $savedetail->mission_id = '1';
                $savedetail->kode = $code.'22';
                $savedetail->date = date('Y-m-d');
                $savedetail->dari = $mission->reward_dari;
                $savedetail->sampai = $mission->reward_sampai;
                $savedetail->save();

            }

        }

        


    }

    public function games(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');

        $hadiah =  Hadiahs::inRandomOrder()
        ->where([
            ['status', null],
            ['type', null],
        ])
        ->limit(12) // here is yours limit
        ->get();

        $uuid = $request->uuid;

        return view('xmission.rewards.games', compact('hadiah','uuid'));

    }

    public function gethadiah(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $user = Auth::user();

        $sudahtour = Hadiahs::where(['id'=>$request->id])
        ->update(['status'=>'SELESAI']);

        $sudahtourss = Rewards::where(['uuid'=>$request->uuid])
        ->update(['hadiah_id'=>$request->id]);

        $hadiah = Hadiahs::where('id', $request->id)
        ->first();

        $cek = Rewards::select("transaction_mission.mission_id")
        ->leftJoin("transaction_mission", "rewards.transaction_mission_id", "=", "transaction_mission.id")
        ->where("rewards.uuid", $request->uuid)
        ->first();

        $mission = Missions::where('id', $cek->mission_id)
        ->first();

        $emails = $user->email;

        try{
            Mail::send('email.dapathadiah', ['nama' => $user->name, 'hadiah' => $hadiah->name, 'mission' => $mission], function ($message) use ($emails)
            {
                $message->subject('Anda Mendapatkan Hadiah dari Tomxperience.id!');
                $message->from('admin@tomxperience.id', 'Admin Tomxperience.id');
                $message->to($emails);
            });

        }
        catch (Exception $e){
            return response (['status' => false,'errors' => $e->getMessage()]);
        }
        
        return response()->json($hadiah->name);


    }

    public function voucher(Request $request)
    {

        date_default_timezone_set('Asia/Jakarta');
        $user = Auth::user();

        $cek = VoucherDetails::where("kode", $request->kode)
        ->first();

        if($cek){

            if($cek->status == "selesai"){

                $data = 1;

            } else {

                $data = 2;

                $sudahtour = VoucherDetails::where(['id'=>$cek->id])
                ->update(['status'=>'selesai']);

                $uuid = Uuid::generate();
                $code = substr($uuid,0,8);

                $transmis = new TransaksiMission();
                $transmis->uuid = $code.date('d');
                $transmis->user_id = $user->id;
                $transmis->mission_id = $cek->mission_id;
                $transmis->date = date('Y-m-d');
                $transmis->status = 'SELESAI';
                $transmis->save();

                $mission = Missions::where('id', $cek->mission_id)
                ->first();

                $rew = new Rewards();
                $rew->uuid = $cek->kode;
                $rew->transaction_mission_id = $transmis->id;
                $rew->hadiah_id = $cek->hadiah_id;
                $rew->status = 'BELUM DI CLAIM';
                $rew->dari = $mission->reward_dari;
                $rew->sampai = $mission->reward_sampai;
                $rew->save();

                $sudahtour = Hadiahs::where(['id'=>$cek->hadiah_id])
                ->update(['status'=>'SELESAI']);

                $hadiah = Hadiahs::where("id", $cek->hadiah_id)
                ->first();

                $emails = $user->email;

                try{
                    Mail::send('email.dapathadiah', ['nama' => $user->name, 'hadiah' => $hadiah->name, 'mission' => $mission], function ($message) use ($emails)
                    {
                        $message->subject('Anda Mendapatkan Hadiah dari Tomxperience.id!');
                        $message->from('admin@tomxperience.id', 'Admin Tomxperience.id');
                        $message->to($emails);
                    });

                }
                catch (Exception $e){
                    return response (['status' => false,'errors' => $e->getMessage()]);
                }

            }

        } else {

            $data = 0;

        }


        return response()->json($data);

    }

    public function cetak(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d');

        $vouchers = VoucherDetails::select("voucher_details.*")
        ->join("vouchers", "voucher_details.voucher_id", "=", "vouchers.id")
        ->where('vouchers.id', $request->id)
        ->limit(30)
        ->get();

        $pdf = PDF::loadView('xmission.home.pdf', compact('vouchers'))->setPaper('A4','landscape');
        return $pdf->stream();
    }

    public function datahadiah(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');

        $hadiah = Hadiahs::select("name")
        ->distinct()
        ->get();

        return view('content.datahadiah.index', compact('hadiah'));

    }

    public function reedemmission(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $user = Auth::user();

        if($user->role_id == 5){

            $missions = Rewards::selectRaw('DATE(created_at) as date')
            ->where([
                ['wilayah_id', $user->wilayah_id],
                ['status', 'SELESAI'],
            ])
            ->distinct()
            ->orderBy("updated_at","desc")
            ->get();       

        } else {

            $missions = Rewards::selectRaw('DATE(created_at) as date')
            ->where('status', 'SELESAI')
             ->distinct()
            ->orderBy("updated_at","desc")
            ->get();

        }    

        return view('content.home.outlet.reedemmission', compact('missions'));

    }

}
