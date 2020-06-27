<?php

namespace App\Http\Controllers;

use App\Services\GetCreditsService\IGetCreditsService;
use App\Services\GetHotelsService\IGetHotelsService;
use App\Services\GetTravelHistoryService\IGetTravelHistoryService;
use App\Services\GetZonesService\IGetZonesService;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    protected IGetZonesService $getZonesService;
    protected IGetHotelsService $getHotelsService;
    protected IGetCreditsService $getCreditsService;
    protected IGetTravelHistoryService $getTravelHistoryService;

    public function __construct(IGetZonesService $getZonesService, IGetHotelsService $getHotelsService,
                                IGetCreditsService $getCreditsService, IGetTravelHistoryService $getTravelHistoryService)
    {
        $this->getZonesService = $getZonesService;
        $this->getHotelsService = $getHotelsService;
        $this->getCreditsService = $getCreditsService;
        $this->getTravelHistoryService = $getTravelHistoryService;
    }

    public function getTravelHistory(Request $request) {
        return $this->getTravelHistoryService->getTravelHistory(json_decode($request->header('g-t-h')));
    }

    public function getCredits(Request $request) {
        return $this->getCreditsService->getCredits(json_decode($request->header('g-c')));
    }

    public function getZones() {

        return $this->getZonesService->getZones();

    }

    public function getHotels(Request $request)
    {
        return $this->getHotelsService->getHotels(json_decode($request->header('g-h')));
    }
}
