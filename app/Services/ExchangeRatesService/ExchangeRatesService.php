<?php


namespace App\Services\ExchangeRatesService;


class ExchangeRatesService implements IExchangeRatesService
{
    public function exchangeRates($amount, $to)
    {
        $apiKey = $_ENV['EXCHANGE_API_KEY'];
        $req_url = 'https://openexchangerates.org/api/latest.json?app_id='.$apiKey; // 23db6f1918544371bec3c71212f37943 Always USD as base currency as long as I use Free plan for this API
        $response_json = file_get_contents($req_url);
        $obj = json_decode($response_json);
        return $obj->rates->{$to} * $amount;
    }
}
