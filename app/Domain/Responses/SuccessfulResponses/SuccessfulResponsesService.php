<?php


namespace App\Domain\Responses\SuccessfulResponses;


use App\Services\ExchangeRatesService\IExchangeRatesService;
use App\Services\FindTotalNumberReservationNights\IFindTotalNumberReservationNights;
use App\TipoUnidad;

class SuccessfulResponsesService implements ISuccessfulResponses
{

    protected IFindTotalNumberReservationNights $findTotalNumberReservationNights;
    protected IExchangeRatesService $exchangeRatesService;

    public function __construct(IFindTotalNumberReservationNights $findTotalNumberReservationNights,
                                IExchangeRatesService $exchangeRatesService)
    {
        $this->exchangeRatesService = $exchangeRatesService;
        $this->findTotalNumberReservationNights = $findTotalNumberReservationNights;
    }

    public function successfulAvailabilityResponse($stock, $request)
    {
        $numberDays = $this->findTotalNumberReservationNights->getNumberNights($request);
        $allResults = array();
        foreach($stock as $stock) {
            $TipoUnidad = TipoUnidad::where(['id' => $stock->idTipoUnidad])->get();
            $usdTotalCost = $TipoUnidad[0]->precio_noche * $numberDays;
            $convertedRate = $this->exchangeRatesService->exchangeRates($usdTotalCost, $request->currency);
            $result = [
                "hotelName"=> $stock->nombreEspacio,
                "arrivalDate"=> $request->checkIn,
                "departureDate"=> $request->checkOut,
                "totalCost"=> $convertedRate,
                "totalNights"=> $numberDays,
                "currency"=> $request->currency // TODO: GET REAL CURRENCY USE EXTERNAL CURRENCY API
            ];
            array_push($allResults,$result);
        }

        return $allResults;

    }
}
