<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware('apiCek')->group(function () {
    Route::post('/register', 'Api\UserController@register');
    Route::post('/login', 'Api\UserController@login');


    Route::post('/update-profile', 'Api\UserController@update_profile');
    Route::get('/profil/{id}', 'Api\UserController@get_profil');

    Route::get('/events', 'Api\EventController@get_all');
    Route::get('/event/kategoris', 'Api\EventController@get_all_kategori');
    Route::get('/events/kategori/{id}', 'Api\EventController@get_by_kategori');
    Route::get('/event/{id}', 'Api\EventController@get_by_id');

    Route::post('/order', 'Api\TransaksiController@order');
    Route::post('/upload_bukti', 'Api\TransaksiController@upload_bukti');

    Route::get('/history', 'Api\TransaksiController@all_history');
    Route::get('/history/{id}', 'Api\TransaksiController@get_history_by_id');
    
    Route::post('/history/search', 'Api\TransaksiController@search_history');
});

