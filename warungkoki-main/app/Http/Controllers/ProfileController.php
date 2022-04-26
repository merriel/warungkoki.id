<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Users;
use App\SaldoUang;
use App\SaldoPoin;
use Auth;

class ProfileController extends Controller
{
    public function index()
    {
    	date_default_timezone_set('Asia/Jakarta');
		$date = date('Y-m-d');

		$user = Auth::user();

		$datas = Users::where("id", $user->id)
		->first();

        $saldouang = SaldoUang::where("user_id", $user->id)
        ->orderBy("id", "desc")
        ->first();

        $saldopoin = SaldoPoin::where("user_id", $user->id)
        ->orderBy("id", "desc")
        ->first();

		return view('content.profile.index', compact('date','datas','saldopoin', 'saldouang'));

    }

    public function update(Request $request)
    {
    	date_default_timezone_set('Asia/Jakarta');
    	$user = Auth::user();

    	$profileupdates = Users::findOrFail($user->id);
        $profileupdates->name = $request->nama;
        $profileupdates->no_hp = $request->no_hp;
        $profileupdates->token = $request->token;
        $profileupdates->ktp = $request->ktp;
        $profileupdates->save();

        return response()->json($profileupdates);


    }

    public function get()
    {

        $user = Auth::user();

        if($user->token == null){
            $data = '0';
        } else {
            $data = '1';
        }

        return response()->json($data);

    }

    public function testing()
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d');

        $datas = Users::where("role_id", '4')
        ->get();

        return view('content.test.index', compact('datas'));

    }

     public function karyawan(){

        $rows = [

            ['JULIAN PUTERI YUSDAR','3','HDN-21-0017','$2y$10$I9ugFs70mx9Tlr6GL2SQNucvKuhI1gSiRsingYTheogJMA2fuo.2K'],
            ['RAFI ISMAIL','3','HDN-21-0022','$2y$10$qK5/wZVTrxChquhd3lqnXuzgfH2./K7iFdpCOiuqnEjcHs4ELlLFm'],
            ['RUSLAN ABDUL GANI','3','HDN-21-0027','$2y$10$mbYomBQoE7f.shym0Tu2IedCo8e/A5oQf4/cLJLVKyU.fp88emus6'],
            ['MUTIARA FAYZZA','3','HDN-21-0029','$2y$10$9H0pYTQF4xNFuVXDqjKqbelVKaKqouSZ6RL9AA7oiutnpN1yHKklq'],
            ['YULIANI','3','HDN-22-0007','$2y$10$iby7gP70StzBB/XHTOicj./RvQ9jbcBxOm11mP6MB8WjGMfIPza7u'],
            ['RIZKY FAUZI PRABOWO','3','HDN-22-0008','$2y$10$SKAs0LcZCZA.Z5XWISB7N.l1jcR4qUmmpUXbLDHHucvDp0sUjXrO.'],
            ['RATNA TRIANA','4','HDN-21-0007','$2y$10$LE97PBPP0/4x20WOZNIp2eFmfU1msDcMHaI44qVKp/qnVN.KWt9tC'],
            ['ILHAM JAYA KUSUMA','4','HDN-21-0014','$2y$10$pUUAsEVmX6SB2B4svgyxM.uL1f3hiJ5S2hZrDFjcQZ97QC4S/SpF.'],
            ['RENDY JUNOVER','10','HDN-21-0013','$2y$10$1f6aWJQFLJjbv0K5zDqnRuVsDxkBrHbHVeN/bvjOWLCpnlEjP58xO'],
            ['AHMAD AFID NAWAWI','10','HDN-21-0015','$2y$10$wxlbi0NBF0IGwbw01pXlq.P2SgyG2kX5cMBsL.qg5dXgAndIdGVEa'],
            ['MUHAMMAD RIZKI FIRMANSYAH','9','HDN-21-0008','$2y$10$yBIWi8gVVDdYLZeiv8cVsetM.fIsivnsSqf3OAb7nyYvr8ao2nSqC'],
            ['NOVITRI MAHARANI','9','HDN-21-0012','$2y$10$hcckW1mGrtCecDTKO/XdmO92CZ1Rrbi4W6m4GatOSTWJMD86xchpi'],
            ['MUHAMAD FIRDAUS','6','HDN-21-0009','$2y$10$LLlwxHvNUxy23aCp9c5MGeG1UwrmRwt3uSj2.NTqHNepa1a7zt8Xq'],
            ['DIMAS DWI SAPUTRA','6','HDN-21-0028','$2y$10$uxsc8GzEQyXQ/uOKPvLxFOE0ypc.1b7yB12Pdz3AXOazNrF3ASWQq'],
            ['DHEA MULYANA','8','HDN-21-0010','$2y$10$0w8E35/4Exdx6ZmUQJdET.5DgfsvU5PLIJAXVaKhAmrvfn5LZyiI.'],
            ['ADE RAIHAN NAWAWI','8','HDN-21-0019','$2y$10$IjdAUHFak1APL3ORyd1gFOfAroluohp.hfxIMwS1b72qxeR54xJUm'],
            ['WILDAN AGUSTIA JILHAD','5','HDN-21-0020','$2y$10$LqHNsM80cFO3Buc5QwbKJeujbp2nzJdW4zdwvZIB9W3cZfWoe98vO'],
            ['ANGGA KURNIA SANDI','5','HDN-21-0021','$2y$10$FUtIqGDfVhqxiv.uy5uLgOJsAtmwRZowTm/y928H/uBNa.0eYnH2K'],
            ['MUGIYONO','22','HDN-21-0023','$2y$10$PSUjfcGl3CTiCals1GtGEOxUlmb8rXv7EvGcPazrdJo2vvEz4.Adm'],
            ['KARITEM','12','HDN-22-0001','$2y$10$viYzmmO61/VN77lfEN/eJOIhJ/GxGvZSfuzlsbkL4B6ok6xttAzi2'],
            ['MISBAHUDIN','21','HDN-21-0026','$2y$10$uPUtjWJTbRwSZfBBdMozFeP7bnFAG3PzC0qzbHZTTKxHRT5Fze5ce'],
            ['SENDI KURNIAWAN','14','HDN-21-0024','$2y$10$ZRrh0j9KGlCuWz7e46eTvuKOSAnHkVo9ji2yilnkNdbYMfkG873Uq'],
            ['ROSYANA','17','HDN-21-0025','$2y$10$FspTKrJT1xyefAdXpMVeReu7qZHaPgRrlliZYenWGtXQ6wQmY5I5W'],
            ['MELATI NUR','13','HDN-22-0002','$2y$10$lWcOCb5zGyVu2APJUpZ1wOPVVaVYLeEnCDHc6xvW7w99Z2fHR529O'],
            ['TUTI HANDAYANI','20','HDN-22-0005','$2y$10$XnCz6EJm8QFuFVJJ2PouSupfC17EXqCnHDp1T.OQA0tXoyoNgTKmG'],


        ];


        foreach ($rows as $data) {

            $name = $data[0];
            $wilayahid = $data[1];
            $email = $data[2];
            $pass = $data[3];


            $create = new Users();
            $create->role_id = 3;
            $create->wilayah_id = $wilayahid;
            $create->name = $name;
            $create->email = $email;
            $create->password = $pass;
            $create->token = '123456';
            $create->ket = 'update';
            $create->save();


        }

    }

}
