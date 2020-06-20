<?php


namespace App\Services\RegisterAvailabilityRequestService;


use App\Solicitud;

class RegisterAvailabilityRequestService implements IRegisterAvailabilityRequest
{
    public function saveAvailabilityRequest($request){
        $solicitud = new Solicitud;
        $solicitud->destino = $request->destino;
        $solicitud->extras = $request->extraServices;
        $solicitud->checkIn = $request->checkIn;
        $solicitud->checkOut = $request->checkOut;
        $solicitud->guests = $request->adults;
        $solicitud->rooms = $request->rooms;
        $solicitud->save();
        return "Save DONE";
    }
}
