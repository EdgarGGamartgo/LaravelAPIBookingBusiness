<?php


namespace App\Services\FindTotalNumberReservationNights;


class FindTotalNumberReservationNightsService implements IFindTotalNumberReservationNights
{


    public function getNumberNights($request)
    {
        $init = substr($request->checkIn,8,1);
        $end = substr($request->checkOut,8,1);
        if($init == 0) {
            $init = substr($request->checkIn,9,1);
        } else {
            $init = substr($request->checkIn,8,2);
        }
        if($end == 0) {
            $end = substr($request->checkOut,9,1);
        } else {
            $end = substr($request->checkOut,8,2);
        }
        $numberDays = $end - $init;
        return $numberDays;
    }
}
