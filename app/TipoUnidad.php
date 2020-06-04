<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoUnidad extends Model
{
    protected $table = 'TipoUnidad';

    protected $fillable = [

                'clave',
                'nombre',
                'precio_noche'


    ];

    protected $guarded = [];
}
