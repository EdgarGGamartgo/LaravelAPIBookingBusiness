<?php

use App\Credito;
use App\Destino;
use App\Inventario;
use App\Notifications\TaskCompleted;
use App\Solicitud;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Route;

use App\User;
use App\Address;
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



Route::get('/insert', function () {

    $user = User::findOrFail(1);

    $address = new Address(['name'=>'1234 Houston av NY NY 11218']);

    $user->address()->save($address);

});

Route::get('/traits', 'ViajesController@traits');

Route::get('/oneToOne', function () {

    $arr = [ 'foo' => "bar" ];
$when = Carbon::now()->addSeconds(10);
$users = User::find(9);
//User::find(9)->notify(new TaskCompleted($arr));

Notification::send($users, (new TaskCompleted($arr))->delay($when));




});

//Route::get('/update', 'HotelController@getZones');
//Route::get('/getHotels2', 'HotelController@getHotels');

//Route::get('getZones', 'UserController@getZones');

//    $address = Address::where('user_id',1);

//    $address = Address::whereUserId(1)->first();

 //   $address->name = "Update new address";

//    $address->save();









































































