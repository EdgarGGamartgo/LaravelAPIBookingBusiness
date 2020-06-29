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

/*oute::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
}); */



Route::post('login', 'UserController@login');
Route::post('register', 'UserController@register');
Route::group(['middleware' => 'auth:api'], function(){
    Route::post('details', 'UserController@details');
});
Route::group(['middleware' => 'auth:api'], function(){
    Route::post('logout', 'UserController@logout');
});
Route::group(['middleware' => 'auth:api'], function(){
    Route::post('saveSoldStay', 'TripController@saveSoldStay');
});
Route::group(['middleware' => 'auth:api'], function(){
    Route::get('searchAvailability', 'UserController@searchAvailability');
});
Route::group(['middleware' => 'auth:api'], function(){
    Route::get('getHotels', 'HotelController@getHotels');
});
Route::group(['middleware' => 'auth:api'], function(){
    Route::get('getZones', 'HotelController@getZones');
});
Route::group(['middleware' => 'auth:api'], function(){
    Route::get('getCredits', 'HotelController@getCredits');
});
Route::group(['middleware' => 'auth:api'], function(){
    Route::get('getTravelHistory', 'HotelController@getTravelHistory');
});
Route::group(['middleware' => 'auth:api'], function(){
    Route::get('send', 'mailController@send');
});
// PayPal IPN
Route::post('paypal/ipn', 'TripController@ipnPaypal');
