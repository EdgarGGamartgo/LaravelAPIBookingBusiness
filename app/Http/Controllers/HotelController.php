<?php

namespace App\Http\Controllers;

use App\Services\GetHotelsService\IGetHotelsService;
use App\Services\GetZonesService\IGetZonesService;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    protected IGetZonesService $getZonesService;
    protected IGetHotelsService $getHotelsService;

    public function __construct(IGetZonesService $getZonesService, IGetHotelsService $getHotelsService)
    {
        $this->getZonesService = $getZonesService;
        $this->getHotelsService = $getHotelsService;
    }

    public function getZones(Request $request) {

        return $this->getZonesService->getZones();

    }

    public function getHotels(Request $request)
    {
        return $this->getHotelsService->getHotels(json_decode($request->header('g-h')));
    }
}
