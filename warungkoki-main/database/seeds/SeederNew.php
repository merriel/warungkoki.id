<?php

use App\Company;
use App\Wilayah;
use App\Users;
use App\UserCompany;
use App\ImagesPost;
use App\Product;
use App\Posts;
use App\PostImages;
use App\PostAreas;
use App\PostDetails;
use Illuminate\Database\Seeder;

class SeederNew extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rows = [

        	['PT Dua Kelinci','duakelinci@gmail.com','Dua Kelinci','JL Perdamaian No 3 Kota Tangerang Banten','8','Deals','Dua Kelinci Seru','2019-11-01','2019-12-30','100','Berikut Adalah Beberapa produk dari Deals Tersebut','30000','45000','Krip Tortilla','5','01.jpg'],
			['PT Dua Kelinci','duakelinci@gmail.com','Dua Kelinci','JL Perdamaian No 3 Kota Tangerang Banten','8','Deals','Dua Kelinci Seru','2019-11-01','2019-12-30','100','Berikut Adalah Beberapa produk dari Deals Tersebut','30000','45000','Sukro Oven','4','01.jpg'],
			['PT Kobe Indonesia','kobe@gmail.com','Kobe','JL Perdamaian No 3 Kota Tangerang Banten','8','Deals','Kobe Bersahabat Setia','2019-11-01','2019-12-30','100','Berikut Adalah Beberapa produk dari Deals Tersebut','30000','40000','Kobe 200 Gramm','3','02.jpg'],
			['PT Kobe Indonesia','kobe@gmail.com','Kobe','JL Perdamaian No 3 Kota Tangerang Banten','8','Deals','Kobe Bersahabat Setia','2019-11-01','2019-12-30','100','Berikut Adalah Beberapa produk dari Deals Tersebut','30000','40000','Kobe 400 Gramm','3','02.jpg'],
			['PT Trinet Indonesia','trinet@gmail.com','Trinet Indonesia','JL Perdamaian No 3 Kota Tangerang Banten','4','Deals','Trinet Paket GX-06','2019-11-01','2019-12-30','100','Berikut Adalah Beberapa produk dari Deals Tersebut','75000','100000','Trini Band','1','03.jpeg'],
			['PT Trinet Indonesia','trinet@gmail.com','Trinet Indonesia','JL Perdamaian No 3 Kota Tangerang Banten','4','Deals','Trinet Paket GX-06','2019-11-01','2019-12-30','100','Berikut Adalah Beberapa produk dari Deals Tersebut','75000','100000','Trini Imune System Boost','4','03.jpeg'],
			['PT Tigaem Indonesia','tigaem@gmail.com','Tigaem','JL Perdamaian No 3 Kota Tangerang Banten','1','Deals','Paket Kebersihan Bersama','2019-11-01','2019-12-30','100','Berikut Adalah Beberapa produk dari Deals Tersebut','65000','90000','Sapu Tigaem Premium','2','04.jpg'],
			['PT Tigaem Indonesia','tigaem@gmail.com','Tigaem','JL Perdamaian No 3 Kota Tangerang Banten','1','Deals','Paket Kebersihan Bersama','2019-11-01','2019-12-30','100','Berikut Adalah Beberapa produk dari Deals Tersebut','65000','90000','Pelan Tigaem Premium','2','04.jpg'],
			['PT Moreskin Indonesia','moreskin@gmail.com','Mareskin','JL Perdamaian No 3 Kota Tangerang Banten','1','Deals','Moreskin Paket Kecantikan','2019-11-01','2019-12-30','100','Berikut Adalah Beberapa produk dari Deals Tersebut','120000','132000','Moreskin Bedak','2','05.jpg'],
			['PT Moreskin Indonesia','moreskin@gmail.com','Mareskin','JL Perdamaian No 3 Kota Tangerang Banten','1','Deals','Moreskin Paket Kecantikan','2019-11-01','2019-12-30','100','Berikut Adalah Beberapa produk dari Deals Tersebut','120000','132000','Moreskin Lipstik','3','05.jpg'],
			['PT 3M Indonesia','3m@gmail.com','3M','JL Perdamaian No 3 Kota Tangerang Banten','2','Deals','3M Glass Cloth Paket','2019-11-01','2019-12-30','100','Berikut Adalah Beberapa produk dari Deals Tersebut','78000','90000','Glass Cloth 3M','2','06.jpg'],
			['PT 3M Indonesia','3m@gmail.com','3M','JL Perdamaian No 3 Kota Tangerang Banten','2','Deals','3M Glass Cloth Paket','2019-11-01','2019-12-30','100','Berikut Adalah Beberapa produk dari Deals Tersebut','78000','90000','Semprotan Glass Cloth','1','06.jpg'],
			['PT Well Series','wellseries@gmail.com','WellSeries','JL Perdamaian No 3 Kota Tangerang Banten','1','Deals','Paket Jantung Kesehatan','2019-11-01','2019-12-30','100','Berikut Adalah Beberapa produk dari Deals Tersebut','90000','102000','Capsul Pencegah Jantung','3','07.jpeg'],
			['PT Well Series','wellseries@gmail.com','WellSeries','JL Perdamaian No 3 Kota Tangerang Banten','1','Deals','Paket Jantung Kesehatan','2019-11-01','2019-12-30','100','Berikut Adalah Beberapa produk dari Deals Tersebut','90000','102000','Capsul Kesehatan Jantung','4','07.jpeg'],
			['PT Nafoura Indonesia','nafoura@gmail.com','Nafaoura','JL Perdamaian No 3 Kota Tangerang Banten','6','Deals','Paket Minuman Sehat','2019-11-01','2019-12-30','100','Berikut Adalah Beberapa produk dari Deals Tersebut','45000','70000','Kurma Water Rasa Lime','5','08.jpg'],
			['PT Nafoura Indonesia','nafoura@gmail.com','Nafaoura','JL Perdamaian No 3 Kota Tangerang Banten','6','Deals','Paket Minuman Sehat dan Murah','2019-11-01','2019-12-30','100','Berikut Adalah Beberapa produk dari Deals Tersebut','90000','105000','Kurma Water Rasa Lime','4','09.jpg'],
			['PT Nafoura Indonesia','nafoura@gmail.com','Nafaoura','JL Perdamaian No 3 Kota Tangerang Banten','6','Deals','Paket Minuman Sehat dan Murah','2019-11-01','2019-12-30','100','Berikut Adalah Beberapa produk dari Deals Tersebut','90000','105000','Kurma Water Rasa Madu','6','09.jpg'],
			['CV Bubble Bee Sport','buble@gmail.com','BubleBee','JL Perdamaian No 3 Kota Tangerang Banten','3','Deals','Paket Bumblee Bee Sehat','2019-11-01','2019-12-30','100','Berikut Adalah Beberapa produk dari Deals Tersebut','175000','200000','Samsak Bumble Bee','1','10.jpg'],
			['CV Bubble Bee Sport','buble@gmail.com','BubleBee','JL Perdamaian No 3 Kota Tangerang Banten','3','Deals','Paket Bumblee Bee Sehat','2019-11-01','2019-12-30','100','Berikut Adalah Beberapa produk dari Deals Tersebut','175000','200000','Handwrap Everlast','1','10.jpg'],

		];

		foreach ($rows as $data) {

			$company = $data[0];
			$email = $data[1];
			$name = $data[2];
			$alamat = $data[3];
			$kategori = $data[4];
			$type = $data[5];
			$namapaket = $data[6];
			$dari = $data[7];
			$sampai = $data[8];
			$banyak = $data[9];
			$ket = $data[10];
			$act = $data[11];
			$crt = $data[12];
			$prod = $data[13];
			$qty = $data[14];
			$img = $data[15];

			$companies = Company::updateOrCreate([
				'name' => $company,
			]);

			$wilayah = Wilayah::updateOrCreate([
				'company_id' => $companies->id,
				'name' => 'Office',
				'alamat' => $alamat,
			]);

			$users = Users::updateOrCreate([
				'role_id' => '2',
				'name' => $name,
				'email' => $email,
				'alamat' => $alamat,
				'password' => '$2y$10$emvLNtfb23Mn3zze7wSkkuz3nZ2gEK6vziduJC0S9g8v4vXwpt34.',
			]);

			$usercompanies = UserCompany::updateOrCreate([
				'company_id' => $companies->id,
				'wilayah_id' => $wilayah->id,
				'user_id' => $users->id,
			]);

			$imgposts = ImagesPost::updateOrCreate([
				'company_id' => $companies->id,
				'name' => $img,
			]);

			$imgposts = ImagesPost::updateOrCreate([
				'company_id' => $companies->id,
				'name' => $img,
			]);

			$produks = Product::updateOrCreate([
				'company_id' => $companies->id,
				'name' => $prod,
			]);

			$posts = Posts::updateOrCreate([
				'company_id' => $companies->id,
				'kategori_id' => $kategori,
				'type' => $type,
				'name' => $namapaket,
				'dari' => $dari,
				'sampai' => $sampai,
				'banyaknya' => $banyak,
				'desc' => $ket,
				'harga_act' => $act,
				'harga_crt' => $crt,
			]);

			$postimages = PostImages::updateOrCreate([
				'post_id' => $posts->id,
				'img_id' => $imgposts->id,
			]);

			$postareas = PostAreas::updateOrCreate([
				'post_id' => $posts->id,
				'wilayah_id' => $wilayah->id,
			]);

			$postdetails = PostDetails::updateOrCreate([
				'post_id' => $posts->id,
				'product_id' => $produks->id,
				'qty' => $qty,
			]);

		}


    }
}
