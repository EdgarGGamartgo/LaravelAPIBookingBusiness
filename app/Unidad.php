<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unidad extends Model
{
    protected $table = 'Unidad';

    protected $fillable = [

        'nombre',
        'estatus',


    ];

    protected $guarded = [];
}
