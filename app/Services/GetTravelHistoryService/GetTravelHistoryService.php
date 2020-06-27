<?php


namespace App\Services\GetTravelHistoryService;


use App\Domain\Responses\SuccessfulResponses\ISuccessfulResponses;
use App\Estancia;

class GetTravelHistoryService implements IGetTravelHistoryService
{
        protected ISuccessfulResponses $successfulResponses;

        public function __construct(ISuccessfulResponses $successfulResponses)
        {
            $this->successfulResponses = $successfulResponses;
        }

    public function getTravelHistory($request){

        $getStays = Estancia::where(['user_id' => $request->userId])->get();
        $allResults = array();
        foreach($getStays as $stay){
            $unit = Estancia::find($stay->id_unidad)->unit;
            $result = [
                "checkIn" => $stay->checkin,
                "checkOut" => $stay->checkout,
                "hotel" => $unit->nombre,
                "totalCOst" => $stay->precio_venta,
                "totalNights" => $stay->noches_estancia,
            ];
            array_push($allResults,$result);
        }
        if($allResults) {
                return $this->successfulResponses->generalSuccessfulResponse($allResults);
            } else {
                return $this->successfulResponses->general404Response();
            }
        }
}
