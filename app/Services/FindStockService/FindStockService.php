<?php


namespace App\Services\FindStockService;


use App\Inventario;

class FindStockService implements IFindStockService
{
    public function findStockByIdByStatus($destinyId)
    {
        $matchThese = ['idDestino' => $destinyId, 'estatus' => '1'];
        $inventario = Inventario::where($matchThese)->get();
        return $inventario;
    }

}
