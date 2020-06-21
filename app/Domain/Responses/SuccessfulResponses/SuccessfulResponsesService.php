<?php


namespace App\Domain\Responses\SuccessfulResponses;


use App\Services\FindTotalNumberReservationNights\IFindTotalNumberReservationNights;
use App\TipoUnidad;

class SuccessfulResponsesService implements ISuccessfulResponses
{

    protected IFindTotalNumberReservationNights $findTotalNumberReservationNights;

    public function __construct(IFindTotalNumberReservationNights $findTotalNumberReservationNights)
    {
        $this->findTotalNumberReservationNights = $findTotalNumberReservationNights;
    }

    public function successfulAvailabilityResponse($stock, $request)
    {
        $numberDays = $this->findTotalNumberReservationNights->getNumberNights($request);
        $allResults = array();
        foreach($stock as $stock) {
            $TipoUnidad = TipoUnidad::where(['id' => $stock->idTipoUnidad])->get();
            $result = [
                "hotelName"=> $stock->nombreEspacio,
                "arrivalDate"=> $request->checkIn,
                "departureDate"=> $request->checkOut,
                "totalCost"=> $TipoUnidad[0]->precio_noche * $numberDays,
                "totalNights"=> $numberDays,
                "currency"=> "MXN" // TODO: GET REAL CURRENCY USE EXTERNAL CURRENCY API
            ];
            array_push($allResults,$result);
        }

        return $allResults;

    }
}
