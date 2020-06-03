<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model
{
    protected $table = 'Solicitud';

    protected $fillable = [

        'destino',
        'extras',
        'checkIn',
        'checkOut',
        'guests',
        'rooms',


    ];

    protected $guarded = [];
}
