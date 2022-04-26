<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Follow;
use App\Users;
use App\Transaksi;
use App\Kategori;
use App\Alamat;
use App\Tours;
use App\SaldoUang;
use App\SaldoPoin;
use App\Services;
use App\Banners;
use App\UndianVouchers;
use App\Posts;
use App\Favorite;
use Auth;
use DB;
use Hash;

class BelumloginController extends Controller
{
    public function index(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d');
        $hariini = date('Y-m-d H:i:s');
        $hari = date('Y-m-d');

        $usernyah = Auth::user();

        if(!$usernyah){

            $cek = Users::where("email", substr(csrf_token(),0,7).'@gmail.com')
            ->first();

            if(!$cek){

                $tour = new Users();
                $tour->email = substr(csrf_token(),0,7).'@gmail.com';
                $tour->wilayah_id = 3;
                $tour->role_id = 9;
                $tour->name = "Pelanggan";
                $tour->password = Hash::make('belumlogin');
                $tour->save();

            } 

        }  else {

            return redirect('/home');

        }

        if(!$usernyah){
            $user = Users::where("email", substr(csrf_token(),0,7).'@gmail.com')
            ->first();
        } else {
            $user = Auth::user();
        }

        $iduser = $user->id;

        $roles = Users::select("role_id")
        ->where("id", $user->id)
        ->first();

        $ada = Follow::where("user_id", $iduser)
        ->count();

        // ===CEK KADALUARSA ===

        $trans = Transaksi::where([
            ['created_at', '<', $hariini],
            ['status', '=', 'BELUM BAYAR'],
            ['user_id', '=', $user->id],
        ])
        ->orWhere([
            ['created_at', '<', $hariini],
            ['status', '=', 'NOT APPROVED'],
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

        // === KATEGORI BBM ===

        $kategori = Kategori::where("type", null)->get();

        $reedems = Transaksi::where([
            ['user_id', '=', $user->id],
            ['retailer_id', '=', NULL],
        ])
        ->whereIn('status', ['REEDEM','BELUM BAYAR'])
        ->orderBy("transactions.id","desc")
        ->get();

        $toko = Users::select("wilayah.*","company.photo","regencies.name as regency_name")
        ->join("wilayah", "users.wilayah_id", "=", "wilayah.id")
        ->join("company", "wilayah.company_id", "=", "company.id")
        ->join("regencies", "wilayah.regency_id", "=", "regencies.id")
        ->where("users.id", $user->id)
        ->first();

        $alamat = Alamat::where([
            ['user_id', '=', $user->id],
            ['utama', '=', 'yes'],
        ])
        ->first();

        $sudahtour = Tours::where("user_id", $user->id)
        ->first();

        if(!$sudahtour){

            $tour = new Tours();
            $tour->user_id = $user->id;
            $tour->home = '1';
            $tour->save();

        }

        $cekout = Transaksi::where([
            ["user_id", '=', $user->id],
            ['status', '=', 'REEDEM'],
        ])
        ->first();

        $saldouang = SaldoUang::where("user_id", $user->id)
        ->orderBy("id", "desc")
        ->first();

        $service = Services::where('type', 'midtrans')
        ->first();

        if($user->pemegangsaham == 'yes'){

            $pemegangsaham = Services::where('type', 'pemegangsaham')
            ->first();

            $diskon = $pemegangsaham->biaya;

        } else {

            $diskon = 0;

        }

        if($toko){

            if($alamat){

                $dist = GetDrivingDistance($toko->lat,$alamat->lat,$toko->long,$alamat->long);

                $distance = $dist['distance'];
                $time = $dist['time'];

            } else {

                $distance = 0;
                $time = 0;

            }

        } else {

            $distance = 0;
            $time = 0;

        }

        $saldopoin = SaldoPoin::where("user_id", $user->id)
        ->orderBy("id", "desc")
        ->first();

        $banners = Banners::where("active", "yes")
        ->orderBy("urutan","asc")
        ->get();

        $cekvoucher = UndianVouchers::select("undians.name")
        ->join("transactions", "undian_vouchers.transaction_id", "=", "transactions.id")
        ->join("undians", "undian_vouchers.undian_id", "=", "undians.id")
        ->where([
            ['transactions.user_id', '=', $user->id],
            ['undian_vouchers.view', '=', NULL],
        ])
        ->first(); 

        $wilayahid = $user->wilayah_id;

        return view('home', compact('date','iduser','wilayahid','kategori','reedems','toko','sudahtour','cekout','service','saldouang','diskon','distance','time','alamat','saldopoin','banners','user'));

    }


    public function detail($id)
    {
        date_default_timezone_set('Asia/Jakarta');
        $usernyah = Auth::user();

        if(!$usernyah){
            $user = Users::where("email", substr(csrf_token(),0,7).'@gmail.com')
            ->first();
        } else {
            $user = Auth::user();
        }

        $postnews = Posts::select("posts.*","company.photo","wilayah.name as wilayah_name","regencies.name as regency_name","wilayah.id as wilayah_id","wilayah.alamat","wilayah.uuid","product.name as prod_name","product.id as prod_id","product.img as prod_img")
        ->leftJoin("users", "posts.user_id", "=", "users.id")
        ->leftJoin("wilayah", "users.wilayah_id", "=", "wilayah.id")
        ->leftJoin("regencies", "wilayah.regency_id", "=", "regencies.id")
        ->leftJoin("company", "wilayah.company_id", "=", "company.id")
        ->leftJoin("product", "posts.product_id", "=", "product.id")
        ->where("posts.id", $id)
        ->first();

        

        $userid = $user->id;

        $cekfav = Favorite::where([
            ['user_id', '=', $user->id],
            ['post_id', '=', $id],
        ])
        ->first();

        $postid = $id;

        $tour = Tours::where("user_id", $user->id)
        ->first();

        $sudahtour = Tours::where(['user_id'=>$user->id])
        ->update(['detailprod'=>'1']);

        $service = Services::where('type', 'midtrans')
            ->first();

        if($user->pemegangsaham == 'yes'){

            $pemegangsaham = Services::where('type', 'pemegangsaham')
            ->first();

            $diskon = $pemegangsaham->biaya;

        } else {

            $diskon = 0;

        }

        $toko = Posts::select("wilayah.*")
        ->join("users", "posts.user_id", "=", "users.id")
        ->join("wilayah", "users.wilayah_id", "=", "wilayah.id")
        ->where("posts.id", $id)
        ->first();

        return view('detail', compact('postnews','cekfav','userid','postid','tour','service','diskon','toko'));

    }
}
