<?php


namespace App\Http\Controllers;


use App\TipoUnidad;
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

    public function exchangeRates($amount, $to) {
        $apiKey = $_ENV['EXCHANGE_API_KEY'];
        $req_url = 'https://openexchangerates.org/api/latest.json?app_id='.$apiKey; // 23db6f1918544371bec3c71212f37943 Always USD as base currency as long as I use Free plan for this API
        $response_json = file_get_contents($req_url);
        info($response_json);
        $obj = json_decode($response_json);
        $to = $obj->rates->$to * $amount;
        return response()->json([
            'data' => $to
        ]);
        /*
         * Open Source Exchange Rates API
                    Free for personal use (1000 hits per month)
                    Changing "base" (from "USD") is not allowed in Free account
                    Requires registration.
                    Request: http://openexchangerates.org/latest.json
                    Response:

                    {
                      "disclaimer": "This data is collected from various providers ...",
                      "license": "all code open-source under GPL v3 ...",
                      "timestamp": 1323115901,
                      "base": "USD",
                      "rates": {
                          "AED": 3.66999725,
                          "ALL": 102.09382091,
                          "ANG": 1.78992886,
                          // 115 more currency rates here ...
                      }
                    }
         *
         * */
    }


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
        // Save new entry to table "Solicitud".
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
        if($request->destino)
            foreach($destino as $desti) {

                if($request->destino == $desti->nombre) {
                    $idDestino =  $desti->id;
                }
            }
        // Get all available hotels from stock
        $TipoUnidades = TipoUnidad::all();
        $inventario = Inventario::all();
        info("ALL STOCK");
        info($TipoUnidades);
        $result = [];
        $allResults = array();
        // Get arrival Date & Get departure Date --> Done if status in stock is "1"
        // Get totalCost
        // Get currency. All currencies in database are in USD

        foreach($inventario as $stock) {
            info("Pass 0");
            info($stock);
            info($idDestino);
            info($stock->idDestino);
            info($stock->estatus);

            if($idDestino == $stock->idDestino && $stock->estatus == 1) {   // estatus == 1 == disponible para vender
              info("Pass 1");
                foreach($TipoUnidades as $tipoUnidad) {
                    info("Pass 2");
                    if($stock->idTipoUnidad == $tipoUnidad->id) {   // estatus == 1 == disponible para vender
                        info("Pass 3");

                      $init = substr($request->checkIn,8,1);
                      $end = substr($request->checkOut,8,1);
                        if($init == 0) {
                            $init = substr($request->checkIn,9,1);
                        } else {
                            $init = substr($request->checkIn,8,2);
                        }
                        if($end == 0) {
                            $end = substr($request->checkOut,9,1);
                        } else {
                            $end = substr($request->checkOut,8,2);
                        }
                        $numberDays = $end - $init;
                        info("Init");
                        info($init);
                        info("End");
                        info($end);
                        info("Result");
                        info($numberDays);
                        $result = [
                            "hotelName"=> $stock->nombreEspacio,
                            "arrivalDate"=> $request->checkIn,
                            "departureDate"=> $request->checkOut,
                            "totalCost"=> $tipoUnidad->precio_noche * $numberDays,        // "Inventario" table lacks a cost per night
                            "currency"=> "MXN"
                        ];
                     //   exchangeRates(100,"EUR"); Separate business logic into services: single action classes, traits, Design Pattern : Service Layer with Laravel 5,
                     // CALL EXCHANGE SERVICE, MULTIPLE totalCost and get the proper currency displayed from front end language
                    // return json with first option the "hotel selected" if possible, also return the exact dates and
                        // Also adults, kids and rooms and of course add extra services
                        // This is a complex WS and it's going to take some time
                        array_push($allResults,$result);
                    }
                }
            }
        }

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

