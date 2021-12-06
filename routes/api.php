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
Route::post('register', 'Api\AuthController@register');
Route::post('login', 'Api\AuthController@login');

Route::group(['middleware' => 'auth:api'], function(){
    Route::get('booking', 'Api\BookingController@index');
    Route::get('booking/{id}', 'Api\BookingController@show');
    Route::post('booking', 'Api\BookingController@store');
    Route::put('booking/{id}', 'Api\BookingController@update');
    Route::delete('booking/{id}', 'Api\BookingController@destroy');
    Route::get('cart', 'Api\CartController@index');
    Route::get('cart/{id}', 'Api\CartController@show');
    Route::post('cart', 'Api\CartController@store');
    Route::put('cart/{id}', 'Api\CartController@update');
    Route::delete('cart/{id}', 'Api\CartController@destroy');
    Route::get('history', 'Api\HistoryController@index');
    Route::get('history/{id}', 'Api\HistoryController@show');
    Route::post('history', 'Api\HistoryController@store');
    Route::put('history/{id}', 'Api\HistoryController@update');
    Route::delete('history/{id}', 'Api\HistoryController@destroy');
});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });