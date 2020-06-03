<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Solicitud;
use App\Destino;
use App\Inventario;

class UserController extends Controller
{
    public $successStatus = 200;


    /*
 * ‘headers’ => [
‘Accept’ => ‘application/json’,
‘Authorization’ => ‘Bearer ‘.$accessToken,
]
 * */
    public function logout (Request $request) {

        $token = $request->user()->token();
        $token->revoke();
        $response = 'You have been succesfully logged out!';
        return response($response, 200);
      //  return Auth::user();

    }

    /**
     * login api
     *     form data
     * email
     *password
     * @return \Illuminate\Http\Response
     */
    public function login(){
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){
            $user = Auth::user();
            $success['token'] =  $user->createToken('MyApp')-> accessToken;
            return response()->json(['success' => $success, 'userData' => $user], $this-> successStatus);
        }
        else{
            return response()->json(['error'=>'Unauthorised'], 401);
        }
    }
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     *
     * form data
     * email
     *password
     *  c_password
     *  name
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyApp')-> accessToken;
        $success['name'] =  $user->name;
        return response()->json(['success'=>$success], $this-> successStatus);
    }
    /**
     * details api
     *
     * @return \Illuminate\Http\Response
     */
    /*
 * ‘headers’ => [
‘Accept’ => ‘application/json’,
‘Authorization’ => ‘Bearer ‘.$accessToken,
]
 * */
    public function details()
    {
        $user = Auth::user();
        return response()->json(['success' => $user], $this-> successStatus);
    }

    // Search availability

    public function searchAvailability(Request $request) {
        // Save new entry to table "solicitud"
        info($request);
        error_log($request);
        $solicitud = new Solicitud;
        $solicitud->destino = $request->destino;
        $solicitud->extras = $request->extraServices;
        $solicitud->checkIn = $request->checkIn;
        $solicitud->checkOut = $request->checkOut;
        $solicitud->guests = $request->adults;
        $solicitud->rooms = $request->rooms;
        $solicitud->save();
        // Get idDestino from stock
        $destino = Destino::all();
        $idDestino = 0;
        if($request->destino )
            foreach($destino as $desti) {

                if($request->destino == $desti->nombre) {
                    $idDestino =  $desti->id;
                }
            }
        // Get all availabli hotels from stock
        $inventario = Inventario::all();
        $result = [];
        $allResults = array();

        foreach($inventario as $stock) {

            if($idDestino == $stock->idDestino && $stock->estatus == 1) {   // estatus == 1 == disponible para vender
                $result = [
                    "hotelName"=> $stock->nombreEspacio,        // Ask where to get hotelName
                    "arrivalDate"=> $request->checkIn,
                    "departureDate"=> $request->checkOut,
                    "totalCost"=> "100",        // "Inventario" table lacks a cost per night
                    "currency"=> "MXN"
                ];
                array_push($allResults,$result);

            }
        }
        $result2 = [
            "hotelName"=> "Hotel Fantasma",        // Ask where to get hotelName
            "arrivalDate"=> $request->checkIn,
            "departureDate"=> $request->checkOut,
            "totalCost"=> "100",        // "Inventario" table lacks a cost per night
            "currency"=> "MXN"
        ];
        array_push($allResults,$result2);

        // Send JSON response
        info($result);

        if($result != []) {

            return response()->json($allResults);

        } else {

            return response()->json([
                'hotelName' => 'No availability',
                'arrivalDate' => 'No availability',
                'departureDate' => 'No availability',
                'totalCost' => '0',
                'currency' => 'MXN',
            ]);

        }

    }
}

