<?php


namespace App\Services\FindStockService;


use App\Inventario;
use App\InventarioEstatus;

class FindStockService implements IFindStockService
{
    public function findStockByIdByStatus($destinyId)
    {
        $Status = InventarioEstatus::find(2);
        $matchThese = ['idDestino' => $destinyId, 'estatus' => $Status->Status];
        return Inventario::where($matchThese)->get();
    }
}
