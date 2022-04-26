<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Users;
use App\Province;
use App\Regency;
use App\UserDaerah;
use App\Posts;
use App\Wilayah;
use Auth;
use App\Temporary;
use Mail;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function loginUser(Request $request)
    {

        $userc = Users::select('role_id','email_verified_at')
        ->where('email', $request->username)
        ->first();

        // Attempt Login for members
        if (Auth::guard('user')->attempt(['email' => $request->username, 'password' => $request->password], $request->remember)) {

            $msg = array(
                'role' => $userc->role_id,
                'status' => 'success',
                'email_confirm' => $userc->email_verified_at,
            );

            return response()->json($msg);

        } else {

            $msg = array(
                'status'  => 'error',
            );

            return response()->json($msg);
        }
    }

    public function logout(Request $request)
    {
        Auth::guard('user')->logout();

        return redirect()->guest(route('login.user'));
    }

    public function showLoginForm()
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d');

        $productnews = Posts::select("posts.*","imgpost.name as imgname","regencies.name as regency_name", "wilayah.name as wilayah_name","wilayah.id as wilayah_id")
        ->leftJoin("post_images", "posts.id", "=", "post_images.post_id")
        ->leftJoin("imgpost", "post_images.img_id", "=", "imgpost.id")
        ->leftJoin("users", "posts.user_id", "=", "users.id")
        ->leftJoin("wilayah", "users.wilayah_id", "=", "wilayah.id")
        ->leftJoin("regencies", "wilayah.regency_id", "=", "regencies.id")
        ->where('type', '=', 'Products')
        ->orWhere([
            ['sampai', '>=', $date],
            ['type', '=', 'Deals'],
        ])
        ->orderBy('posts.id', 'desc')
        ->get();

        $companies = Wilayah::select("wilayah.*", "company.photo","regencies.name as regency_name")
        ->join("company", "wilayah.company_id", "=", "company.id")
        ->join("regencies", "wilayah.regency_id", "=", "regencies.id")
        ->orderBy('id', 'desc')
        ->limit(8)
        ->get();

        $provinces = Province::all();

        return view('content.home.index', compact('date','companies','productnews','provinces'));

        // return view('login.index');
    }

    public function showRegisterForm()
    {
        $provinces = Province::all();

        return view('register.index', compact('provinces'));
    }

    public function ambilkabkot(Request $request)
    {

        $regencies = Regency::where("province_id", $request->id)
        ->get();

        return response()->json($regencies);

    }

    public function showConfirmationInfo()
    {

        return view('login.confirm');
    }

    public function register(Request $request)
    {

        $registrasi = new Users();
        $registrasi->name = $request->nama;
        $registrasi->email = $request->email;
        $registrasi->no_hp = $request->nohp;
        $registrasi->password = Hash::make($request->password);
        $registrasi->role_id = '4';
        $registrasi->token = $request->token;
        $registrasi->clubsmart = $request->clubsmart;
        $registrasi->save();

        $wilayah = new UserDaerah();
        $wilayah->user_id = $registrasi->id;
        $wilayah->regency_id = $request->kabkot;
        $wilayah->save();


        $default = 'UtjasdkjOP09jOl3NlGipaert78PqKoL4dTwER';
        $id = $registrasi->id.$default;
        $url = url('/confirmations', [$id]);

        try{
            Mail::send('email.index', ['nama' => $request->nama, 'url' => $url], function ($message) use ($request)
            {
                $message->subject('Aktifasi Akun IOLO-SMART');
                $message->from('admin@iolosmart.com', 'Admin Iolo-Smart');
                $message->to($request->email);
            });
            return back()->with('alert-success','Berhasil Kirim Email');
        }
        catch (Exception $e){
            return response (['status' => false,'errors' => $e->getMessage()]);
        }

    }

    public function konfirmasi($id)
    {

        date_default_timezone_set('Asia/Jakarta');
        $fulltime = date('Y-m-d H:i:s');

        $potong = str_replace("UtjasdkjOP09jOl3NlGipaert78PqKoL4dTwER","",$id);

        $keranjang = Users::where(['id'=>$potong])
        ->update(['email_verified_at'=>$fulltime]);

        return redirect()->guest(route('login.confirm'));

    }

    public function loginscan(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');

        $user = Auth::user();
        
        if(!$user){

            $cekada = Temporary::where('session_id', csrf_token())
            ->first();

            if(!$cekada){

                $tour = new Temporary();
                $tour->session_id = csrf_token();
                $tour->action = $request->action;
                $tour->type = $request->type;
                $tour->save();

            } else {

                $absensiout = Temporary::where(['session_id'=>csrf_token()])
                ->update(['action'=>$request->action, 'type'=>$request->type]);
            }

            return redirect('/');

        } else {

            if($request->type == 'mission'){

                if($request->action == 0){

                    return redirect('/xmission/');

                } else {

                    return redirect('/xmission/detail?uuid='.$request->action.'');

                }

            } else if($request->type == "wilayah"){

                $wil = Wilayah::where("uuid", $request->action)
                ->first();

                $updatec = Users::where(['id'=>$user->id])
                ->update(['wilayah_id'=> $wil->id]);

                return redirect('/home');

            } else if($request->type == "produk"){

                $cekprod = Posts::select("users.wilayah_id")
                ->leftJoin("users", "posts.user_id", "=", "users.id")
                ->where("posts.id", $request->action)
                ->first();

                $updatec = Users::where(['id'=>$user->id])
                ->update(['wilayah_id'=> $cekprod->wilayah_id]);

                return redirect('/users/detail/'.$request->action);


            } else {

                return redirect('/home');

            }         

        }

    }

    public function intro(Request $request)
    {

        $aksi = $request->action;

        return view('intro.drivethru', compact('aksi'));
    }

}
