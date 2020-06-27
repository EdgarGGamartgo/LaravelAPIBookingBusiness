<?php


namespace App\Services\GetCreditsService;


use App\Credito;
use App\Domain\Responses\SuccessfulResponses\ISuccessfulResponses;

class GetCreditsService implements IGetCreditsService
{

    protected  ISuccessfulResponses $successfulResponses;

    public function __construct(ISuccessfulResponses $successfulResponses)
    {
        $this->successfulResponses = $successfulResponses;
    }

    public function getCredits($request){
        $userCredits = Credito::where(['user_id' => $request->userId])->get();
        $allResults = array();
        foreach($userCredits as $credit){
            $creditType = Credito::find($credit->id)->creditType;
            $result = [
                "creditType" => $creditType,
                "amount" => $credit->importe
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
