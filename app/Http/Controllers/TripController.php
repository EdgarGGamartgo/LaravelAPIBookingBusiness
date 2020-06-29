<?php

namespace App\Http\Controllers;

use App\Services\SaveSoldStayService\ISaveSoldStayService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class TripController extends Controller
{
    protected ISaveSoldStayService $saveSoldStayService;

    public function __construct(ISaveSoldStayService $saveSoldStayService)
    {
                $this->saveSoldStayService = $saveSoldStayService;
    }

    public function saveSoldStay(Request $request)
    {
        return $this->saveSoldStayService->saveSoldStay($request);
    }

    public function ipnPaypal(Request $request) {

        $data = $request->all();
        if($data['payment_status'] == "Completed"){
            // We will send email to user
            // Update order status to Payment Captured
        }
    }

}
