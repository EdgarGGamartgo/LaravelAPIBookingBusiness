<?php


namespace App\Services\FindDestinyService;

use App\Destino;

class FindDestinyService implements IFindDestiny
{
    public function findDestinyById($destinyId)
    {
        return  Destino::find($destinyId);
    }
}
