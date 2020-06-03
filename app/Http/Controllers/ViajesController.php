<?php


namespace App\Http\Controllers;


use App\Destino;
use App\Inventario;
use App\Solicitud;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class ViajesController extends Controller
{
    // Search availability

    public function searchAvailability(Request $request) {
        // Save new entry to table "solicitud"
        return "Hey";

    }
}
