<?php

use App\Destino;
use App\Inventario;
use App\Solicitud;
use Illuminate\Http\Request;
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



Route::get('/update', function () {

//    $address = Address::where('user_id',1);

    $address = Address::whereUserId(1)->first();

    $address->name = "Update new address";

    $address->save();

});



Route::get('/read', function (Illuminate\Http\Request $request) {

 //  $user = User::findOrFail(1);

    $json = $request->header('s-a');//$request->headers->all();//$this->header('x-dsi-restful', '');
    $json2 = '{"foo-bar": 12345,"foo-bar2": 12345}';
info("fallas");
info($json);
    info("fallas2");
    info($json2);

    $obj = json_decode($json, true);
   // info($json);
    info("Hola");
    info($obj);

 return   $obj;


    });



    Route::get('/delete', function () {

        $user = User::findOrFail(1);

        $user->address()->delete();


         });





































































