<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
    return redirect('/login');
});
// Auth::routes();
Auth::routes([
    'register' => false, // Registration Routes...
    'reset' => false, // Password Reset Routes...
    'verify' => false, // Email Verification Routes...
]);

Route::group(['middleware' => 'auth'], function () {

    Route::get('/home', function(){
        return view('home');
    });

    // admin manajemen
    Route::get('/admin', 'Admin\AdminController@index');
    Route::post('/admin/get_datatables', 'Admin\AdminController@get_datatables');
    Route::post('/admin/update', 'Admin\AdminController@update');
    Route::post('/admin/insert', 'Admin\AdminController@insert');
    Route::get('/admin/delete/{id}', 'Admin\AdminController@delete');

    // User
    Route::get('/user', 'Admin\UserController@index');
    Route::post('/user/get_datatables', 'Admin\UserController@get_datatables');
    Route::post('/user/update', 'Admin\UserController@update');
    Route::post('/user/insert', 'Admin\UserController@insert');
    Route::get('/user/delete/{id}', 'Admin\UserController@delete');

    // Transaksi
    Route::get('/transaksi', 'Transaksi\TransaksiController@index');
    Route::post('/transaksi/get_datatables', 'Transaksi\TransaksiController@get_datatables');
    Route::post('/transaksi/update', 'Transaksi\TransaksiController@update');
    Route::get('/transaksi/invoice/{id}', 'Transaksi\TransaksiController@invoice');

    // Transportasi
    Route::get('/transportasi', 'Event\TransportasiController@index');
    Route::post('/transportasi/get_datatables', 'Event\TransportasiController@get_datatables');
    Route::post('/transportasi/update', 'Event\TransportasiController@update');
    Route::post('/transportasi/insert', 'Event\TransportasiController@insert');
    Route::get('/transportasi/delete/{id}', 'Event\TransportasiController@delete');
    Route::post('/transportasi/updategambar', 'Event\TransportasiController@updategambar');
    Route::get('/transportasi/getgambar/{id}', 'Event\TransportasiController@getgambar');

    // Kategori Event
    Route::get('/kategori', 'Event\KategoriController@index');
    Route::post('/kategori/get_datatables', 'Event\KategoriController@get_datatables');
    Route::post('/kategori/update', 'Event\KategoriController@update');
    Route::post('/kategori/insert', 'Event\KategoriController@insert');
    Route::get('/kategori/delete/{id}', 'Event\KategoriController@delete');

    
    // Destinasi Event
    Route::get('/destinasi', 'Event\DestinasiController@index');
    Route::post('/destinasi/get_datatables', 'Event\DestinasiController@get_datatables');
    Route::post('/destinasi/update', 'Event\DestinasiController@update');
    Route::post('/destinasi/insert', 'Event\DestinasiController@insert');
    Route::get('/destinasi/delete/{id}', 'Event\DestinasiController@delete');
    Route::post('/destinasi/updategambar', 'Event\DestinasiController@updategambar');
    Route::get('/destinasi/getgambar/{id}', 'Event\DestinasiController@getgambar');


    // Event
    Route::get('/event', 'Event\EventController@index');
    Route::post('/event/get_datatables', 'Event\EventController@get_datatables');
    Route::post('/event/update', 'Event\EventController@update');
    Route::post('/event/insert', 'Event\EventController@insert');
    Route::get('/event/delete/{id}', 'Event\EventController@delete');
    Route::post('/event/updategambar', 'Event\EventController@updategambar');
    Route::get('/event/getgambar/{id}', 'Event\EventController@getgambar');

    Route::post('/event/get_data_paket', 'Event\EventController@get_data_paket');
    Route::post('/event/insertpaket', 'Event\EventController@insertpaket');
    Route::get('/event/hapuspaket/{id}', 'Event\EventController@hapuspaket');


    Route::post('/event/get_data_jadwal', 'Event\EventController@get_data_jadwal');
    Route::post('/event/insertjadwal', 'Event\EventController@insertjadwal');
    Route::get('/event/hapusjadwal/{id}', 'Event\EventController@hapusjadwal');

    Route::post('/event/get_data_keterangan', 'Event\EventController@get_data_keterangan');
    Route::post('/event/insertketerangan', 'Event\EventController@insertketerangan');
    Route::get('/event/hapusketerangan/{id}', 'Event\EventController@hapusketerangan');


    Route::get('/event/{id}', 'Event\EventController@view_event');


});