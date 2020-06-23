<?php


namespace App\Services\GetHotelsService;


use App\Inventario;
use App\InventarioEstatus;

class GetHotelsService implements IGetHotelsService
{
        protected int $successStatus = 200;

        public function getHotels($data)
        {

            $Status = InventarioEstatus::find(2);
            $matchThese = ['idDestino' => $data->destino, 'estatus' => $Status->Status];

            if(Inventario::where($matchThese)->get()) {
                return response()->json([
                    'data' => Inventario::where($matchThese)->get(),
                    'meta' => [
                        'statusCode' => $this->successStatus
                    ]
                ]);
            } else {
                return response(['error'=>true,'error-msg'=>"No availability"],404);
            }

        }
}
