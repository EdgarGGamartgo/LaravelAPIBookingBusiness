<?php


namespace App\Services\SaveSoldStayService;


use App\Domain\Responses\SuccessfulResponses\ISuccessfulResponses;
use App\Estancia;

class SaveSoldStayService implements ISaveSoldStayService
{
    protected ISuccessfulResponses $successfulResponses;

    public function __construct(ISuccessfulResponses $successfulResponses)
    {
       $this->successfulResponses = $successfulResponses;
    }

    public function saveSoldStay($request)
        {

            $stay = new Estancia;
            $stay->user_id = $request->user_id;
            $stay->nombre_invitado = $request->nombre_invitado;
            $stay->apellidos_invitado = $request->apellidos_invitado;
            $stay->checkin = $request->checkin;
            $stay->checkout = $request->checkout;
            $stay->id_unidad = $request->id_unidad;
            $stay->precio_venta = $request->precio_venta;
            $stay->precio_compra = 0.00;  // Where shall I get it ?
            $stay->precio_noche = $request->precio_noche;
            $stay->idInventario = $request->idInventario;
            $savedStay = $stay->save();
            if($savedStay) {
                return $this->successfulResponses->generalSuccessfulResponse($savedStay);
            } else {
                return $this->successfulResponses->general404Response();
            }
/*
    Request Example
    {
   "user_id":"2",
   "nombre_invitado":"Edgar",
   "apellidos_invitado":"Martínez",
   "checkin":"2020-06-01 01:49:20",
   "checkout":"2020-06-01 01:49:20",
   "noches_estancia":1,
   "id_unidad":1,
   "precio_venta":100.00,
   "precio_compra":0.00,
   "precio_noche":100.00,
   "idInventario":1
}

 * */

        }
}
