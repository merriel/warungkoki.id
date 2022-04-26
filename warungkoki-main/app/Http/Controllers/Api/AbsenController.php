<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use App\Users;

class AbsenController extends Controller
{

	public function pindah(Request $request){

        $bodyContent = $request->getContent();
        $bodyContent2 = json_decode($request->getContent(), true);

        $orderzz = Users::where(['id'=>$bodyContent2['id']])
        ->update(['wilayah_id'=>$bodyContent2['lokasi']]);

        return response()->json('berhasil');

    }


    public function reset(Request $request){

        $bodyContent = $request->getContent();
        $bodyContent2 = json_decode($request->getContent(), true);

        $orderzz = Users::where(['id'=>$bodyContent2['id']])
        ->update(['password'=>$bodyContent2['pass']]);

        return response()->json('berhasil');

    }


}