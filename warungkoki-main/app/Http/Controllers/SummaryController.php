<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Alamat;
use App\Province;
use App\ReedemKet;
use App\ReedemKeranjang;
use Auth;

class SummaryController extends Controller
{
    public function index()
    {

        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d');

        $user = Auth::user();

        $reedems = ReedemKet::select("reedem_ket.*", "alamat.judul","alamat.alamat","regencies.name as regency_name","provinces.name as prov_name")
        ->leftJoin("alamat", "reedem_ket.alamat_id", "=", "alamat.id")
        ->leftJoin("regencies", "alamat.regency_id", "=", "regencies.id")
        ->leftJoin("provinces", "regencies.province_id", "=", "provinces.id")
        ->where("reedem_ket.user_id", $user->id)
        ->first();

        $deliveries = ReedemKeranjang::select("reedem.*","product.name as prod_name","posts.name as post_name","imgpost.name as img_name","wilayah.name as wilayah_name","posts.type","posts.harga_act")
        ->leftJoin("saldo", "reedem.saldo_id", "=", "saldo.id")
        ->leftJoin("product", "saldo.product_id", "=", "product.id")
        ->leftJoin("posts", "saldo.post_id", "=", "posts.id")
        ->leftJoin("post_images", "posts.id", "=", "post_images.post_id")
        ->leftJoin("imgpost", "post_images.img_id", "=", "imgpost.id")
        ->leftJoin("users", "posts.user_id", "=", "users.id")
        ->leftJoin("wilayah", "users.wilayah_id", "=", "wilayah.id")
        ->where([
            ['saldo.user_id', '=', $user->id],
            ['reedem.tab', '=', 'delivery'],
        ])
        ->get();

        $provinces = Province::all();

        return view('content.summary.index', compact('reedems','deliveries'));

    }
}
