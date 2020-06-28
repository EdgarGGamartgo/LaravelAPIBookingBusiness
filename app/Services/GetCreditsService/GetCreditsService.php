<?php


namespace App\Services\GetCreditsService;


use App\Credito;
use App\Domain\Responses\SuccessfulResponses\ISuccessfulResponses;
use App\Services\ExchangeRatesService\IExchangeRatesService;

class GetCreditsService implements IGetCreditsService
{

    protected ISuccessfulResponses $successfulResponses;
    protected IExchangeRatesService $exchangeRatesService;

    public function __construct(ISuccessfulResponses $successfulResponses, IExchangeRatesService $exchangeRatesService)
    {
        $this->successfulResponses = $successfulResponses;
        $this->exchangeRatesService = $exchangeRatesService;
    }

    public function getCredits($request){
        $userCredits = Credito::where(['user_id' => $request->userId])->get();
        $allResults = array();
        foreach($userCredits as $credit){
            $creditType = Credito::find($credit->id)->creditType;
            $result = [
                "creditType" => $creditType,
                "amount" => $this->exchangeRatesService->exchangeRates($credit->importe, $request->currency),
                "currency" =>  $request->currency
            ];
            array_push($allResults,$result);
        }
        if($allResults) {
            return $this->successfulResponses->generalSuccessfulResponse($allResults);
        } else {
            return $this->successfulResponses->general404Response();
        }
    }
}
