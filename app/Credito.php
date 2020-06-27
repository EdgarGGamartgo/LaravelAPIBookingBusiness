<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Credito extends Model
{
    protected $table = 'Credito';

    protected $fillable = [

        'idTipoCredito',
        'importe',
        'user_id',


    ];

    protected $guarded = [];

    public function creditType()
    {
        return $this->hasOne('App\TipoCredito', 'id','idTipoCredito');
    }

    public function user()
    {
        return $this->hasOne('App\User', 'id','user_id');
    }
}
