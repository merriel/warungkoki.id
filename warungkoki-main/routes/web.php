<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/debug-sentry', function () {
    throw new Exception('My first Sentry error!');
});

Route::get('/upload/karyawan', 'ProfileController@karyawan')->name('uploadkaryawan.index');

Route::get('/promo', 'PromoController@index')->name('promo.index');
Route::get('/promo/detail', 'PromoController@detail')->name('promo.detail');
Route::get('/promo/category', 'PromoController@category')->name('promo.category');
Route::get('/promo/iklan', 'PromoController@iklan')->name('promo.iklan');
Route::get('/promo/warungkoki', 'PromoController@warungkoki')->name('promo.warungkoki');

Route::post('promo/fcmtoken', 'PromoController@gettoken')->name('TokenFCM2');

Route::get('/promo/grab', 'PromoController@grab')->name('promo.grab');
Route::post('/promo/grab/ambil', 'PromoController@grabambil')->name('promo.grab.ambil');
Route::get('/promo/grab/rincian', 'PromoController@grabrincian')->name('promo.grab.rincian');
Route::post('/promo/grab/bayar', 'PromoController@grabbayar')->name('promo.grab.bayar');
Route::get('/promo/grab/transaksi', 'PromoController@grabtransaksi')->name('promo.grab.transaksi');
Route::get('/promo/grab/daftar', 'PromoController@grabdaftar')->name('promo.grab.daftar');
Route::post('/promo/grab/daftarstore', 'PromoController@daftarstore')->name('promo.grab.daftarstore');
Route::get('/login2', 'Auth\LoginController@login2')->name('login2');

Route::get('/promo/shell', 'PromoController@shell')->name('promo.shell');
Route::post('/promo/shell/ambil', 'PromoController@shellambil')->name('promo.shell.ambil');
Route::get('/promo/shell/pilih', 'PromoController@pilih')->name('promo.shell.pilih');
Route::post('/promo/shell/pilihproduk', 'PromoController@pilihproduk')->name('promo.shell.pilihproduk');

Route::get('/test22', 'HomeController@test')->name('home.test');

Route::get('/users/bayar', 'BayarController@index');
Route::get('/users/bayar/reedem_point', 'BayarController@reedem_point');
Route::get('/users/bayar/validasi', 'BayarController@validasiwilayah')->name('validasiwilayahbayar');
Route::post('/users/bayar/saldo', 'BayarController@saldo')->name('bayar.saldo');
Route::post('/users/bayar/saldo/point', 'BayarController@saldo_point')->name('bayar.saldo.point');
Route::post('/users/bayar/cash', 'BayarController@cash')->name('bayar.cash');
Route::get('/users/bayar/konfirm', 'BayarController@konfirm')->name('bayar.konfirm');

Route::post('/order/store2', 'OrderController@submitOrder')->name('order.store2');

Route::get('/users/transaksi/detail2', 'TransaksiController@transaksiuserdetails');

Route::post('/xhome/bayaronline', 'XhomeController@bayaronline')->name('xhome.bayaronline');

Route::get('/testing22xx', 'OrderController@testing');

Route::get('/tesnotif', function () {
    return view('welcome');
});
	
Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    // return what you want
});

Route::get('/clear-config', function() {
    $exitCode = Artisan::call('config:clear');
    // return what you want
});

Route::get('/error', function () {
    return view('splash.error');
});

Auth::routes();

// Route::get('/masuk', 'LoginController@showLoginForm')->name('login');

Route::get('/', function () {
    return view('splash.index');
});

Route::get('/home3', 'HomeController@belumlogin');
Route::get('home3/detail/{id}', 'HomeController@belumlogindetail');

Route::get('/intro', 'LoginController@intro')->name('intro');

Route::get('/login/scan', 'LoginController@loginscan')->name('loginscan');

Route::post('login/user', 'LoginController@loginUser')->name('login_submit');
Route::get('/logins', 'LoginController@showLoginForm')->name('login.user');
Route::post('logins/store', 'LoginController@store')->name('StoreUsers');
Route::post('logins/register', 'LoginController@register')->name('registersubmit');
Route::get('/confirmations/{id}', 'LoginController@konfirmasi');
Route::get('/viewconfirm', 'LoginController@showConfirmationInfo')->name('login.confirm');

Route::get('/loginiolo', function () {
    return view('auth.loginiolo');
});

Route::get('/siaga', function () {
    return view('siaga.index');
});

Route::get('/siaga/aksi', function () {
    return view('siaga.aksi');
});

Route::get('/home/detail/{id}', 'UserHomeController@homedetail');

Route::get('company/profilehome/{id}', 'CompanyController@detailhome');

Route::get('/kategori/home/{id}', 'UserHomeController@homekategori');

Route::get('/register', 'LoginController@showRegisterForm')->name('register.user');
Route::post('/register/ambilkabkot', 'LoginController@ambilkabkot')->name('register.ambilkabkot');

Route::get('/email', function () {
    return view('email.index');
});

Route::get('produk/varian', 'ProductController@varian')->name('product.varian');
Route::get('/search', 'UserHomeController@search');
Route::post('/search/pilihtoko', 'SearchController@pilihtoko')->name('pilihtoko');
Route::post('/search/pilihtoko/store', 'SearchController@pilihtokostore')->name('pilihtoko.store');
Route::get('/banners/detail', 'UserHomeController@bannerdetail');

Route::get('auth/google', 'Auth\LoginController@redirectToGoogle');
Route::get('auth/google/callback', 'Auth\LoginController@handleGoogleCallback');

Route::post('/notification/handler', 'OrderController@notificationHandler')->name('notification.handler');
Route::group(['middleware' => 'auth'], function(){

	// Route::get('/', 'HomeController@index');

	Route::get('/promo/limas', 'PromoController@limas')->name('promo.limas');

	Route::get('/home', 'HomeController@index')->name('homes');

	Route::get('/home/produk', 'HomeController@produk')->name('homes.produk');

	Route::get('/xhome', 'XhomeController@index');

	Route::post('/finish', function(){
	    return redirect()->route('home');
	})->name('order.finish');

	Route::post('/order/store', 'OrderController@submitOrder')->name('order.store');
	Route::post('/order/store/delivery', 'OrderController@submitOrderDelivery')->name('order.storedelivery');

	Route::get('/produk', 'ProductController@index');
	Route::post('produk/store', 'ProductController@store')->name('simpanproduct');
	Route::post('produk/delete', 'ProductController@delete')->name('hapusproduct');
	Route::post('produk/update', 'ProductController@update')->name('updateproduct');
	Route::get('produk/getprod', 'ProductController@getproduk')->name('getproduct2');
	
	Route::get('produk/stock2', 'ProductController@stock2')->name('product.stock2');	
	Route::post('produk/stock/notready2', 'ProductController@stocknotready2')->name('stock.notready2');
	Route::post('produk/stock/ready2', 'ProductController@stockready2')->name('stock.ready2');
	Route::get('produk/konfirmasi', 'ProductController@konfirmasi')->name('product.konfirmasi');
	Route::get('/produk/manual', 'ProductController@manual');
	Route::post('/produk/barcode', 'ProductController@barcode')->name('produk.barcode');
	Route::get('/produk/db', 'ProductController@db');
	Route::get('/produk/promo', 'ProductController@productpromo');


	Route::get('produk/stock', 'StockController@index')->name('product.stock');
	Route::post('produk/stock/notready', 'StockController@notready')->name('stock.notready');
	Route::post('produk/stock/ready', 'StockController@ready')->name('stock.ready');
	Route::post('produk/stock/update', 'StockController@update')->name('stock.update');
	Route::post('produk/stock/editupdate', 'StockController@editupdate')->name('stock.editupdate');
	Route::get('stock/inbound', 'StockController@inbound')->name('stock.inbound');
	Route::get('stock/retur', 'StockController@retur')->name('stock.retur');
	Route::get('stock/intratoko', 'StockController@intratoko')->name('stock.intratoko');
	Route::post('stock/confirm', 'StockController@confirm')->name('stock.confirm');
	Route::post('stock/approve', 'StockController@approve')->name('stock.approve');
	Route::get('produk/stock/edit', 'StockController@edit')->name('product.stock.edit');

	// reedem point
	Route::get('/reedem_point', 'ReedemPointController@index');
	Route::get('/reedem_point/produk', 'ReedemPointController@getProduct')->name('reedem_point.product');
	Route::get('/reedem_point/keranjang', 'ReedemPointController@getKeranjang')->name('reedem_point.keranjang');
	Route::get('/reedem_point/keranjang/count', 'ReedemPointController@getCountKeranjang')->name('reedem_point.keranjang.count');

	//request to api
	Route::post('/reedem_point/product/variant', 'ReedemPointController@getVariantByIdProduct')->name('reedem_point.product.variant');

	Route::post('/reedem_point/keranjang/add', 'ReedemPointController@addKeranjang')->name('reedem_point.keranjang.add');
	Route::post('/reedem_point/keranjang/sub', 'ReedemPointController@subKeranjang')->name('reedem_point.keranjang.sub');
	Route::post('/reedem_point/keranjang/updateqty', 'ReedemPointController@updateQtyKeranjang')->name('reedem_point.keranjang.updateqty');
	
	Route::get('/reedem_point/checkout/validasi', 'ReedemPointController@validasiTokenWilayah')->name('reedem_point.checkout.validasi');
	
	
	
	Route::get('/reedem_point/history', 'ReedemPointController@getHistoryTransaction')->name('reedem_point.history_transaction');

	Route::post('principle/post', 'PrincipleController@upload')->name('uploadpost');
	Route::post('principle/cancel', 'PrincipleController@cancel')->name('cancelimages');
	Route::post('principle/store', 'PrincipleController@store')->name('simpanpost');
	Route::get('principle/createpetugas', 'PrincipleController@createpetugas');
	Route::post('principle/createpetugas/store', 'PrincipleController@storepetugas')->name('simpanpetugas');
	Route::post('principle/createpetugas/delete', 'PrincipleController@deletepetugas')->name('hapuspetugas');
	Route::post('principle/createpetugas/update', 'PrincipleController@updatepetugas')->name('updatepetugas');
	Route::get('principle/countpesan', 'PrincipleController@countpesan')->name('countpesan');
	Route::get('users/countpesan', 'PrincipleController@countpesanusers')->name('countpesanusers');
	Route::post('principle/createpetugas/reset', 'PrincipleController@resetpetugas')->name('resetpetugas');

	Route::get('/wilayah', 'WilayahController@index');
	Route::post('wilayah/store', 'WilayahController@store')->name('simpanwilayah');
	Route::post('wilayah/view', 'WilayahController@view')->name('viewwilayah');
	Route::post('wilayah/update', 'WilayahController@update')->name('updatewilayah');
	Route::post('wilayah/delete', 'WilayahController@delete')->name('hapuswilayah');

	Route::get('/principle/komentar', 'KomentarController@index');
	Route::get('/principle/komentar/{id}', 'KomentarController@detail');
	Route::post('/principle/komentar/baca', 'KomentarController@bacadiskusi')->name('bacadiskusi');
	Route::post('/users/komentar/baca', 'KomentarController@bacadiskusiusers')->name('bacadiskusiusers');
	Route::get('/users/komentar/{id}', 'KomentarController@detailusers');

	Route::get('/garansi', 'GaransiController@index');
	Route::post('/garansi/store', 'GaransiController@store')->name('simpangaransi');
	Route::post('/garansi/delete', 'GaransiController@delete')->name('hapusgaransi');
	Route::post('/garansi/update', 'GaransiController@update')->name('updategaransi');

	Route::get('/voucher', 'VoucherController@index');
	Route::get('/voucher/data', 'VoucherController@data')->name('voucher.data');
	Route::post('/voucher/store', 'VoucherController@store')->name('voucher.store');
	Route::post('/voucher/delete', 'VoucherController@delete')->name('voucher.delete');
	Route::get('/voucher/pilih', 'VoucherController@pilih')->name('voucher.pilih');
	Route::get('/voucher/print', 'VoucherController@cetak')->name('voucher.cetak');
	Route::get('/voucher/cek', 'VoucherController@cek')->name('voucher.cek');

	Route::get('/users', 'UserHomeController@index');
	Route::get('users/detail/{id}', 'UserHomeController@detail');
	Route::get('users/deals', 'UserHomeController@deals');
	Route::get('users/myproducts', 'UserHomeController@myproducts');
	Route::get('users/rewards', 'UserHomeController@rewards');
	Route::get('users/deals/{id}', 'UserHomeController@dealdetails');
	Route::post('users/fcmtoken', 'UserHomeController@gettoken')->name('TokenFCM');
	Route::get('/users/getcountmessages', 'UserHomeController@getcountmessages')->name('GetCountMessages');
	Route::get('/kategori', 'UserHomeController@kategori');
	Route::post('/users/follow', 'UserHomeController@followcompany')->name('followcompany');
	Route::post('/users/unfollow', 'UserHomeController@unfollowcompany')->name('unfollowcompany');
	Route::post('/users/tambahdiskusi', 'UserHomeController@tambahdiskusi')->name('tambahdiskusi');
	Route::post('/users/balasdiskusi', 'UserHomeController@balasdiskusi')->name('balasdiskusi');
	Route::get('/users/komentar', 'KomentarController@komentar');
	Route::post('/users/validasitoken', 'UserHomeController@validasitoken')->name('validasitoken');
	Route::get('/users/getregencies', 'UserHomeController@getregencies')->name('getregencies');
	Route::post('/users/pilihdaerah', 'UserHomeController@pilihdaerah')->name('pilihdaerah');
	Route::get('/users/guides', 'UserHomeController@guides')->name('user.guides');
	Route::get('/users/guides/selesai', 'UserHomeController@guideselesai')->name('selesai.guide');
	Route::post('/users/pengaturan/selesai', 'UserHomeController@pengaturanselesai')->name('selesai.pengaturan');
	

	Route::get('/company/profile', 'CompanyController@detail');
	Route::post('/company/profile/kategori', 'CompanyController@kategori')->name('company.kategori');
	Route::post('/company/profile/cariproduk', 'CompanyController@cari')->name('company.cariproduk');
	Route::get('/myproducts/countsaldo', 'UserHomeController@countsaldo')->name('getcountSaldo');
	Route::get('/home/counthome', 'UserHomeController@counthome')->name('getcounthome');

	Route::get('/otherapps', 'UserHomeController@otherapps');

	
	Route::post('/search/toko', 'SearchController@caritoko')->name('caritoko');
	Route::get('/cari', 'SearchController@cariproduk')->name('cariproduk');

	Route::get('users/challanges', 'UserHomeController@challanges');
	Route::get('users/challanges/{id}', 'UserHomeController@challangedetails');
	Route::post('users/challanges/ikut', 'UserHomeController@ikutchallanges')->name('ikutchallanges');

	Route::get('/mypost', 'MypostController@index');
	Route::get('mypost/getdatadeals', 'MypostController@getdatadeals')->name('getpostdeals');
	Route::get('mypost/getdatachallanges', 'MypostController@getdatachallanges')->name('getpostchallanges');
	Route::post('/mypost/hapuspost', 'MypostController@hapuspost')->name('hapuspost');
	Route::get('/mypost/edit', 'MypostController@edit');
	Route::post('mypost/gantigambar', 'MypostController@gantigambar')->name('gantigambar');
	Route::post('/mypost/update', 'MypostController@update')->name('updatepost');

	Route::get('/reedem/view', 'ReedemController@view');
	Route::post('/reedem/sendnotif', 'ReedemController@sendnotif')->name('sendnotif');
	Route::post('/reedem/transaksi', 'ReedemController@transaksi')->name('transaksireedem');
	Route::post('/reedem/konfirmasi', 'ReedemController@konfirmasireedem')->name('konfirmasireedem');
	Route::get('/users/reedem', 'ReedemController@index');
	Route::post('/reedem/deals', 'ReedemController@reedemdeals')->name('reedemdeals');
	Route::post('/reedem/keranjang', 'ReedemController@keranjangreedem')->name('keranjangreedem');
	Route::post('/reedem/lihatsaldo', 'ReedemController@lihatsaldo')->name('lihatsaldo');
	Route::post('/reedem/keranjangdeals', 'ReedemController@keranjangreedemdeals')->name('keranjangreedemdeals');
	Route::get('/reedem/showqris', 'ReedemController@showqris')->name('reedem.showqris');
	Route::post('/reedem/bayarcash', 'ReedemController@bayarcash')->name('reedem.bayarcash');
	Route::get('/reedem/bayarselesai', 'ReedemController@bayarselesai')->name('reedem.bayarselesai');
	Route::get('/reedem/bayarpending', 'ReedemController@bayarpending')->name('reedem.bayarpending');
	Route::post('/reedem/penjual', 'ReedemController@penjual')->name('reedem.penjual');

	Route::post('/reedem/scantimbangan', 'ReedemController@scantimbangan')->name('scan.timbangan');
	Route::post('/reedem/scanhapus', 'ReedemController@scanhapus')->name('scan.hapus');

	Route::get('/keranjangreedem', 'ReedemController@keranjang');
	Route::get('/keranjangreedem/count', 'ReedemController@reedemcount')->name('GetCountKeranjangReedem');
	Route::post('/keranjangreedem/delete', 'ReedemController@reedemdestroy')->name('removekeranjangreedem');
	Route::get('/keranjangreedem/cekwilayah', 'ReedemController@cekwilayah')->name('cekwilayah');
	Route::post('/keranjangreedem/proses', 'ReedemController@proses')->name('proseskeranjangreedem');
	Route::post('/keranjangreedem/prosesdeliver', 'ReedemController@prosesdelivery')->name('prosesreedemdelivery');
	Route::post('/keranjangreedem/catatan', 'ReedemController@catatan')->name('tambahcatatan');
	Route::post('/keranjangreedem/planing', 'ReedemController@planreedem')->name('planreedem');
	Route::get('/keranjangreedem/cekreedem', 'ReedemController@cekreedem')->name('cekreedem');

	Route::get('/messages', 'MessagesController@index');
	Route::post('/messages/show', 'MessagesController@show')->name('messages.show');
	Route::get('/messages/superurgent', 'MessagesController@super')->name('messages.super');
	Route::get('/messages/count', 'MessagesController@count')->name('messages.count');
	Route::post('/messages/poin', 'MessagesController@poin')->name('messages.poin');
	Route::post('/messages/cekpoin', 'MessagesController@cekpoin')->name('messages.cekpoin');

	Route::get('/messages/detail', function () {
	    return view('content.messages.detail');
	});

	Route::get('/keranjang', 'KeranjangController@index');
	Route::post('/keranjang/masuk', 'KeranjangController@masuk')->name('masukkeranjang');
	Route::post('/keranjang/masuk2', 'KeranjangController@masuk2')->name('masukkeranjang2');
	Route::post('/keranjang/delete', 'KeranjangController@destroy')->name('removekeranjang');
	Route::get('/keranjang/count', 'KeranjangController@count')->name('GetCountKeranjang');
	Route::post('/keranjang/selesaibayar', 'KeranjangController@selesaibayar')->name('selesaibayar');
	Route::post('/keranjang/editqty', 'KeranjangController@editqty')->name('editqty');
	Route::post('/keranjang/updateqty', 'KeranjangController@updateqty')->name('updateqty');
	Route::post('/keranjang/updatekeranjang', 'KeranjangController@updatekeranjang')->name('updatekeranjang');
	Route::post('/keranjang/notif', 'ReedemController@notifpetugas')->name('notif.petugas');
	Route::post('/keranjang/min', 'KeranjangController@min')->name('keranjang.min');
	Route::post('/keranjang/voucher', 'KeranjangController@voucher')->name('keranjang.voucher');
	Route::post('/keranjang/nolbayar', 'KeranjangController@nolbayar')->name('keranjang.nolbayar');
	Route::get('/keranjang/promo', 'KeranjangController@promo')->name('keranjang.promo');
	Route::post('/keranjang/pakaivoucher', 'KeranjangController@pakaivoucher')->name('keranjang.pakaivoucher');
	Route::post('/keranjang/removevoucher', 'KeranjangController@removevoucher')->name('keranjang.removevoucher');

	Route::get('/favorite', 'FavoriteController@index');
	Route::post('/favorite/masuk', 'FavoriteController@masuk')->name('masukfavorite');
	Route::post('/favorite/keluar', 'FavoriteController@keluar')->name('keluarfavorite');


	Route::get('/testing', 'OrderController@testing');

	Route::get('/newpost', function () {
	    return view('content.newpost.index');
	});

	Route::get('/tests', function () {
	    return view('testing');
	});

	Route::get('/notif', 'ProfileController@testing');

	Route::get('/petugas', 'UserHomeController@petugas');
	Route::get('/petugas/pengambilan', 'UserHomeController@listpengambilan');
	Route::get('/scanner', 'UserHomeController@scanner');
	Route::get('/scanner/users', 'UserHomeController@scannerusers');
	Route::get('/petugas/transaksihariini', 'UserHomeController@petugastransaksihariini');
	Route::get('/petugas/lihattransaksi', 'UserHomeController@petugaslihattransaksi')->name('petugas.lihattransaksi');
	Route::get('/petugas/transaksihariinirupiah', 'UserHomeController@petugastransaksihariinirupiah');
	Route::get('/petugas/retur', 'UserHomeController@petugasretur');
	Route::get('/petugas/retur/detail', 'UserHomeController@petugasreturdetail');
	Route::post('/petugas/retur/update', 'UserHomeController@petugasreturupdate')->name('petugas.returupdate');
	Route::get('/home/petugas/rincianmember', 'HomeController@rincianmember');
	Route::get('/home/petugas/rincianvoucher', 'HomeController@rincianvoucher');

	Route::get('/transaksi', 'TransaksiController@index');
	Route::get('/users/transaksi', 'TransaksiController@transaksiusers');
	Route::get('/users/transaksi/detail', 'TransaksiController@transaksiuserdetails');
	Route::get('/transaksi/cash', 'TransaksiController@cash')->name('transaksicash');
	Route::post('/transaksi/data', 'TransaksiController@getdata')->name('gettransaksi');
	Route::get('/transaksi/datatrans', 'TransaksiController@data')->name('getdatatransaksi');
	Route::get('/transaksi/reedem', 'TransaksiController@reedem')->name('getdatareedem');
	Route::get('/transaksi/validasikadaluarsa', 'TransaksiController@validasikadaluarsa')->name('validasikadaluarsa');
	Route::get('/users/transaksi/printexcel', 'TransaksiController@printexcel');
	Route::get('/users/transaksi/invoice', 'TransaksiController@invoice');
	Route::post('/transaksi/upload', 'TransaksiController@upload')->name('transaksi.upload');
	Route::post('/transaksi/storeretur', 'TransaksiController@storeretur')->name('transaksi.storeretur');
	Route::post('/transaksi/uploadktp', 'TransaksiController@uploadktp')->name('transaksi.uploadktp');

	Route::post('/transaksi/petugas/approve', 'TransaksiController@petugasApprove')->name('transaksi.petugas.approve');

	Route::get('/transaksi/supervisor', 'TransaksiController@supervisorpenjualan')->name('transaksi.supervisor.penjualan');
	Route::post('/transaksi/supervisor/data', 'TransaksiController@datapenjualan')->name('transaksi.datapenjualan');
	Route::post('/transaksi/supervisor/view', 'TransaksiController@viewpenjualan')->name('transaksi.viewpenjualan');
	Route::get('/home/supervisor/rincian', 'StockController@rincian');
	Route::post('/home/supervisor/update', 'StockController@perubahanstock')->name('perubahanstock.approve');
	Route::post('/home/supervisor/tolak', 'StockController@tolakstock')->name('perubahanstock.tolak');

	Route::get('principle', 'PrincipleController@index');

	Route::get('/stocks', 'StocksController@index')->name('stocks.index');
	Route::post('/stocks/view', 'StocksController@view')->name('stocks.view');

	Route::get('outlet', 'OutletController@index');

	Route::get('/profile', 'ProfileController@index');
	Route::post('/profile/update', 'ProfileController@update')->name('updateprofile');
	Route::get('/getprofile', 'ProfileController@get')->name('getprofile');

	Route::get('/saldo', function () {
	    return view('content.saldo.index');
	});

	Route::get('/saldo/add', 'UserHomeController@saldoadd');
	Route::get('/saldo/users', 'UserHomeController@saldousers')->name('saldo.users');
	Route::post('/saldo/store', 'UserHomeController@saldostore')->name('saldo.store');
	Route::get('/saldo/history', 'UserHomeController@saldohistory')->name('saldo.history');

	Route::get('/users/loyalty', 'LoyaltyController@index');

	Route::get('/report', 'ReportController@index');
	Route::get('/report/detail', 'ReportController@detail');
	Route::get('/report/printexcel', 'ReportController@printexcel');

	Route::get('/alamatuser', 'AlamatController@index');
	Route::post('/alamatuser/store', 'AlamatController@store')->name('alamat.store');
	Route::post('/alamatuser/pilih', 'AlamatController@pilih')->name('alamat.pilih');
	Route::post('/alamatuser/ambilkec', 'AlamatController@ambilkec')->name('alamat.ambilkec');
	Route::post('/alamatuser/utama', 'AlamatController@utama')->name('alamat.utama');
	Route::get('/alamatuser/gantialamat', 'AlamatController@gantialamat')->name('alamat.ganti');
	Route::get('/alamatuser/cek', 'AlamatController@cek')->name('alamat.cek');
	Route::get('/alamatuser/add', 'AlamatController@add')->name('alamat.add');
	Route::post('/alamatuser/hapus', 'AlamatController@hapus')->name('alamat.hapus');
	Route::get('/alamatuser/edit', 'AlamatController@edit')->name('alamat.edit');
	Route::post('/alamatuser/update', 'AlamatController@update')->name('alamat.update');

	Route::get('/summary', 'SummaryController@index');
	Route::get('/reedemtoday', 'ReedemController@reedemtoday');
	Route::get('/countreedem', 'ReedemController@countreedem')->name('countreedem');
	Route::get('/reedemdelivery', 'ReedemController@reedemdelivery')->name('reedemdelivery');
	Route::get('/countdelivery', 'ReedemController@countdelivery')->name('countdelivery');
	Route::post('/reedemdelivery/setuju', 'ReedemController@setujudelivery')->name('setujudelivery');
	Route::post('/reedemdelivery/tolak', 'ReedemController@tolakdelivery')->name('tolakdelivery');
	Route::post('/reedemdelivery/updateplan', 'ReedemController@updateplan')->name('updateplan');
	Route::post('/reedemready', 'ReedemController@reedemready')->name('reedemready');
	Route::post('/reedemselesai', 'ReedemController@reedemselesai')->name('reedemselesai');

	Route::get('/voucherundian', 'VoucherUndianController@index');
	Route::get('/voucherundian/detail', 'VoucherUndianController@detail');

	// Route::get('/tokenbca', 'BCAController@initialToken')->name('initialToken');
	Route::get('/oauth/token', 'BCAController@callback')->name('bca.callback');
	Route::get('/redirect', 'BCAController@redirect')->name('bca.redirect');

	Route::post('/doku/ovoid', 'DokuController@ovoid')->name('update.ovoid');

	Route::post('/doku/bayar', 'DokuController@payment')->name('bayar.doku');
	Route::post('/doku/bayar/sukses', 'DokuController@ovosukses')->name('bayar.doku.sukses');
	Route::post('/doku/bayar2', 'DokuController@payment2')->name('bayar.doku2');

	Route::post('/gopay/bayar', 'MidtransController@gopay')->name('bayar.gopay');

	// ===== RETAILER ======

	Route::get('retailer/detail/{id}', 'RetailerController@detail');
	Route::get('retailer/admin', 'RetailerController@admin');
	Route::get('retailer/ubah', 'RetailerController@ubah');
	Route::get('retailer/history', 'RetailerController@history');
	Route::get('/retailer/lihat', 'RetailerController@lihat');

	// ======= BAZAAR =======

	Route::get('/bazaar/home', 'BazaarController@index');
	Route::get('/bazaar/keranjang', 'BazaarController@keranjang');
	Route::get('/bazaar/detail/{id}', 'BazaarController@detail');
	Route::get('/bazaar/count', 'BazaarController@count')->name('bazaar.keranjang');
	Route::get('/bazaar/bayar', 'BazaarController@bayar');
	Route::get('/bazaar/transaksi', 'BazaarController@transaksi');
	Route::get('/bazaar/transaksi/detail', 'BazaarController@transaksidetail');

	// ========== WORKING SPACE =========

	Route::get('/working-space', function () {
	    return view('working-space.index');
	});

	Route::get('/working-space/home', 'WorkingSpaceController@index');
	Route::get('/working-space/detail', 'WorkingSpaceController@detail');
	Route::get('/working-space/booked', 'WorkingSpaceController@booked');
	Route::post('/working-space/caridesk', 'WorkingSpaceController@caridesk')->name('workingspace.caridesk');
	Route::post('/working-space/pilih', 'WorkingSpaceController@pilih')->name('workingspace.pilih');
	Route::post('/working-space/total', 'WorkingSpaceController@total')->name('workingspace.total');
	Route::post('/working-space/order', 'WorkingSpaceController@order')->name('workingspace.order');
	Route::get('/working-space/history', 'WorkingSpaceController@history')->name('workingspace.history');
	Route::get('/working-space/detailtransaksi', 'WorkingSpaceController@detailtransaksi')->name('workingspace.detailtransaksi');

	Route::get('/working-space/email', function () {
	    return view('email.bayarwsonline');
	});

	Route::get('/debug-sentry', function () {
	    throw new Exception('My first Sentry error!');
	});

	// ============ DELIVERY ==============

	Route::get('/xhome/wilayah', 'XhomeController@wilayah');
	
	Route::post('/xhome/wilayah/cariproduk', 'XhomeController@cari')->name('xhome.wilayah.cariproduk');
	Route::get('xhome/detail/{id}', 'XhomeController@detail');

	Route::get('/xhome/isisaldo', 'XhomeController@isisaldo')->name('xhome.isisaldo');
	Route::post('/xhome/verifikasi', 'XhomeController@verifikasi')->name('xhome.verifikasi');
	Route::post('/xhome/verifikasi2', 'XhomeController@verifikasi2')->name('xhome.verifikasi2');
	Route::get('/xhome/verifikasi3', 'XhomeController@verifikasi3')->name('xhome.verifikasi.kadaluarsa');

	Route::post('/xhome/keranjang/masuk', 'XhomeController@masukkeranjang')->name('xhome.keranjang.masuk');
	Route::post('/xhome/keranjang/delete', 'XhomeController@deletekeranjang')->name('xhome.keranjang.delete');
	Route::get('/xhome/keranjang/count', 'XhomeController@countkeranjang')->name('xhome.keranjang.count');
	Route::get('/xhome/history/count', 'XhomeController@counthistory')->name('xhome.history.count');
	Route::get('/xhome/keranjang', 'XhomeController@keranjang');
	Route::post('/xhome/keranjang/checklist', 'XhomeController@checklist')->name('xhome.checklist');
	Route::post('/xhome/keranjang/nochecklist', 'XhomeController@nochecklist')->name('xhome.nochecklist');
	Route::post('/xhome/keranjang/checklistall', 'XhomeController@checklistall')->name('xhome.checklistall');
	Route::post('/xhome/keranjang/nochecklistall', 'XhomeController@nochecklistall')->name('xhome.nochecklistall');
	Route::get('/xhome/keranjang/total', 'XhomeController@totalkeranjang')->name('xhome.keranjang.total');

	Route::get('/xhome/delivery', 'XhomeController@delivery');
	Route::post('/xhome/delivery/harga', 'XhomeController@deliveryharga')->name('xhome.delivery.harga');
	Route::post('/xhome/delivery/jam', 'XhomeController@deliveryjam')->name('xhome.delivery.jam');
	Route::post('/xhome/delivery/tanggal', 'XhomeController@deliverytanggal')->name('xhome.delivery.tanggal');
	Route::get('/xhome/delivery/count', 'XhomeController@countdelivery')->name('xhome.countdelivery');
	Route::post('/xhome/kurir/selesai', 'XhomeController@kurirselesai')->name('xhome.kurir.selesai');
	Route::get('/xhome/delivery/countuser', 'XhomeController@countdeliveryuser')->name('xhome.countdeliveryuser');
	Route::post('/xhome/kurir/proses', 'XhomeController@kurirproses')->name('xhome.kurir.proses');

	Route::get('/xhome/kurirtoko', 'XhomeController@kurirtoko');

	Route::get('/xhome/wilayah/kategori', 'XhomeController@kategori')->name('xhome.wilayah.kategori');

	Route::get('/xhome/favorite', 'XhomeController@favorite');

	Route::get('/xhome/bayar', 'XhomeController@bayar');
	Route::post('/xhome/bayar/delivery', 'XhomeController@bayardelivery')->name('xhome.bayar.delivery');

	Route::get('/xhome/petugas', 'XhomeController@petugas');
	Route::get('/xhome/petugas/detail', 'XhomeController@petugasdetail');
	Route::post('/xhome/petugas/proses', 'XhomeController@petugasproses')->name('xhome.petugas.proses');
	Route::post('/xhome/petugas/cancel', 'XhomeController@petugascancel')->name('xhome.petugas.cancel');
	Route::post('/xhome/petugas/aktifkurir', 'XhomeController@aktifkurir')->name('petugas.aktifkurir');

	Route::get('/xhome/history', 'XhomeController@history');
	Route::get('/xhome/history/detail', 'XhomeController@historydetail');
	Route::post('/xhome/history/selesai', 'XhomeController@historyselesai')->name('xhome.history.selesai');

	Route::post('/xhome/upload', 'XhomeController@upload')->name('xhome.upload');
	Route::get('/xhome/validasi', 'XhomeController@validasi')->name('xhome.validasi');
	
	Route::get('/xhome/diskon', 'XhomeController@diskon')->name('xhome.diskon');

	Route::get('/xhome/petugasmember', 'ProductController@members')->name('member.petugas');

	// ============ MISSION ==============

	Route::get('/xmission', 'XMissionController@index');
	Route::get('/xmission/detail', 'XMissionController@detail');
	Route::post('/xmission/ikut', 'XMissionController@ikut')->name('xmission.ikut');
	Route::get('/xmission/count', 'XMissionController@count')->name('xmission.count');
	Route::get('/xmission/countreward', 'XMissionController@countreward')->name('xmission.countreward');
	Route::get('/xmission/proses', 'XMissionController@proses')->name('xmission.proses');
	Route::get('/xmission/proses/detail', 'XMissionController@prosesdetail')->name('xmission.proses.detail');
	Route::post('/xmission/approve', 'XMissionController@approve')->name('xmission.approve');
	Route::get('/xmission/reward', 'XMissionController@reward')->name('xmission.reward');
	Route::get('/xmission/reward/detail', 'XMissionController@rewarddetail')->name('xmission.reward.detail');
	Route::post('/xmission/claim', 'XMissionController@claim')->name('xmission.claim');
	Route::get('/xmission/hadiah', 'XMissionController@hadiah');
	Route::get('/xmission/reward/games', 'XMissionController@games');
	Route::post('/xmission/gethadiah', 'XMissionController@gethadiah')->name('xmission.gethadiah');
	Route::post('/xmission/voucher', 'XMissionController@voucher')->name('xmission.voucher');
	Route::get('/xmission/cetak', 'XMissionController@cetak')->name('xmission.cetak');
	Route::get('/datahadiah', 'XMissionController@datahadiah')->name('datahadiah.index');
	Route::get('/reedemmission', 'XMissionController@reedemmission')->name('reedemmission.index');
	Route::get('/xmission/game', function () {
	    return view('xmission.game.index');
	});

	Route::get('/search/notif', 'SearchController@notif')->name('seacrh.notif');
	
});

