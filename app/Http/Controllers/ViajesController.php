<?php


namespace App\Http\Controllers;


use App\Destino;
use App\Inventario;
use App\Solicitud;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use App\Http\Traits\Mobile;

class ViajesController extends Controller
{
    use Mobile;
    /**
     * @var index
     */




    public function traits() {

        $this->battery();

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
}
