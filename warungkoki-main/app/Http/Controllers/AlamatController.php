<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Alamat;
use App\Province;
use App\Regency;
use App\ReedemKet;
use App\Districts;
use Auth;

class AlamatController extends Controller
{
    public function index()
    {

        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d');

        $user = Auth::user();

        $alamats = Alamat::select("alamat.*", "regencies.name as regency_name","provinces.name as prov_name","regencies.postal_code","districts.name as district_name")
        ->leftJoin("districts", "alamat.district_id", "=", "districts.id")
        ->leftJoin("regencies", "districts.regency_id", "=", "regencies.id")
        ->leftJoin("provinces", "regencies.province_id", "=", "provinces.id")
        ->where("alamat.user_id", $user->id)
        ->get();

        $provinces = Province::whereIn('id', [3, 6, 9])->get();

        return view('content.alamat.index', compact('alamats','provinces'));

    }

    public function store(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');

        $user = Auth::user();

        $ada = Alamat::where("user_id",$user->id)->first();

        $createalamat = new Alamat();
        $createalamat->judul = $request->judul;
        $createalamat->district_id = $request->district_id;
        $createalamat->user_id = $user->id;
        $createalamat->alamat = $request->alamat;
        $createalamat->penerima = $request->penerima;
        $createalamat->nohp = $request->nohp;
        $createalamat->long = $request->long;
        $createalamat->lat = $request->lat;
        $createalamat->note = $request->catatan;
        if(!$ada){
            $createalamat->utama = 'yes';
        }
        $createalamat->save();

        return response()->json($createalamat);

    }

    public function pilih(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');

        $user = Auth::user();

        $updates = ReedemKet::where(['user_id'=>$user->id])
        ->update(['alamat_id'=> $request->alamatid]);

        return response()->json($updates);

    }

    public function ambilkec(Request $request)
    {

        $regencies = Districts::where("regency_id", $request->id)
        ->get();

        return response()->json($regencies);

    }

    public function utama(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');

        $user = Auth::user();

        $updates1 = Alamat::where(['user_id'=>$user->id])
        ->update(['utama'=> NULL]);

        $updates = Alamat::where(['id'=>$request->id])
        ->update(['utama'=> 'yes']);

        return response()->json($updates);

    }

    public function gantialamat()
    {
        date_default_timezone_set('Asia/Jakarta');

        $user = Auth::user();

        $alamats = Alamat::select("alamat.*", "regencies.name as regency_name","provinces.name as prov_name","regencies.postal_code","districts.name as district_name")
        ->leftJoin("districts", "alamat.district_id", "=", "districts.id")
        ->leftJoin("regencies", "districts.regency_id", "=", "regencies.id")
        ->leftJoin("provinces", "regencies.province_id", "=", "provinces.id")
        ->where("alamat.user_id", $user->id)
        ->get();

        return response()->json($alamats);

    }

    public function cek(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');

        $user = Auth::user();

        $cek = Alamat::where("user_id", $user->id)
        ->get();

        return response()->json($cek);

    }

    public function add()
    {

        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d');

        $provinces = Province::whereIn('id', [3, 6, 9])->get();

        return view('content.alamat.add', compact('provinces'));

    }

    public function hapus(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');

        $hapus = Alamat::where("id", $request->id)
        ->delete();

        return response()->json($hapus);

    }

    public function edit(Request $request)
    {

        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d');

        $provinces = Province::whereIn('id', [3, 6, 9])->get();

        $alamat = Alamat::select("alamat.*","regencies.id as regency_id", "provinces.id as prov_id")
        ->leftJoin("districts", "alamat.district_id", "=", "districts.id")
        ->leftJoin("regencies", "districts.regency_id", "=", "regencies.id")
        ->leftJoin("provinces", "regencies.province_id", "=", "provinces.id")
        ->where('alamat.id', $request->id)
        ->first();

        $regencies = Regency::where("province_id", $alamat->prov_id)
        ->get();

        $districts = Districts::where("regency_id", $alamat->regency_id)
        ->get();

        return view('content.alamat.edit', compact('provinces','alamat','regencies','districts'));

    }

    public function update(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');

        $user = Auth::user();

        $ada = Alamat::where("user_id",$user->id)->first();

        $createalamat = Alamat::findOrFail($request->id);
        $createalamat->judul = $request->judul;
        $createalamat->district_id = $request->district_id;
        $createalamat->user_id = $user->id;
        $createalamat->alamat = $request->alamat;
        $createalamat->penerima = $request->penerima;
        $createalamat->nohp = $request->nohp;
        $createalamat->long = $request->long;
        $createalamat->lat = $request->lat;
        if(!$ada){
            $createalamat->utama = 'yes';
        }
        $createalamat->save();

        return response()->json($createalamat);

    }

}
