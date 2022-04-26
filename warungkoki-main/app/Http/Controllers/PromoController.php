<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Users;
use App\Promo;
use App\PromoCategories;
use App\Wilayah;
use App\Iklan;
use App\Keranjang;
use App\VoucherDetails;
use App\Vouchers;
use App\Posts;
use App\Temporary;
use App\Order;
use App\OrderDetails;
use App\TransaksiDetails;
use App\Transaksi;
use App\UserMembers;
use Auth;
use Uuid;
use Illuminate\Support\Facades\Hash;

class PromoController extends Controller
{
	use AuthenticatesUsers;

    public function index(Request $request)
    {
    	date_default_timezone_set('Asia/Jakarta');
		$date = date('Y-m-d');
		$user = Auth::user();

		if($request->wilayah == 'all'){
			$promos = Promo::where([
	            ['type', '=', 'hot'],
	            ['dari', '<=', $date],
	            ['sampai', '>=', $date]
        	])
			->orderBy("urutan", "desc")
			->get();

		} else {

			$promos = Promo::where([
	            ['type', '=', 'hot'],
	            ['wilayah_id', '=', $request->wilayah],
	            ['dari', '<=', $date],
	            ['sampai', '>=', $date]
        	])
			->orWhere(function ($query) use ($date) {
			        $query->where([
		            ['type', '=', 'hot'],
		            ['wilayah_id', '=', NULL],
		            ['dari', '<=', $date],
	            	['sampai', '>=', $date]
	        	]);
			})
			->orderBy("urutan", "desc")
			->get();
		}	

		$wilayahs = Wilayah::where('active', 'Y')
		->get();

		$loc = $request->wilayah;

		$categories = PromoCategories::all();

		$iklans = Iklan::where([
            ['dari', '<=', $date],
            ['sampai', '>=', $date]
    	])
		->get();

		return view('content.promo.index', compact('promos','categories','wilayahs','loc','iklans'));

    }

    public function splash(Request $request){

    	$wilayahid = $request->wilayah;

    	return view('content.promo.splash', compact('wilayahid'));

    }

    public function detail(Request $request)
    {
    	date_default_timezone_set('Asia/Jakarta');
		$date = date('Y-m-d');
		$user = Auth::user();

		$promo = Promo::select("promo.*","posts.name as post_name")
		->leftJoin("posts", "promo.post_id", "=", "posts.id")
		->where('promo.id', $request->id)
		->first();

		$loc = $request->loc;

		return view('content.promo.detail', compact('promo','loc'));
    }

    public function category(Request $request)
    {
    	date_default_timezone_set('Asia/Jakarta');
		$date = date('Y-m-d');
		$user = Auth::user();

		$category = PromoCategories::where("id", $request->id)
		->first();

		if($request->loc == 'all'){
			$promos = Promo::select("promo.*")
			->leftJoin("promodets", "promo.id", "=", "promodets.promo_id")
			->where([
	            ['katprom_id', '=', $request->id],
	            ['promo.dari', '<=', $date],
	            ['promo.sampai', '>=', $date]
        	])
        	->distinct()
	        ->orderBy("promo.id","desc")
			->get();
		} else {
			$promos = Promo::select("promo.*")
			->leftJoin("promodets", "promo.id", "=", "promodets.promo_id")
			->where([
	            ['katprom_id', '=', $request->id],
	            ['promodets.wilayah_id', '=', $request->loc],
	            ['promo.dari', '<=', $date],
	            ['promo.sampai', '>=', $date]
        	])
        	->orWhere(function ($query) use ($request,$date) {
			        $query->where([
		            ['katprom_id', '=', $request->id],
		            ['promodets.wilayah_id', '=', NULL],
		            ['promo.dari', '<=', $date],
	            	['promo.sampai', '>=', $date]
	        	]);
			})
	        ->orderBy("promo.id","desc")
			->get();

		}
		
		$loc = $request->loc;

		return view('content.promo.category', compact('category','promos','loc'));

    }

    public function iklan(Request $request){

    	date_default_timezone_set('Asia/Jakarta');
		$date = date('Y-m-d');

		$iklans = Iklan::where([
            ['dari', '<=', $date],
            ['sampai', '>=', $date],
            ['type', '=', 'all']
    	])
    	->inRandomOrder()
		->first();

		if($iklans){
			$data = 1;
		} else {
			$data = 0;
		}

		$arrayNames = array(    
            'img' => $iklans->img,
            'status' => $data,
        );

		return response()->json($arrayNames);
		
    }

    public function warungkoki(Request $request){

    	date_default_timezone_set('Asia/Jakarta');

        $user = Auth::user();
        
        if(!$user){

            $cekada = Temporary::where('session_id', csrf_token())
            ->first();

            if(!$cekada){

                $tour = new Temporary();
                $tour->session_id = csrf_token();
                $tour->action = $request->jenis;
                $tour->type = $request->jenis;
                $tour->save();

            } else {

                $absensiout = Temporary::where(['session_id'=>csrf_token()])
                ->update(['action'=>$request->jenis, 'type'=>$request->jenis]);
            }

            return redirect('/');

        } else {

            if($request->jenis == 'grab'){

                    return redirect('/promo/'.$request->jenis.'');

            } else {

                return redirect('/home');

            }         

        }



    }


    public function grab(Request $request){

    	date_default_timezone_set('Asia/Jakarta');
		$date = date('Y-m-d');
		$user = Auth::user();

		$wilayah = Wilayah::where("uuid", $request->uuid)
		->first();

		if(!$user){

			$cek = Users::where("email", substr(csrf_token(),0,7).'@gmail.com')
			->first();

			if(!$cek){

				$tour = new Users();
	            $tour->email = substr(csrf_token(),0,7).'@gmail.com';

	            if($request->uuid != NULL){
		            $tour->wilayah_id = $wilayah->id;
		        }

	            $tour->role_id = 4;
	            $tour->name = "DRIVER GRAB";
	            $tour->password = Hash::make('grab');
	            $tour->save();

			} else {

				if($request->uuid != NULL){

					$wilayah22 = Users::where(['id'=>$cek->id])
	        		->update(['wilayah_id'=> $wilayah->id]);

	        	}

			}

		} else {

			if($request->uuid != NULL){

				$wilayah22 = Users::where(['id'=>$user->id])
		        ->update(['wilayah_id'=> $wilayah->id]);

		    } 
		}

		return view('content.promo.promograb');

    }

    public function shell(Request $request){

    	date_default_timezone_set('Asia/Jakarta');
		$date = date('Y-m-d');
		$user = Auth::user();

		$tokos = Wilayah::where("active", 'Y')
		->get();

		$wilayah = Wilayah::where("uuid", $request->uuid)
		->first();

		if(!$user){

			$cek = Users::where("clubsmart", csrf_token())
			->first();

			$kod = substr(csrf_token(),0,10);

			if(!$cek){

				$tour = new Users();
	            $tour->clubsmart = csrf_token();
	            $tour->email = 'shell'.$kod.'@gmail.com';
	            $tour->wilayah_id = $wilayah->id;
	            $tour->role_id = 4;
	            $tour->name = "Pengguna Shell";
	            $tour->password = Hash::make('shell');
	            $tour->save();

			} else {

				$wilayah22 = Users::where(['clubsmart'=>csrf_token()])
	        	->update(['wilayah_id'=> $wilayah->id]);
			}
		} else {

			$wilayah22 = Users::where(['id'=>$user->id])
	        ->update(['wilayah_id'=> $wilayah->id]);
		}

		return view('content.promo.shell.index',compact('tokos','wilayah'));

    }

    public function shellambil(Request $request){
    	
    	date_default_timezone_set('Asia/Jakarta');
		$date = date('Y-m-d');
		$user = Auth::user();

		$usernyah = Auth::user();

		if(!$usernyah){
			$user = Users::where("clubsmart", csrf_token())
			->first();
		} else {
			$user = Auth::user();
		}

		$hapuskeranjang = Keranjang::where("user_id", $user->id)
		->delete();

		$cekvoucher = VoucherDetails::select("voucher_details.id","vouchers.amount","voucher_details.kode","voucher_details.status")
		->leftJoin("vouchers", "voucher_details.voucher_id", "=", "vouchers.id")
		->where("kode", $request->kode)
		->where("voucher_id", 9)
		->first();

		if($cekvoucher){

			$cektrans = Transaksi::select("transactions.uuid","transactions.status")
	     	->leftJoin("orders", "transactions.id", "=", "orders.transaction_id")
	     	->where("orders.voucherdet_id", $cekvoucher->id)
	     	->first();

	     	if($cektrans){

	     		if($cekvoucher->status == NULL){

	     			$delker = Keranjang::where("user_id", $user->id)
	     			->delete();

					$vouchers = new Keranjang();
			        $vouchers->user_id = $user->id;
			        $vouchers->voucherdet_id = $cekvoucher->id;
			        $vouchers->save();

			        $arrayNames = array(    
			            'status' => 1,
			        );

	     		} else {

		            if($cektrans->status == "APPROVED") {

		            	$arrayNames = array(    
				            'status' => 3,
				        );

		            } else {

		            	$arrayNames = array(    
				            'status' => 2,
				            'kode' => $ceklagi->uuid,
				        );

		            }

	     			
	     		}

	     	} else {

	     		if($cekvoucher->status == NULL){

	     			$delker = Keranjang::where("user_id", $user->id)
	     			->delete();

					$vouchers = new Keranjang();
			        $vouchers->user_id = $user->id;
			        $vouchers->voucherdet_id = $cekvoucher->id;
			        $vouchers->save();

			        $arrayNames = array(    
			            'status' => 1,
			        );

	     		} 

	     	}	

		} else {

			$arrayNames = array(    
	            'status' => 0,
	        );
		}

		return response()->json($arrayNames);

    }

    public function pilih(Request $request){
    	
    	date_default_timezone_set('Asia/Jakarta');
		$date = date('Y-m-d');
		$user = Auth::user();

		$usernyah = Auth::user();

		if(!$usernyah){
			$user = Users::where("clubsmart", csrf_token())
			->first();
		} else {
			$user = Auth::user();
		}

		$voucher = Keranjang::select("vouchers.amount","vouchers.name","voucher_details.id")
		->leftJoin("voucher_details", "keranjang.voucherdet_id", "=", "voucher_details.id")
		->leftJoin("vouchers", "voucher_details.voucher_id", "=", "vouchers.id")
		->where("user_id", $user->id)
		->where("keranjang.voucherdet_id",'!=',NULL)
		->first();

      	$products = Posts::select("posts.product_id")
      	->leftJoin("users", "posts.user_id", "=", "users.id")
      	->leftJoin("wilayah", "users.wilayah_id", "=", "wilayah.id")
      	->leftJoin("regencies", "wilayah.regency_id", "=", "regencies.id")
      	->leftJoin("product", "posts.product_id", "=", "product.id")
     	->where([
          ["wilayah.id", $user->wilayah_id],
          ["posts.active", "Y"],
          ['wilayah.active', '=', "Y"],
      	])
      	->orderBy('posts.id', 'desc')   
      	->groupBy("posts.product_id")
     	->get();

     	$wilayahid = $user->wilayah_id;

     	if($voucher){

     		$cektrans = Transaksi::select("transactions.uuid")
	     	->leftJoin("orders", "transactions.id", "=", "orders.transaction_id")
	     	->where("orders.voucherdet_id", $voucher->id)
	     	->first();

	     	if($cektrans){

	     		$cekvoucher = VoucherDetails::where("id", $voucher->id)
	     		->first();

	     		if($cekvoucher->status == NULL){

	     			return view('content.promo.shell.pilih',compact('products','wilayahid','voucher'));

	     		} else {

	     			$ceklagi = Transaksi::where("user_id", $user->id)
		            ->orderBy("id","desc")
		            ->first();

		     		return redirect('/users/transaksi/detail2?uuid='.$ceklagi->uuid);
	     		}

	     	} else {

	     		return view('content.promo.shell.pilih',compact('products','wilayahid','voucher'));

	     	}

     	} else {

     		return view('content.promo.shell.pilih',compact('products','wilayahid','voucher'));
     	}

		

    }

    public function pilihproduk(Request $request){

    	$usernyah = Auth::user();

		if(!$usernyah){
			$user = Users::where("clubsmart", csrf_token())
			->first();
		} else {
			$user = Auth::user();
		}

		$hapuskeranjang = Keranjang::where("user_id", $user->id)
		->where("voucherdet_id", null)
		->delete();

    	$keranjang = new Keranjang();
        $keranjang->user_id = $user->id;
        $keranjang->post_id = $request->id;
        $keranjang->qty = 1;
        $keranjang->reedem = "Yes";
        $keranjang->save();

        $voucher = Keranjang::select("vouchers.amount","vouchers.name")
		->leftJoin("voucher_details", "keranjang.voucherdet_id", "=", "voucher_details.id")
		->leftJoin("vouchers", "voucher_details.voucher_id", "=", "vouchers.id")
		->where("keranjang.user_id", $user->id)
		->where("keranjang.voucherdet_id",'!=',NULL)
		->first();

		$post = Keranjang::select("posts.harga_act")
		->leftJoin("posts", "keranjang.post_id", "=", "posts.id")
		->where("keranjang.user_id", $user->id)
		->where("keranjang.voucherdet_id",'=',NULL)
		->first();

		$total = $post->harga_act - $voucher->amount;

		return response()->json(rupiah($total));
    }



    public function grabrincian(Request $request){

    	date_default_timezone_set('Asia/Jakarta');
		$date = date('Y-m-d');

		$usernyah = Auth::user();

		if(!$usernyah){
			$user = Users::where("email", substr(csrf_token(),0,7).'@gmail.com')
			->first();
		} else {
			$user = Auth::user();
		}

		$keranjangs = Keranjang::select("posts.*","keranjang.qty","wilayah.name as wilayah_name","product.name as prod_name","retailers.name as retailer_name")
		->leftJoin("posts", "keranjang.post_id", "=", "posts.id")
        ->leftJoin("product", "posts.product_id", "=", "product.id")
        ->leftJoin("users", "posts.user_id", "=", "users.id")
        ->leftJoin("wilayah", "users.wilayah_id", "=", "wilayah.id")
        ->leftJoin("retailers", "keranjang.retailer_id", "=", "retailers.id")
        ->where([
            ['keranjang.user_id', '=', $user->id],
            ['voucherdet_id', '=', null],
            ['posts.type', '=', 'Products'],
        ])
		->get();

		$potongan = Keranjang::select('vouchers.*','voucher_details.kode','keranjang.id as kranjang_id')
        ->leftJoin("voucher_details", "keranjang.voucherdet_id", "=", "voucher_details.id")
        ->leftJoin("vouchers", "voucher_details.voucher_id", "=", "vouchers.id")
        ->where([
            ['keranjang.user_id', '=', $user->id],
            ['voucherdet_id', '!=', NULL],
        ])
        ->first();

		return view('content.promo.rinciangrab',compact('keranjangs','potongan'));

    }

    public function grabambil(Request $request){

    	date_default_timezone_set('Asia/Jakarta');
		$date = date('Y-m-d');
		$dates = date('dmis');

		$usernyah = Auth::user();

		if(!$usernyah){
			$user = Users::where("email", substr(csrf_token(),0,7).'@gmail.com')
			->first();
		} else {
			$user = Auth::user();
		}

		$hapuskeranjang = Keranjang::where("user_id", $user->id)
		->delete();

		$cekvoucher = VoucherDetails::where("kode", $request->kode)
		->where("status", NULL)
		->first();

		$wilayahxx = $user->wilayah_id == NULL ? 3 : $user->wilayah_id;


		if($cekvoucher){

			$vouchernya = Vouchers::where("id", $cekvoucher->voucher_id)
			->first();

			$cekmasihada = VoucherDetails::where("voucher_id", $cekvoucher->voucher_id)
			->where("status", "selesai")
			->count();

			if($vouchernya->total == $cekmasihada || $cekmasihada > $vouchernya->total){

				$arrayNames = array(    
		            'data' => 4,
		        );

			} else {

				$cekkadaluarsa = VoucherDetails::where("kode", $request->kode)
				->where("status", NULL)
				->where("sampai", '>=', $date)
				->first();

				if($cekkadaluarsa){

					$data = 1;

					$cektrans = Order::where("voucherdet_id", $cekvoucher->id)
					->first();

					if($cektrans){

						$tr1 = Transaksi::where("id", $cektrans->transaction_id)
				        ->first();

				        if($tr1->status == "APPROVED"){

				        	$arrayNames = array(    
					            'data' => 2,
					            'uuid' => $tr1->uuid,
					        );

				        } else {

				        	$transxx = Transaksi::where(['id'=>$cektrans->transaction_id])
				        	->update(['user_id'=>$user->id, 'created_at' => date('Y-m-d H:i:s'), 'wilayah_id'=>$wilayahxx,'status' => "BELUM BAYAR"]);

				        	$vouchernya = Vouchers::where("id", $cekvoucher->voucher_id)
							->first();

							$postcode = $vouchernya->codes;

					        $post = Posts::select("posts.id", "posts.harga_act","posts.product_id")
					        ->leftJoin("users", "posts.user_id", "=", "users.id")
					        ->where([
					            ['users.wilayah_id', '=', $wilayahxx],
					            ['posts.code_id', '=', $postcode],
					    	])
					    	->first();

					    	$total = $post->harga_act;

					    	$dibayar = $total - $vouchernya->amount;

					    	$ororder = Order::where(['transaction_id'=>$cektrans->transaction_id])
				        	->update(['amount'=>floatval($dibayar)]);

				        	$transdetaa = TransaksiDetails::where(['transaction_id'=>$cektrans->transaction_id])
				        	->update(['post_id'=>$post->id, 'product_id' => $post->product_id]);

				        	$ordernya = Order::where("transaction_id", $cektrans->transaction_id)
				        	->first();

				        	$orderdetas = OrderDetails::where(['order_id'=>$ordernya->id])
				        	->update(['post_id'=>$post->id, 'amount' => $post->harga_act]);

				        	$tr = Transaksi::where("id", $cektrans->transaction_id)
					        ->first();

					        $arrayNames = array(    
					            'data' => 1,
					            'uuid' => $tr->uuid,
					        );

				        }
		 

					} else {

						$uuid = Uuid::generate();
			        	$code = substr($uuid,0,8);
						
						$trans = new Transaksi();
				        $trans->uuid = $code.$dates;
				        $trans->user_id = $user->id;
				        $trans->wilayah_id = $wilayahxx;
				        $trans->type = 'in';
				        $trans->status = 'BELUM BAYAR';
				        $trans->save();

				        $vouchernya = Vouchers::where("id", $cekvoucher->voucher_id)
						->first();

						$postcode = $vouchernya->codes;

				        $post = Posts::select("posts.id", "posts.harga_act","posts.product_id")
				        ->leftJoin("users", "posts.user_id", "=", "users.id")
				        ->where([
				            ['users.wilayah_id', '=', $wilayahxx],
				            ['posts.code_id', '=', $postcode],
				    	])
				    	->first();

				    	$total = $post->harga_act;

				    	$dibayar = $total - $vouchernya->amount;

				    	$donation = new Order();
				        $donation->uuid = $uuid;
				        $donation->transaction_id = $trans->id;
				        $donation->user_id = $user->id;
				        $donation->type_bayar = 'Cash';
				        $donation->status = 'pending';
				        $donation->order_type = 'Pembelian Deals/Product';
				        $donation->amount = floatval($dibayar);
				        $donation->reedem = 'Yes';
				        $donation->voucherdet_id = $cekvoucher->id;
				        $donation->save();


				        $transorder = new OrderDetails();
			            $transorder->order_id = $donation->id;
			            $transorder->post_id = $post->id;
			            $transorder->qty = 1;
			            $transorder->amount = $post->harga_act;
			            $transorder->save();

			            $transdet = new TransaksiDetails();
			            $transdet->transaction_id = $trans->id;
			            $transdet->post_id = $post->id;
			            $transdet->product_id = $post->product_id;
			            $transdet->qty = 1;
			            $transdet->save();


			            if(strlen($trans->id) == 2){
				            $codenya = '0000'.$trans->id;
				        } else if(strlen($trans->id) == 3){
				            $codenya = '000'.$trans->id;

				        } else if(strlen($trans->id) == 4){
				            $codenya = '00'.$trans->id;
				        } else if(strlen($trans->id) == 5){
				            $codenya = '0'.$trans->id;
				        } else {
				           $codenya = $trans->id; 
				        }

				        $uuidxx = Uuid::generate();
				        $codexx = substr($uuidxx,0,3);

				        $transxx = Transaksi::where(['id'=>$trans->id])
				        ->update(['uuid'=>'INV'.date('ymd').$codenya.$codexx, 'created_at' => date('Y-m-d H:i:s')]);

				        $tr = Transaksi::where("id", $trans->id)
				        ->first();

				        $arrayNames = array(    
				            'data' => 1,
				            'uuid' => $tr->uuid,
				        );

				    }

				} else {

					$arrayNames = array(    
			            'data' => 3,
			        );

				}

			}


		} else {

			$arrayNames = array(    
	            'data' => 0,
	        );
		}

		return response()->json($arrayNames);

    }

    public function grabambil2(Request $request){

    	date_default_timezone_set('Asia/Jakarta');
		$date = date('Y-m-d');

		$usernyah = Auth::user();

		if(!$usernyah){
			$user = Users::where("email", substr(csrf_token(),0,7).'@gmail.com')
			->first();
		} else {
			$user = Auth::user();
		}

		$hapuskeranjang = Keranjang::where("user_id", $user->id)
		->delete();

		$cekvoucher = VoucherDetails::where("kode", $request->kode)
		->where("status", NULL)
		->first();

		$wilayahxx = $user->wilayah_id == NULL ? 3 : $user->wilayah_id;

		if($cekvoucher){

			$data = 1;

			$vouchernya = Vouchers::where("id", $cekvoucher->voucher_id)
			->first();

			$postcode = $vouchernya->codes;

	        $post = Posts::select("posts.id")
	        ->leftJoin("users", "posts.user_id", "=", "users.id")
	        ->where([
	            ['users.wilayah_id', '=', $wilayahxx],
	            ['posts.code_id', '=', $postcode],
	    	])
	    	->first();

	        $keranjang = new Keranjang();
	        $keranjang->user_id = $user->id;
	        $keranjang->post_id = $post->id;
	        $keranjang->qty = 1;
	        $keranjang->reedem = "Yes";
	        $keranjang->save();

	        $vouchers = new Keranjang();
	        $vouchers->user_id = $user->id;
	        $vouchers->voucherdet_id = $cekvoucher->id;
	        $vouchers->save();


	        

		} else {

			$data = 0;
		}


		return response()->json($data);

    }

    public function grabbayar(Request $request){

    	date_default_timezone_set('Asia/Jakarta');
        $usernyah = Auth::user();

		if(!$usernyah){
			$user = Users::where("email", substr(csrf_token(),0,7).'@gmail.com')
			->first();
		} else {
			$user = Auth::user();
		}

		$wilayahxx = $user->wilayah_id == NULL ? 3 : $user->wilayah_id;

    	// ==== CEK TRANSAKSI DULU =====

    	$cektransvouc = Keranjang::select("voucherdet_id")
        ->where("voucherdet_id","!=",NULL)
        ->where("user_id", $user->id)
        ->first();

        if($cektransvouc){

        	$transaksinya = Order::select("transactions.uuid","transactions.id","orders.id as order_id")
        	->leftJoin("transactions", "orders.transaction_id", "=", "transactions.id")
        	->where("orders.voucherdet_id", $cektransvouc->voucherdet_id)
        	->first();

        	if($transaksinya){

        		$voucherzz = Vouchers::select("vouchers.*")
        		->leftJoin("voucher_details", "vouchers.id", "=", "voucher_details.voucher_id")
        		->where("voucher_details.id", $cektransvouc->voucherdet_id)
        		->first();

        		$updatesss = Transaksi::where(['id'=>$transaksinya->id])
	            ->update(['wilayah_id'=>$wilayahxx,'user_id'=>$user->id]);

	            $post = Posts::select("posts.id")
		        ->leftJoin("users", "posts.user_id", "=", "users.id")
		        ->where([
		            ['users.wilayah_id', '=', $wilayahxx],
		            ['posts.code_id', '=', $voucherzz->codes],
		    	])
		    	->first();

		    	$updatesss2 = TransaksiDetails::where(['transaction_id'=>$transaksinya->id])
	            ->update(['post_id'=>$post->id]);

	            $updatesss3 = OrderDetails::where(['order_id'=>$transaksinya->order_id])
	            ->update(['post_id'=>$post->id]);

        		$hapuskeranjang = Keranjang::where("user_id", $user->id)
				->delete();

        		return response()->json($transaksinya);
        	}

        }

        // === SELESAI DICEK ===

        $dates = date('dmis');
        if($user->pemegangsaham == 'yes'){

            $pemegangsaham = Services::where('type', 'pemegangsaham')
            ->first();

            $diskon = $pemegangsaham->biaya;

        } else {

            $diskon = 0;

        }

        $keranjangs = Keranjang::select("posts.*","keranjang.qty")
        ->leftJoin("posts", "keranjang.post_id", "=", "posts.id")
        ->where([
            ['keranjang.user_id', '=', $user->id],
            ['voucherdet_id', '=', null],
            ['posts.type', '=', 'Products'],
        ])
        ->get();

        $uuid = Uuid::generate();
        $code = substr($uuid,0,8);

        $cekretailer = Keranjang::where('keranjang.user_id', '=', $user->id)
        ->first();

        $wilayah = Keranjang::select("users.wilayah_id")
        ->leftJoin("posts", "keranjang.post_id", "=", "posts.id")
        ->leftJoin("users", "posts.user_id", "=", "users.id")
        ->where([
            ['keranjang.user_id', '=', $user->id],
            ['posts.type', '=', 'Products'],
        ])
        ->first();

        $trans = new Transaksi();
        $trans->uuid = $code.$dates;
        $trans->user_id = $user->id;
        $trans->wilayah_id = $wilayah->wilayah_id;
        $trans->retailer_id = $cekretailer->retailer_id;
        $trans->type = 'in';
        $trans->status = 'BELUM BAYAR';
        $trans->save();

        $total = 0;

        foreach ($keranjangs as $keranjang) {

            $harga = $keranjang->harga_act - ceil($keranjang->harga_act * (float)$diskon / 100);
            $totalnya = $keranjang->qty * $harga;

         
                $totalkeseluruhan = $totalnya;

            $total += $totalkeseluruhan;

        }

        $reedems = Keranjang::where("user_id", $user->id)
        ->first();

        $adavoucher = Keranjang::select("vouchers.amount","keranjang.voucherdet_id")
        ->leftJoin("voucher_details", "keranjang.voucherdet_id", "=", "voucher_details.id")
        ->leftJoin("vouchers", "voucher_details.voucher_id", "=", "vouchers.id")
        ->where("voucherdet_id","!=",NULL)
        ->where("user_id", $user->id)
        ->first();

        if($adavoucher){

            $total = $total - $adavoucher->amount;

        } else {

            $total = $total;

        }

        $donation = new Order();
        $donation->uuid = $uuid;
        $donation->transaction_id = $trans->id;
        $donation->user_id = $user->id;
        $donation->type_bayar = 'Cash';
        $donation->status = 'pending';
        $donation->order_type = 'Pembelian Deals/Product';
        $donation->amount = floatval($total);
        $donation->reedem = 'Yes';
        if($adavoucher){
            $donation->voucherdet_id = $adavoucher->voucherdet_id;
        }
        $donation->save();

        foreach ($keranjangs as $keranjang) {

            $totalx = $keranjang->harga_act - ceil($keranjang->harga_act * (float)$diskon / 100);
            $totalnya = $keranjang->qty * $harga;

            // $diskonbarang = DiskonDetails::select("diskon.*")
            // ->join("diskon", "diskon_details.diskon_id", "=", "diskon.id")
            // ->where('diskon_details.code_id', $keranjang->code_id)
            // ->where([
            //   ['diskon_details.code_id', '=', $keranjang->code_id],
            //   ['diskon.dari', '<=', (int)$totalnya],
            //   ['diskon.sampai', '>', (int)$totalnya],
            // ])
            // ->first();

            // if($diskonbarang){
            //   $diskonnya = $diskonbarang->diskon;

            // } else {
                $diskonnya = null;
            // }

            $transorder = new OrderDetails();
            $transorder->order_id = $donation->id;
            $transorder->post_id = $keranjang->id;
            $transorder->qty = $keranjang->qty;
            $transorder->amount = $keranjang->qty * $totalx;
            $transorder->diskon = $diskonnya;
            $transorder->save();

            $transdet = new TransaksiDetails();
            $transdet->transaction_id = $trans->id;
            $transdet->post_id = $keranjang->id;
            $transdet->product_id = $keranjang->product_id;
            $transdet->qty = $keranjang->qty;
            $transdet->save();
            
        }

        $orderan = Order::select("orders.*","users.email","users.fcm_token","users.name as username")
        ->leftJoin("transactions", "orders.transaction_id", "=", "transactions.id")
        ->leftJoin("users", "transactions.user_id", "=", "users.id")
        ->where("transaction_id", $trans->id)
        ->first();

        // ====== KIRIM EMAIL ======

        $transaksis = OrderDetails::select("posts.*","order_details.qty","order_details.amount","product.name as prod_name")
        ->leftJoin("posts", "order_details.post_id", "=", "posts.id")
        ->leftJoin("product", "posts.product_id", "=", "product.id")
        ->where("order_details.order_id", $orderan->id)
        ->get();


        $keranjanghapus = Keranjang::where('keranjang.user_id', '=', $user->id)
        ->delete();

        if(strlen($trans->id) == 2){
            $codenya = '0000'.$trans->id;
        } else if(strlen($trans->id) == 3){
            $codenya = '000'.$trans->id;

        } else if(strlen($trans->id) == 4){
            $codenya = '00'.$trans->id;
        } else if(strlen($trans->id) == 5){
            $codenya = '0'.$trans->id;
        } else {
           $codenya = $trans->id; 
        }

        $uuidxx = Uuid::generate();
        $codexx = substr($uuidxx,0,3);

        $transxx = Transaksi::where(['id'=>$trans->id])
        ->update(['uuid'=>'INV'.date('ymd').$codenya.$codexx]);

        $transax = Transaksi::where("id", $trans->id)
        ->first();

        return response()->json($transax);

    }

    public function grabtransaksi(Request $request)
    {   
    	$usernyah = Auth::user();

		if(!$usernyah){
			$user = Users::where("email", substr(csrf_token(),0,7).'@gmail.com')
			->first();
		} else {
			$user = Auth::user();
		}

    	$user = Users::where("id", $user->id)
    	->first();

        $trans = Transaksi::select("transactions.*","orders.type_bayar","regencies.name as regency_name","provinces.name as prov_name","regencies.postal_code","districts.name as district_name","alamat.penerima","alamat.nohp","alamat.alamat","orders.jam","orders.delivery_name","orders.delivery_type","orders.diskon")
        ->leftJoin("orders", "transactions.id", "=", "orders.transaction_id")
        ->leftJoin("alamat", "transactions.alamat_id", "=", "alamat.id")
        ->leftJoin("districts", "alamat.district_id", "=", "districts.id")
        ->leftJoin("regencies", "districts.regency_id", "=", "regencies.id")
        ->leftJoin("provinces", "regencies.province_id", "=", "provinces.id")
        ->where("transactions.uuid", $request->uuid)
        ->first();

        date_default_timezone_set('Asia/Jakarta');

        $wilayah = TransaksiDetails::select("wilayah.name","retailers.name as retailer_name")
        ->leftJoin("transactions", "transaction_details.transaction_id", "=", "transactions.id")
        ->leftJoin("posts", "transaction_details.post_id", "=", "posts.id")
        ->leftJoin("users", "posts.user_id", "=", "users.id")
        ->leftJoin("wilayah", "users.wilayah_id", "=", "wilayah.id")
        ->leftJoin("retailers", "transactions.retailer_id", "=", "retailers.id")
        ->where("transactions.uuid", $request->uuid)
        ->first();

        $saldos = OrderDetails::select("posts.*","order_details.qty","order_details.amount","transactions.id as trans_id","orders.amount as total","transactions.status","product.name as prod_name","orders.delivery as delivery","orders.delivery_name","orders.delivery_type")
        ->leftJoin("orders", "order_details.order_id", "=", "orders.id")
        ->leftJoin("transactions", "orders.transaction_id", "=", "transactions.id")
        ->leftJoin("posts", "order_details.post_id", "=", "posts.id")
        ->leftJoin("product", "posts.product_id", "=", "product.id")
        ->where("transactions.uuid", $request->uuid)
        ->get();


        $ada = 1;


        $potongan = Order::select("vouchers.amount")
        ->leftJoin("voucher_details", "orders.voucherdet_id", "=", "voucher_details.id")
        ->leftJoin("vouchers", "voucher_details.voucher_id", "=", "vouchers.id")
        ->where("transaction_id", $trans->id)
        ->where("voucherdet_id", '!=', NULL)
        ->first();


        return view('content.promo.transaksigrab', compact('saldos','trans','wilayah','ada','potongan','user'));

    }

    public function gettoken(Request $request)
    { 

    	date_default_timezone_set('Asia/Jakarta');
        $usernyah = Auth::user();

		if(!$usernyah){
			$user = Users::where("email", substr(csrf_token(),0,7).'@gmail.com')
			->first();
		} else {
			$user = Auth::user();
		}

        $tokens = Users::where(['id'=>$user->id])
        ->update(['fcm_token'=>$request->fcmtoken]);

        $arrayNames = array(    
            'actions' => 'Berhasil',
        );

        return response()->json($arrayNames);

    }

    public function grabdaftar(){

    	return view('content.promo.daftar');

    }

    public function daftarstore(Request $request)
    { 

    	date_default_timezone_set('Asia/Jakarta');
        $usernyah = Auth::user();

		if(!$usernyah){
			$user = Users::where("email", substr(csrf_token(),0,7).'@gmail.com')
			->first();
		} else {
			$user = Auth::user();
		}

		$cektransaksi1 = Transaksi::where("user_id", $user->id)
		->orderBy("id", "desc")
		->first();

		$tokens = Users::where(['id'=>$user->id])
        ->update(['no_hp'=>$request->nohp, 'name'=>$request->nama, 'token'=> '123456', 'guide'=> '1','wilayah_id' => $cektransaksi1 ? $cektransaksi1->wilayah_id : NULL]);

		// ===== DAFTAR KE PETUGAS MEMBER ====

		$cektransaksi = Transaksi::where("user_id", $user->id)
		->orderBy("id", "desc")
		->first();

		$cekmember = UserMembers::where("member_id", $user->id)
        ->first();

        if(!$cekmember){

            $create = new UserMembers();
            $create->member_id = $user->id;
            $create->user_id = $cektransaksi->petugas_id;
            $create->transaction_id = $cektransaksi->id;
            $create->save();

        }

        // ==== SELESAI ===

        $arrayNames = array(    
            'actions' => 'Berhasil',
        );

        return response()->json($arrayNames);

    }

    public function limas(Request $request)
    { 

    	$cekada = Transaksi::select("posts.user_id","posts.code_id","transactions.id","transaction_details.post_id")
    	->join("transaction_details", "transactions.id", "=", "transaction_details.transaction_id")
    	->join("posts", "transaction_details.post_id", "=", "posts.id")
    	->join("wilayah", "transactions.wilayah_id", "=", "wilayah.id")
    	->join("orders", "transactions.id", "=", "orders.transaction_id")
    	->where("posts.code_id", 17)
    	->where("posts.name","5 Kg (Min : 5)")
    	->where("orders.voucherdet_id", NULL)
    	->get();


    	foreach($cekada as $ada){

    		$getpost = Posts::where("user_id", $ada->user_id)
    		->where("code_id", $ada->code_id)
    		->where("name", "5 Kg")
    		->first();

    		$update = TransaksiDetails::where(['transaction_id'=>$ada->id, 'post_id'=>$ada->post_id])
            ->update(['post_id'=>$getpost->id]);

            $order = Order::where("transaction_id", $ada->id)
            ->first();

            $updateorder = Order::where(['transaction_id'=>$ada->id])
            ->update(['voucherdet_id'=>"147504"]);

            $detail = OrderDetails::where("order_id", $order->id)
            ->where("post_id", $ada->post_id)
            ->first();

            $total = $detail->qty * 64000;


            $updateorders = OrderDetails::where(['id'=>$detail->id])
            ->update(['post_id'=>$getpost->id, 'amount'=>$total]);


    	}

    }

}
