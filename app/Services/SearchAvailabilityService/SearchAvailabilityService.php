<?php


namespace App\Services\SearchAvailabilityService;


use App\Destino;
use App\Inventario;
use App\Services\FindStockService\IFindStockService;
use App\Services\RegisterAvailabilityRequestService\IRegisterAvailabilityRequest;
use App\Solicitud;
use App\TipoUnidad;
use App\User;

class SearchAvailabilityService implements  SearchAvailabilityInterface
{
    public $successStatus = 200;
    protected $registerAvailabilityRequest;
    protected $findStockService;

    public function __construct(IRegisterAvailabilityRequest $registerAvailabilityRequest, IFindStockService $findStockService)
    {
        $this->registerAvailabilityRequest = $registerAvailabilityRequest;
        $this->findStockService = $findStockService;
    }

    public function searchAvailability($request) {

        $this->registerAvailabilityRequest->saveAvailabilityRequest($request);
        $inventario = $this->findStockService->findStockByIdByStatus($request->destino);
        $result = [];
        $allResults = array();
        foreach($inventario as $stock) {
            $result = [
                "hotelName"=> $stock->nombreEspacio,
                "arrivalDate"=> $request->checkIn,
                "departureDate"=> $request->checkOut,
                "totalCost"=> 0,    // TODO: GET REAL COST USE EXTERNAL CURRENCY API
                "currency"=> "MXN" // TODO: GET REAL CURRENCY USE EXTERNAL CURRENCY API
            ];
            array_push($allResults,$result);
        }

        // Send JSON response

        if($result != []) {

            return response()->json($allResults); // TODO: INSERT DTO

        } else {

            return response()->json([                   // TODO: INSERT DTO
                'hotelName' => 'No availability',
                'arrivalDate' => 'No availability',
                'departureDate' => 'No availability',
                'totalCost' => '0',
                'currency' => 'MXN',
            ]);

        }
    }
}
