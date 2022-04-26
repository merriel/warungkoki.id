<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Socialite;
use Auth;
use Exception;
use App\User;
use App\Posts;
use App\Tours;
use App\Users;
use App\Temporary;
use App\UserDaerah;
use App\Wilayah;
use App\Transaksi;
use App\UserMembers;
use App\SaldoTransPoin;
use App\SaldoPoin;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function redirectToGoogle(Request $request)
    {
        return Socialite::driver('google')->redirect();
    }
   
    public function handleGoogleCallback()
    {
        try {
  
            $user = Socialite::driver('google')->user();
   
            $finduser = User::where('google_id', $user->id)->first();
   
            if($finduser){

                $cekuser= Users::where("email", substr(csrf_token(),0,7).'@gmail.com')
                ->first();

                if(!$cekuser){
   
                    Auth::login($finduser);

                    $cekada = Temporary::where('session_id', csrf_token())
                    ->first();

                    if(!$cekada){

                        return redirect('/');

                    } else {

                        if($cekada->type == "grab"){

                            return redirect('/promo/'.$cekada->action.'');

                        } else if($cekada->type == "wilayah"){

                            $wil = Wilayah::where("uuid", $cekada->action)
                            ->first();

                            $updatec = Users::where(['id'=>$finduser->id])
                            ->update(['wilayah_id'=> $wil->id]);

                            return redirect('/home');

                        } else if($cekada->type == "produk"){

                            $cekprod = Posts::select("users.wilayah_id")
                            ->leftJoin("users", "posts.user_id", "=", "users.id")
                            ->where("posts.id", $cekada->action)
                            ->first();

                            $updatec = Users::where(['id'=>$finduser->id])
                            ->update(['wilayah_id'=> $cekprod->wilayah_id]);

                            return redirect('/users/detail/'.$cekada->action);

                        } else {

                            return redirect('/home');

                        }

                    }

                } else {

                    Auth::login($finduser);

                    $cektransaksi1 = Transaksi::where("user_id", $cekuser->id)
                    ->orderBy("id", "desc")
                    ->first();

                    $updatez = Transaksi::where(['id'=>$cektransaksi1->id])
                    ->update(['user_id'=> $finduser->id]);

                    $updatez44 = Users::where(['id'=>$finduser->id])
                    ->update(['role_id'=> 4]);

                    $updatezccc = SaldoTransPoin::where(['transaction_id'=>$cektransaksi1->id])
                    ->update(['user_id'=> $finduser->id]);

                    $saldotrans = SaldoTransPoin::where("transaction_id", $cektransaksi1->id)
                    ->first();

                    $saldopoin = SaldoPoin::where("user_id", $finduser->id)
                    ->orderBy("id", "desc")
                    ->first();

                    $updatezzz = SaldoPoin::where(['transpoin_id'=>$saldotrans->id])
                    ->update([
                        'user_id'=> $finduser->id,
                        'before'=> $saldopoin->sisa, 
                        'sisa'=> $saldopoin->sisa + $saldotrans->amount, 
                    ]);

                    return redirect('/home');
                }
                
            } else {

                $cekuser= Users::where("email", substr(csrf_token(),0,7).'@gmail.com')
                ->first();

                if($cekuser){

                    $cektransaksi1 = Transaksi::where("user_id", $cekuser->id)
                    ->orderBy("id", "desc")
                    ->first();

                    $updatez = Users::where(['id'=>$cekuser->id])
                    ->update(['name'=> $user->name, 'email'=> $user->email, 'google_id'=> $user->id, 'wilayah_id'=> $cekuser->wilayah_id, 'token'=> '123456', 'guide'=> '1', 'wilayah_id' => $cektransaksi1 ? $cektransaksi1->wilayah_id : NULL]);

                    $userx = User::where('id',$cekuser->id)->first();

                    // ===== DAFTAR KE PETUGAS MEMBER ====

                    $cektransaksi = Transaksi::where("user_id", $userx->id)
                    ->orderBy("id", "desc")
                    ->first();

                    $cekmember = UserMembers::where("member_id", $userx->id)
                    ->first();

                    if(!$cekmember){

                        $create = new UserMembers();
                        $create->member_id = $userx->id;
                        $create->user_id = $cektransaksi->petugas_id;
                        $create->transaction_id = $cektransaksi->id;
                        $create->save();

                    }

                    // ==== SELESAI ===

                    Auth::login($userx);

                    return redirect('/home');

                } else {

                    $newUser = new Users();
                    $newUser->name = $user->name;
                    $newUser->email = $user->email;
                    $newUser->google_id = $user->id;
                    $newUser->role_id = '4';
                    $newUser->save();

                    $tournya = new Tours();
                    $tournya->user_id = $newUser->id;
                    $tournya->save();

                    $userx = User::where('id', $newUser->id)->first();

                    Auth::login($userx);

                    $cekada = Temporary::where('session_id', csrf_token())
                    ->first();

                    if(!$cekada){

                        return redirect('/');

                    } else {

                        if($cekada->type == "grab"){

                            return redirect('/promo/'.$cekada->action.'');

                        } else if($cekada->type == "wilayah"){

                            $wil = Wilayah::where("uuid", $cekada->action)
                            ->first();

                            $updatec = Users::where(['id'=>$userx->id])
                            ->update(['wilayah_id'=> $wil->id]);

                            return redirect('/home');

                        } else if($cekada->type == "produk"){

                            $cekprod = Posts::select("users.wilayah_id")
                            ->leftJoin("users", "posts.user_id", "=", "users.id")
                            ->where("posts.id", $cekada->action)
                            ->first();

                            $updatec = Users::where(['id'=>$newUser->id])
                            ->update(['wilayah_id'=> $cekprod->wilayah_id, 'token' => '123456', 'guide' => '1']);

                            return redirect('/users/detail/'.$cekada->action);

                        } else {

                            return redirect('/home');

                        }

                    }

                }

            }
  
        } catch (Exception $e) {

            return redirect('auth/google');
            
        }
    }


    public function login2(Request $request)
    {   

        date_default_timezone_set('Asia/Jakarta');
        $usernyah = Auth::user();

        if(!$usernyah){
            $user = Users::where("email", substr(csrf_token(),0,7).'@gmail.com')
            ->first();
        } else {
            $user = Auth::user();
        }

        $cek = Users::where("id", $user->id)
        ->first();
        

        if(auth()->attempt(array('email' => $cek->email, 'password' =>  'grab')))
        {
            return redirect()->route('homes');
        }else{
            return redirect()->route('login')
                ->with('error','Email-Address And Password Are Wrong.');
        }
          
    }


}
