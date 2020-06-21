<?php


namespace App\Domain\Responses\SuccessfulResponses;


interface ISuccessfulResponses
{
        public function successfulAvailabilityResponse($stock, $request);
}
