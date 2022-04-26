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
use App\WSTransaksi;
use App\Tours;
use App\UpdateStocks;
use App\Services;
use App\TransaksiDetails;
use App\SaldoUang;
use App\Alamat;
use App\SaldoPoin;
use App\Retailers;
use App\Undian;
use App\Banners;
use App\UndianVouchers;
use App\KurirLocal;
use App\UserMembers;
use App\UndianHadiah;
use App\Mission;
use App\MissionCollection;
use App\MissionReward;
use App\StockTransactions;
use App\StockTransactionDetails;
use App\Vouchers;
use Auth;
use DB;
use Hash;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d');
        $hariini = date('Y-m-d H:i:s');
        $hari = date('Y-m-d');

        $user = Auth::user();

        $iduser = $user->id;

        $roles = Users::select("role_id")
        ->where("id", $user->id)
        ->first();

        if($roles->role_id == '4'){

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
                // $selisih =  $interval->format('%R%a');

                // $angka = intval(substr($selisih,1));

                // if($angka >= 2){

                //     $updates = Transaksi::findOrFail($tran->id);
                //     $updates->status = 'KADALUARSA';
                //     $updates->save();

                // }

            }


            // === KATEGORI BBM ===

            $kategori = Posts::select("kategori.*")
            ->join("kategori", "posts.kategori_id", "=", "kategori.id")
            ->join("users", "posts.user_id", "=", "users.id")
            ->where("kategori.type", null)
            ->where("users.wilayah_id", $user->wilayah_id)
            ->distinct()
            ->get();

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


            // ======= MENENTUKAN TAMPILAN =======

            if($request->retailercode == NULL){

                if($user->retailer_id == null){

                    $toko = Users::select("wilayah.*","company.photo","regencies.name as regency_name")
                    ->join("wilayah", "users.wilayah_id", "=", "wilayah.id")
                    ->join("company", "wilayah.company_id", "=", "company.id")
                    ->join("regencies", "wilayah.regency_id", "=", "regencies.id")
                    ->where("users.id", $user->id)
                    ->first();

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

                    $wilayahid = $user->wilayah_id;

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

                    // $bracket_reedem = $this->getReedemProductGuzzleRequest($wilayahid);

                    // $mission = $this->getMissionGuzzleRequest($iduser);

                    $pilihkat = "0";

                    $products = Posts::select("posts.product_id","posts.jenis")
                    ->leftJoin("users", "posts.user_id", "=", "users.id")
                    ->leftJoin("wilayah", "users.wilayah_id", "=", "wilayah.id")
                    ->leftJoin("regencies", "wilayah.regency_id", "=", "regencies.id")
                    ->leftJoin("product", "posts.product_id", "=", "product.id")
                    ->where([
                          ["wilayah.id", $wilayahid],
                          ["posts.active", "Y"],
                          ['wilayah.active', '=', "Y"],
                          ['posts.type', '=', 'Products'],
                    ])
                    ->orderBy('posts.jenis', 'desc')   
                    ->groupBy("posts.product_id","posts.jenis")
                    ->get();

                    return view('content.home.users.index', compact('date','iduser','wilayahid','kategori','reedems','toko','sudahtour','cekout','service','saldouang','diskon','distance','time','alamat','saldopoin','banners','cekvoucher','products','pilihkat'));

                } else {

                    $cek = Retailers::where("id", $user->retailer_id)
                    ->first();

                    $toko = Users::select("retailers.*","wilayah.lat","wilayah.long")
                    ->join("retailers", "users.retailer_id", "=", "retailers.id")
                    ->join("wilayah", "retailers.wilayah_id", "=", "wilayah.id")
                    ->where("users.id", $user->id)
                    ->first();

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

                    $wilayahid = $cek->wilayah_id;

                    return view('content.home.retailer.index', compact('date','iduser','wilayahid','kategori','reedems','toko','sudahtour','cekout','service','saldouang','diskon','distance','time','alamat','saldopoin'));

                }

            } else {

                $cek = Retailers::where("uuid", $request->retailercode)
                ->first();

                if($cek){

                    $updates = Users::findOrFail($user->id);
                    $updates->retailer_id = $cek->id;
                    $updates->wilayah_id = null;
                    $updates->save();

                    $toko = Users::select("retailers.*","wilayah.lat","wilayah.long")
                    ->join("retailers", "users.retailer_id", "=", "retailers.id")
                    ->join("wilayah", "retailers.wilayah_id", "=", "wilayah.id")
                    ->where("users.id", $user->id)
                    ->first();

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

                    $wilayahid = $cek->wilayah_id;

                    return view('content.home.retailer.index', compact('date','iduser','wilayahid','kategori','reedems','toko','sudahtour','cekout','service','saldouang','diskon','distance','time','alamat','saldopoin'));

                } else {

                    



                }

                
            }


        } else if($roles->role_id == '5'){

            $prods = Product::where('company_id', $user->company_id)
            ->get();

            $prod2s = Posts::select("product.*")
            ->leftJoin("post_details", "posts.id", "=", "post_details.post_id")
            ->leftJoin("product", "post_details.product_id", "=", "product.id")
            ->where([
                ['product.company_id', '=', $user->company_id],
                ['posts.type', '=', 'Products'],
            ])
            ->get();

            $kategoris = Kategori::all();

            $areas = Wilayah::where('company_id', $user->company_id)
            ->get();

            $reedemhariini = Transaksi::select("transactions.id")
            ->join("transaction_details", "transactions.id", "=", "transaction_details.transaction_id")
            ->join("posts", "transaction_details.post_id", "=", "posts.id")
            ->distinct()
            ->where([
                ['transactions.status', '=', 'APPROVED'],
                ['posts.user_id', '=', $user->id],
            ])
            ->whereDate('transactions.created_at', $date)
            ->get();

            $transaksihariini = Transaksi::select("transactions.id")
            ->join("transaction_details", "transactions.id", "=", "transaction_details.transaction_id")
            ->join("posts", "transaction_details.post_id", "=", "posts.id")
            ->distinct()
            ->where([
                ['transactions.status', '=', 'APPROVED'],
                ['posts.user_id', '=', $user->id],
            ])
            ->whereDate('transactions.created_at', $date)
            ->get();

            $transaksirupiah = DB::table('transactions')
            ->select("orders.amount")
            ->join("orders", "transactions.id", "=", "orders.transaction_id")
            ->join("transaction_details", "transactions.id", "=", "transaction_details.transaction_id")
            ->join("posts", "transaction_details.post_id", "=", "posts.id")
            ->distinct()
            ->where([
                ['posts.user_id', '=', $user->id],
            ])
            ->whereIn('status', ['REEDEM','PENDING'])
            ->whereDate('transactions.created_at', $date)
            ->sum('orders.amount');

            return view('content.home.outlet.index', compact('date','prods','areas','kategoris','transaksihariini','transaksirupiah','prod2s','reedemhariini'));


        } else if($roles->role_id == '3'){

            $reedemhariini = Transaksi::where([
                ['wilayah_id', '=', $user->wilayah_id],
            ])
            ->whereIn('status', ['REEDEM','PENDING'])
            ->whereDate('transactions.updated_at', $date)
            ->count();

            $prodreedems = TransaksiDetails::select("transaction_details.qty","transactions.updated_at","product.name as prod_name","posts.name as post_name","transactions.uuid")
            ->join("transactions", "transaction_details.transaction_id", "=", "transactions.id")
            ->leftJoin("users", "transactions.petugas_id", "=", "users.id")
            ->join("posts", "transaction_details.post_id", "=", "posts.id")
            ->join("product", "posts.product_id", "=", "product.id")
            ->where([
                ['users.wilayah_id', '=', $user->wilayah_id],
            ])
            ->whereIn('transactions.status', ['REEDEM','PENDING'])
            ->whereDate('transactions.updated_at', $date)
            ->count();

            $transaksihariini = Transaksi::join("orders", "transactions.id", "=", "orders.transaction_id")
            ->where([
                ['transactions.cash', '=', NULL],
                ['wilayah_id', '=', $user->wilayah_id],
                ['transactions.status', '=', 'APPROVED'],
            ])
            ->whereDate('transactions.created_at', $date)
            ->count();

            $transaksirupiah = DB::table('transactions')
            ->join("orders", "transactions.id", "=", "orders.transaction_id")
            ->where([
                ['transactions.cash', '=', NULL],
                ['transactions.wilayah_id', '=', $user->wilayah_id],
                ['transactions.status', '=', 'APPROVED'],
            ])
            ->whereDate('transactions.created_at', $date)
            ->sum('orders.amount');

            $reedems = TransaksiDetails::select("transaction_details.qty","transactions.updated_at","product.name as prod_name","posts.name as post_name","transactions.uuid")
            ->join("transactions", "transaction_details.transaction_id", "=", "transactions.id")
            ->join("users", "transactions.petugas_id", "=", "users.id")
            ->join("posts", "transaction_details.post_id", "=", "posts.id")
            ->join("product", "posts.product_id", "=", "product.id")
            ->where([
                ['transactions.status', 'IN', ['PENDING','REEDEM']],
                ['users.wilayah_id', '=', $user->wilayah_id],
            ])
            ->whereDate('transactions.updated_at', $date)
            ->get();

            $kurirtoko = KurirLocal::where("wilayah_id", $user->wilayah_id)
            ->first();

            $wilayah = Wilayah::where("id", $user->wilayah_id)
            ->first();

            $memberhariini = UserMembers::select("user_members.member_id")
            ->join("transactions", "user_members.transaction_id", "=", "transactions.id")
            ->where('user_members.user_id', $user->id)
            ->whereDate('transactions.updated_at', $date)
            ->count();

            $totalmember = UserMembers::select("user_members.member_id")
            ->join("transactions", "user_members.transaction_id", "=", "transactions.id")
            ->where('user_members.user_id', $user->id)
            ->count();

            $petugastotal = UserMembers::select('users.name', DB::raw('COUNT(user_members.member_id) as member'))
            ->join("users", "user_members.user_id", "=", "users.id")
            ->where("users.company_id", NULL)
            ->orderBy('member', 'desc')
            ->groupBy('users.name')
            ->limit(10)
            ->get();

            $ranking = UserMembers::select('users.name','users.id', DB::raw('COUNT(user_members.member_id) as member'))
            ->join("users", "user_members.user_id", "=", "users.id")
            ->where("users.company_id", NULL)
            ->orderBy('member', 'desc')
            ->groupBy('users.name','users.id')
            ->get();

            $blnawal = date('Y-m-01', strtotime($hariini));
            $blnakhir = date('Y-m-t', strtotime($hariini));

            $userid = $user->id;

            $blnnya = date('m');

            $summarybarang = TransaksiDetails::select('product.name as prod_name','posts.name', DB::raw('SUM(transaction_details.qty) as barang'))
            ->join("transactions", "transaction_details.transaction_id", "=", "transactions.id")
            ->join("posts", "transaction_details.post_id", "=", "posts.id")
            ->join("product", "transaction_details.product_id", "=", "product.id")
            ->whereDate('transactions.updated_at', $date)
            ->where('transactions.wilayah_id', $user->wilayah_id)
            ->where('transactions.status', "APPROVED")
            ->where('transactions.cash', NULL)
            ->groupBy('product.name','posts.name')
            ->get();

            $cekstok = StockTransactions::where([
                ['wilayah_id', '=', $user->wilayah_id],
                ['date', '=', $date],
                ['type', '=', 'cek'],
            ])
            ->orderBy("id", "desc")
            ->first();

            $selesaistok = StockTransactions::where([
                ['wilayah_id', '=', $user->wilayah_id],
                ['date', '=', $date],
                ['type', '=', 'cek'],
                ['jenis', '=', 'akhir'],
                ['status', '=', NULL],
            ])
            ->orderBy("id", "desc")
            ->first();

            $cekmasukbarang = StockTransactions::select("wilayah.name","stock_transactions.date","stock_transactions.id")
            ->join("wilayah", "stock_transactions.wilayah_id", "=", "wilayah.id")
            ->where([
                ['destination_id', '=', $user->wilayah_id],
                ['status', '=', 'pending'],
            ])
            ->get();

            $cekvoucher = Vouchers::whereIn('id', [13,14,20,21,22,23])
            ->get();

            $voucherid = 13;

            $promo = Vouchers::where("id", $voucherid)
            ->first();

            $petugasvouchers = Transaksi::select('users.name', DB::raw('SUM(orders.amount) as amount'), DB::raw('COUNT(transactions.id) as transaksi'))
            ->join("users", "transactions.petugas_id", "=", "users.id")
            ->join("orders", "transactions.id", "=", "orders.transaction_id")
            ->join("voucher_details", "orders.voucherdet_id", "=", "voucher_details.id")
            ->where("voucher_details.voucher_id", $voucherid)
            ->orderBy('amount', 'desc')
            ->groupBy('users.name')
            ->get();

            $cekmonitoringvouchers = Vouchers::where("show","yes")
            ->get();

            $stocks = StockTransactions::where([
                ['wilayah_id', '=', $user->wilayah_id],
                ['date', '=', date('Y-m-d')],
                ['status', '=', NULL],
            ])
            ->orderBy("id","desc")
            ->get();

            return view('content.home.petugas.index', compact('date','reedemhariini','transaksihariini','transaksirupiah','user','reedems','prodreedems','kurirtoko','wilayah','memberhariini','totalmember','petugastotal','blnawal','blnakhir','userid','blnnya','ranking','summarybarang','cekstok','cekmasukbarang','cekmonitoringvouchers','cekvoucher','voucherid','promo','petugasvouchers','stocks','selesaistok'));


        } else if($roles->role_id == '2'){

            $prods = Product::where('company_id', $user->company_id)
            ->get();

            $reedemhariini = Transaksi::join("users", "transactions.petugas_id", "=", "users.id")
            ->where([
                ['transactions.status', 'IN', ['PENDING','REEDEM']],
                ['users.wilayah_id', '=', $user->wilayah_id],
            ])
            ->whereDate('transactions.created_at', $date)
            ->count();

            $prodreedems = TransaksiDetails::select("transaction_details.qty","transactions.updated_at","product.name as prod_name","posts.name as post_name","transactions.uuid")
            ->join("transactions", "transaction_details.transaction_id", "=", "transactions.id")
            ->join("users", "transactions.petugas_id", "=", "users.id")
            ->join("posts", "transaction_details.post_id", "=", "posts.id")
            ->join("product", "posts.product_id", "=", "product.id")
            ->where([
                ['users.wilayah_id', '=', $user->wilayah_id],
            ])
            ->whereIn('transactions.status', ['APPROVED'])
            ->whereDate('transactions.created_at', $date)
            ->count();

            $prod2s = Posts::select("product.*")
            ->leftJoin("post_details", "posts.id", "=", "post_details.post_id")
            ->leftJoin("product", "post_details.product_id", "=", "product.id")
            ->where([
                ['product.company_id', '=', $user->company_id],
                ['posts.type', '=', 'Products'],
            ])
            ->get();

            $kategoris = Kategori::all();

            $areas = Wilayah::where('company_id', $user->company_id)
            ->get();

            $transaksihariini = Transaksi::join("orders", "transactions.id", "=", "orders.transaction_id")
            ->whereIn('transactions.status', ['APPROVED'])
            ->whereDate('transactions.created_at', $date)
            ->count();

            $transaksirupiah = DB::table('transactions')
            ->join("orders", "transactions.id", "=", "orders.transaction_id")
            ->whereIn('transactions.status', ['APPROVED'])
            ->whereDate('transactions.created_at', $date)
            ->sum('orders.amount');

            return view('content.home.principle.index', compact('date','prods','areas','kategoris','transaksihariini','transaksirupiah','prod2s','reedemhariini','prodreedems'));

        } else if($roles->role_id == '6'){

            $transaksis = Transaksi::select("transactions.*","wilayah.name as wilayah_name","orders.jam")
            ->leftJoin("transaction_details", "transactions.id", "=", "transaction_details.transaction_id")
            ->leftJoin("orders", "transactions.id", "=", "orders.transaction_id")
            ->leftJoin("posts", "transaction_details.post_id", "=", "posts.id")
            ->leftJoin("users", "posts.user_id", "=", "users.id")
            ->leftJoin("wilayah", "users.wilayah_id", "=", "wilayah.id")
            ->where([
                ['transactions.alamat_id', '!=', null],
                ['wilayah.id', '=', $user->wilayah_id],
                ['orders.delivery_name', '=', "kurirtoko"],
                ['transactions.status', '=', "ALLOCATED"],
            ])
            ->orWhere([
                ['transactions.alamat_id', '!=', null],
                ['wilayah.id', '=', $user->wilayah_id],
                ['orders.delivery_name', '=', "kurirtoko"],
                ['transactions.status', '=', "DROPPING_OFF"],
            ])
            ->distinct()
            ->get();

            $userid = $user->id;

            return view('xhome.petugas.kurir', compact('date','transaksis','userid'));

        } else if($roles->role_id == '7'){


            $petugastotal = UserMembers::select('users.name', DB::raw('COUNT(user_members.member_id) as member'))
            ->join("users", "user_members.user_id", "=", "users.id")
            ->where("users.company_id", NULL)
            ->orderBy('member', 'desc')
            ->groupBy('users.name')
            ->limit(10)
            ->get();

            $ranking = UserMembers::select('users.name','users.id', DB::raw('COUNT(user_members.member_id) as member'))
            ->join("users", "user_members.user_id", "=", "users.id")
            ->where("users.company_id", NULL)
            ->orderBy('member', 'desc')
            ->groupBy('users.name','users.id')
            ->get();

            $blnawal = date('Y-m-01', strtotime($hariini));
            $blnakhir = date('Y-m-t', strtotime($hariini));

            $userid = $user->id;

            $blnnya = date('m');

            $cekvoucher = Vouchers::whereIn('id', [13,14,20,21,22,23])
            ->get();

            $voucherid = 13;

            $promo = Vouchers::where("id", $voucherid)
            ->first();


            $petugasvouchers = Transaksi::select('users.name', DB::raw('SUM(orders.amount) as amount'), DB::raw('COUNT(transactions.id) as transaksi'))
            ->join("users", "transactions.petugas_id", "=", "users.id")
            ->join("orders", "transactions.id", "=", "orders.transaction_id")
            ->join("voucher_details", "orders.voucherdet_id", "=", "voucher_details.id")
            ->where("voucher_details.voucher_id", $voucherid)
            ->orderBy('amount', 'desc')
            ->groupBy('users.name')
            ->get();

            $cekmonitoringvouchers = Vouchers::where("show","yes")
            ->get();

            $stokpendings = StockTransactions::select("stock_transactions.*","wilayah.name as wilayah_name","users.name as username")
            ->join("wilayah", "stock_transactions.wilayah_id", "=", "wilayah.id")
            ->join("users", "stock_transactions.user_id", "=", "users.id")
            ->where("status","notapproved")
            ->get();

            $stocks = StockTransactionDetails::select("posts.name as post_name", "stock_transaction_details.*")
            ->leftJoin("posts", "stock_transaction_details.post_id", "=", "posts.id")
            ->where("stocktransaction_id", 0)
            ->get();

            return view('content.home.supervisor.index', compact('user','petugastotal','blnawal','blnakhir','userid','blnnya','ranking','cekmonitoringvouchers','petugasvouchers','cekvoucher','voucherid','promo','stokpendings','stocks'));

        }

    }

    public function produk(Request $request){

        $user = Auth::user();

        $iduser = $user->id;

        $pilihkat = $request->kategori;
        $wilayahid = $request->wilayah;

        if($pilihkat == 0){

            $products = Posts::select("posts.product_id","posts.jenis")
            ->leftJoin("users", "posts.user_id", "=", "users.id")
            ->leftJoin("wilayah", "users.wilayah_id", "=", "wilayah.id")
            ->leftJoin("regencies", "wilayah.regency_id", "=", "regencies.id")
            ->leftJoin("product", "posts.product_id", "=", "product.id")
            ->where([
                  ["wilayah.id", $request->wilayah],
                  ["posts.active", "Y"],
                  ['wilayah.active', '=', "Y"],
                  ['posts.type', '=', 'Products'],
            ])
            ->orderBy('posts.jenis', 'desc')   
            ->groupBy("posts.product_id","posts.jenis")
            ->get();

        } else {

            $products = Posts::select("posts.product_id","posts.jenis")
            ->leftJoin("users", "posts.user_id", "=", "users.id")
            ->leftJoin("wilayah", "users.wilayah_id", "=", "wilayah.id")
            ->leftJoin("regencies", "wilayah.regency_id", "=", "regencies.id")
            ->leftJoin("product", "posts.product_id", "=", "product.id")
            ->where([
                  ["wilayah.id", $request->wilayah],
                  ["posts.active", "Y"],
                  ['posts.kategori_id', '=', $request->kategori],
                  ['wilayah.active', '=', "Y"],
                  ['posts.type', '=', 'Products'],
            ])
            ->orderBy('posts.jenis', 'desc')   
            ->groupBy("posts.product_id","posts.jenis")
            ->get();

        }
    

        return view('content.home.users.listproduk', compact('products','pilihkat','wilayahid','iduser'));

    }

    public function test(){

        return view('content.home.petugas.test');

    }

    public function rincianmember(Request $request)
    {   
        date_default_timezone_set('Asia/Jakarta');
        $user = Auth::user();
        $userid = $user->id;

        $blnnya = $request->bln;

        $blnawal = date('Y-'.$request->bln.'-01');
        $blnakhir = date('Y-m-t', strtotime($blnawal));


        return view('content.home.petugas.rincianmember', compact('blnnya','userid','blnawal','blnakhir'));

    }

    public function rincianvoucher(Request $request)
    {   
        date_default_timezone_set('Asia/Jakarta');
        $user = Auth::user();
        $userid = $user->id;

        $voucherid = $request->voucher;

        $promo = Vouchers::where("id",$voucherid)
        ->first();

        $petugasvouchers = Transaksi::select('users.name', DB::raw('SUM(orders.amount) as amount'), DB::raw('COUNT(transactions.id) as transaksi'))
        ->leftJoin("users", "transactions.petugas_id", "=", "users.id")
        ->leftJoin("orders", "transactions.id", "=", "orders.transaction_id")
        ->join("voucher_details", "orders.voucherdet_id", "=", "voucher_details.id")
        ->where("voucher_details.voucher_id", $voucherid)
        ->where("transactions.status", "APPROVED")
        ->orderBy('amount', 'desc')
        ->groupBy('users.name')
        ->get();


        return view('content.home.petugas.rincianvoucher', compact('petugasvouchers','voucherid','promo'));

    }

    private function getReedemProductGuzzleRequest($wilayahid)
    {
        try {

            $client = new \GuzzleHttp\Client();

            $request = $client->get("http://127.0.0.1:8000/api/reedem_point/product/list/today?type_response=json&wilayah_id=$wilayahid", ['http_errors' => false]);

            $response = json_decode($request->getBody(),true);

            return ($response['data']);

        }catch(\GuzzleHttp\Exception\RequestException $e){
            return [];
        }catch(Exception $e){
            return [];
        }

    }

    private function getMissionGuzzleRequest($userId)
    {
        // return [

        //     'step' => [
        //         0 => [
        //             'desc' => 'Beli Produk minimal 30 Ribu',
        //             'id_product' => 217,
        //             'id_variant' => 2,
        //             'expirate_at' => '2022-02-22',
        //         ],
        //         1 => [
        //             'desc' => 'Beli Produk minimal 2 produk Senilai 50 Ribu',
        //             'id_product' => null,
        //             'id_variant' => null,
        //             'expirate_at' => '2022-02-25',
        //         ],
        //         2 => [
        //             'desc' => 'Beli Produk minimal 1 Produk',
        //             'id_product' => null,
        //             'id_variant' => null,
        //             'expirate_at' => '2022-02-28',
        //         ],
        //     ],
        //     'reward' => [
        //         'id_product' => 217,
        //     ]

        // ];

        $mission = Mission::where(['type'=>'collection'])->first();

        $missionCollection = MissionCollection::where('id_mission',$mission->id)->get();
        $missionReward = MissionReward::where('id',$mission->id_reward)->first();

        $step = [];

        foreach($missionCollection as $collect) {
            $product = Posts::where('id',$collect->id_product)->first();
            $step[] = [
                    'desc' => $collect->description,
                    'id_product' => $collect->id_product,
                    'id_variant' => $collect->variant,
                    'expired_at' => $collect->expired_at,
                    'product' => [
                        'img'=> $product->img,
                    ],
            ];
        }

        $product_reward = Posts::where('id',$missionReward->id_product)->first();
        $reward = [
            'id_product' => $missionReward->id_product,
            'product' => [
                'img'=> $product_reward->img,
            ],
        ];

        return [
            'step' => $step,
            'reward' => $reward,
        ];

        try {

            $client = new \GuzzleHttp\Client();

            $request = $client->get("http://127.0.0.1:8000/api/reedem_point/product/list/today?type_response=json&wilayah_id=$wilayahid", ['http_errors' => false]);

            $response = json_decode($request->getBody(),true);

            return ($response['data']);

        }catch(\GuzzleHttp\Exception\RequestException $e){
            return [];
        }catch(Exception $e){
            return [];
        }

    }

    public function belumlogin(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d');
        $hariini = date('Y-m-d H:i:s');
        $hari = date('Y-m-d');

        $usernyah = Auth::user();

        if($usernyah){

            return redirect('/home');

        } else {

            if($request->wilayah == null){

                $wilayahid = 3;

            } else {

                $wilayahid = $request->wilayah;
            }

            // === KATEGORI BBM ===

            $kategori = Kategori::where("type", null)->get();

            $toko = Users::select("wilayah.*","company.photo","regencies.name as regency_name")
            ->join("wilayah", "users.wilayah_id", "=", "wilayah.id")
            ->join("company", "wilayah.company_id", "=", "company.id")
            ->join("regencies", "wilayah.regency_id", "=", "regencies.id")
            ->where("wilayah.id", $wilayahid)
            ->first();

            $banners = Banners::where("active", "yes")
            ->orderBy("urutan","asc")
            ->get();


            return view('home', compact('date','wilayahid','kategori','toko','banners'));

        } 

    }


    public function belumlogindetail($id)
    {
        date_default_timezone_set('Asia/Jakarta');
        $usernyah = Auth::user();

        $postnews = Posts::select("posts.*","company.photo","wilayah.name as wilayah_name","regencies.name as regency_name","wilayah.id as wilayah_id","wilayah.alamat","wilayah.uuid","product.name as prod_name","product.id as prod_id","product.img as prod_img")
        ->leftJoin("users", "posts.user_id", "=", "users.id")
        ->leftJoin("wilayah", "users.wilayah_id", "=", "wilayah.id")
        ->leftJoin("regencies", "wilayah.regency_id", "=", "regencies.id")
        ->leftJoin("company", "wilayah.company_id", "=", "company.id")
        ->leftJoin("product", "posts.product_id", "=", "product.id")
        ->where("posts.id", $id)
        ->first();


        $postid = $id;

        $toko = Posts::select("wilayah.*")
        ->join("users", "posts.user_id", "=", "users.id")
        ->join("wilayah", "users.wilayah_id", "=", "wilayah.id")
        ->where("posts.id", $id)
        ->first();

        return view('detail', compact('postnews','postid','toko'));

    }
}
