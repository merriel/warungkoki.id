<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Garansi;
use App\UserCompany;
use Auth;

class GaransiController extends Controller
{
    public function index()
    {
    	date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d');

        $user = Auth::user();

        $getgaransis = Garansi::select('garansi.*')
        ->leftJoin("user_companies", "garansi.company_id", "=", "user_companies.company_id")
        ->where('user_companies.user_id', $user->id)
        ->orderBy('garansi.id', 'desc')
        ->get();

        return view('content.garansi.index', compact('date','getgaransis'));

    }

    public function store(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');

    	$user = Auth::user();

    	$getcompany = UserCompany::where('user_id', $user->id)
    	->first();

        $creategaransi = new Garansi();
        $creategaransi->name = $request->nama;
        $creategaransi->company_id = $getcompany->company_id;
        $creategaransi->jangka_garansi = $request->waktu;
        $creategaransi->type_waktu = $request->types;
        $creategaransi->ket = $request->ket;
        $creategaransi->save();

        return response()->json($creategaransi);

    }

    public function delete(Request $request)
    {
        $gardel = Garansi::findOrFail($request->id);
        $gardel->delete();

        return response()->json($gardel);
    }

    public function update(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
           
        $updatess = Garansi::findOrFail($request->id);
        $updatess->name = $request->nama;
        $updatess->jangka_garansi = $request->waktu;
        $updatess->type_waktu = $request->types;
        $updatess->ket = $request->ket;
        $updatess->save();

        return response()->json($updatess);
    }

}
