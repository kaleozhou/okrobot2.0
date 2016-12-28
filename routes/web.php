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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/help', function () {
    return view('help');
});
Auth::routes();
Route::get('/home', 'HomeController@index');
//停止自动交易
Route::get('/starttrade/btc_cny', 'HomeController@startbtc');
Route::get('/starttrade/ltc_cny', 'HomeController@startltc');
Route::get('/stoptrade/btc_cny', 'HomeController@stopbtc');
Route::get('/stoptrade/ltc_cny', 'HomeController@stopltc');
//修改信息
Route::get('/modifyUserinfo', 'UserController@index');
Route::post('/modifyUserinfo', 'UserController@modify');



