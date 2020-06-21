<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InventarioEstatus extends Model
{
    protected $table = 'InventarioEstatus';

    protected $fillable = [

        'status',


    ];

    protected $guarded = [];
}
