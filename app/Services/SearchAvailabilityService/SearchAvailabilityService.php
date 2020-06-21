<?php


namespace App\Services\SearchAvailabilityService;


use App\Destino;
use App\Domain\Responses\SuccessfulResponses\ISuccessfulResponses;
use App\Inventario;
use App\Services\FindStockService\IFindStockService;
use App\Services\RegisterAvailabilityRequestService\IRegisterAvailabilityRequest;
use App\Solicitud;
use App\TipoUnidad;
use App\User;

class SearchAvailabilityService implements  SearchAvailabilityInterface
{
    public int $successStatus = 200;
    protected IRegisterAvailabilityRequest $registerAvailabilityRequest;
    protected IFindStockService $findStockService;
    protected ISuccessfulResponses $successfulResponses;

    public function __construct(IRegisterAvailabilityRequest $registerAvailabilityRequest, IFindStockService $findStockService,
                                ISuccessfulResponses $successfulResponses)
    {
        $this->registerAvailabilityRequest = $registerAvailabilityRequest;
        $this->findStockService = $findStockService;
        $this->successfulResponses = $successfulResponses;
    }

    public function searchAvailability($request) {

        $this->registerAvailabilityRequest->saveAvailabilityRequest($request);
        $stock = $this->findStockService->findStockByIdByStatus($request->destino);
        $response = $this->successfulResponses->successfulAvailabilityResponse($stock, $request);

        if($response) {

            return response()->json([
                'data' => $response,
                'meta' => [
                    'statusCode' => $this->successStatus
                ]
            ]);

        } else {
            return response(['error'=>true,'error-msg'=>"No availability"],404);
        }
    }
}
