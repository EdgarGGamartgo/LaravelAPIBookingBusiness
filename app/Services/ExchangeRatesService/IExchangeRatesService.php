<?php


namespace App\Services\ExchangeRatesService;


interface IExchangeRatesService
{
    public function exchangeRates($amount, $to);
}
