<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estancia extends Model
{
    protected $table = 'Estancia';

    protected $fillable = [

                'user_id',
                'nombre_invitado',
                'apellidos_invitado',
                'checkin',
                'checkout',
                'noches_estancia',
                'id_unidad',
                'precio_venta',
                'precio_compra',
                'precio_noche',
                'idInventario',
                'idInventario',
                'user_id',

    ];

      protected $guarded = [];
}
