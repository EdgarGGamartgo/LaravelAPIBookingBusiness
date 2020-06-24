<?php


namespace App\Services\FindStockService;


use App\Inventario;
use App\InventarioEstatus;

class FindStockService implements IFindStockService
{
    public function findStockByIdByStatus($request)
    {
        $Status = InventarioEstatus::find(2);
        $matchThese = [
            ['idDestino', '=', $request->destino],
            ['estatus', '=',  $Status->Status],
            ['maxAdults', '>', $request->adults],
            ['maxKids', '>', $request->kids],
            ['maxRooms', '>', $request->rooms],
        ];
      //  $matchThese = ['idDestino' => $request->destino, 'estatus' => $Status->Status]
        return Inventario::where($matchThese)->get();
    }
}
