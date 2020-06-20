<?php


namespace App\Http\Controllers;


use App\Services\SearchAvailabilityService\SearchAvailabilityInterface;
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
    protected $searchAvailability;

    public function __construct(SearchAvailabilityInterface $searchAvailability)
    {
        $this->searchAvailability = $searchAvailability;
    }

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

       return $this->searchAvailability->searchAvailability($request);


    }
}

