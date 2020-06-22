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
    public int $successStatus = 200;
    protected SearchAvailabilityInterface $searchAvailability;

    public function __construct(SearchAvailabilityInterface $searchAvailability)
    {
        $this->searchAvailability = $searchAvailability;
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


    public function searchAvailability(Request $request) {

        return $this->searchAvailability->searchAvailability(json_decode($request->header('s-a')));


    }
}

