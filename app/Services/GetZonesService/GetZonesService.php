<?php


namespace App\Services\GetZonesService;


use App\Destino;

class GetZonesService implements IGetZonesService
{

    protected int $successStatus = 200;

    public function getZones()
    {
          if(Destino::all()) {
            return response()->json([
                'data' => Destino::all(),
                'meta' => [
                    'statusCode' => $this->successStatus
                ]
            ]);
        } else {
            return response(['error'=>true,'error-msg'=>"No availability"],404);
        }
    }
}
