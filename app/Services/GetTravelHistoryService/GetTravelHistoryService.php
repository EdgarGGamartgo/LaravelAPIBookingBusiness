<?php


namespace App\Services\GetTravelHistoryService;


use App\Domain\Responses\SuccessfulResponses\ISuccessfulResponses;
use App\Estancia;
use App\Services\ExchangeRatesService\IExchangeRatesService;

class GetTravelHistoryService implements IGetTravelHistoryService
{
        protected ISuccessfulResponses $successfulResponses;
        protected IExchangeRatesService $exchangeRatesService;

        public function __construct(ISuccessfulResponses $successfulResponses, IExchangeRatesService $exchangeRatesService)
        {
            $this->successfulResponses = $successfulResponses;
            $this->exchangeRatesService = $exchangeRatesService;

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
                "totalCOst" => $this->exchangeRatesService->exchangeRates($stay->precio_venta, $request->currency),
                "totalNights" => $stay->noches_estancia,
                "currency" =>  $request->currency
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
