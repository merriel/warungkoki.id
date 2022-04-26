<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/api/oauth/token', 'Api\BCAController@token');
Route::post('/va/bill', 'Api\BCAController@bills');
Route::post('/va/payments', 'Api\BCAController@payments');

Route::post('/xhome/v1/biteship/callback', 'XhomeController@callback');

Route::post('/doku/notification/handler', 'DokuController@notifications');

Route::post('/absen/pindah', 'Api\AbsenController@pindah');
Route::post('/absen/reset', 'Api\AbsenController@reset');