<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    protected $table = 'Inventario';

    protected $fillable = [

        'idDestino',
        'idUnidad',
        'nombreEspacio',
        'descripcion',
        'queHacer',
        'amenidades',
        'comoLlegar',
        'estatus'


    ];

    protected $guarded = [];
}
