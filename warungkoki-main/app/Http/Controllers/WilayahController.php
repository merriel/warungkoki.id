<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Wilayah;
use App\UserCompany;
use App\Users;
use App\Province;
use Auth;
use DataTables;
use View;
use Hash;

class WilayahController extends Controller
{
    public function index()
    {

        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d');

        $user = Auth::user();

        $areas = Wilayah::where('company_id', $user->company_id)
        ->get();

        $provinces = Province::where("id","31")
        ->orWhere("id", "36")
        ->orWhere("id", "32")
        ->get();

        return view('content.wilayah.index', compact('date','areas','provinces'));
    }


    public function store(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');

    	$user = Auth::user();

        $ada = Wilayah::where('name', $request->nama)
        ->first();

        if ($ada){

            $notif = '1';

        } else {

            $createwil = new Wilayah();
            $createwil->name = $request->nama;
            $createwil->company_id = $user->company_id;
            $createwil->alamat = $request->alamat;
            $createwil->regency_id = $request->regency_id;
            $createwil->save();


            $created = new Users();
            $created->role_id = '5';
            $created->company_id = $user->company_id;
            $created->wilayah_id = $createwil->id;
            $created->name = $request->namaadmin;
            $created->email = $request->username;
            $created->password = Hash::make($request->password);
            $created->save();

            $notif = '0';

        }

        return response()->json($notif);

    }

    public function view(Request $request)
    {
    	$wils = Wilayah::where('id', $request->id)
        ->first();

        return response()->json($wils);

    }

    public function update(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');

        $wilayah = Wilayah::findOrFail($request->id);
        $wilayah->name = $request->nama;
        $wilayah->alamat = $request->alamat;
        $wilayah->save();

        return response()->json($wilayah);
    }

    public function delete(Request $request)
    {
        $wildel = Wilayah::findOrFail($request->id);
        $wildel->delete();

        return response()->json($wildel);
    }
}
