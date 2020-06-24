<?php

namespace App\Providers;

use App\Domain\Responses\SuccessfulResponses\ISuccessfulResponses;
use App\Domain\Responses\SuccessfulResponses\SuccessfulResponsesService;
use App\Services\ExchangeRatesService\ExchangeRatesService;
use App\Services\ExchangeRatesService\IExchangeRatesService;
use App\Services\FindDestinyService\FindDestinyService;
use App\Services\FindDestinyService\IFindDestiny;
use App\Services\FindStockService\FindStockService;
use App\Services\FindStockService\IFindStockService;
use App\Services\FindTotalNumberReservationNights\FindTotalNumberReservationNightsService;
use App\Services\FindTotalNumberReservationNights\IFindTotalNumberReservationNights;
use App\Services\GetHotelsService\GetHotelsService;
use App\Services\GetHotelsService\IGetHotelsService;
use App\Services\GetZonesService\GetZonesService;
use App\Services\GetZonesService\IGetZonesService;
use App\Services\RegisterAvailabilityRequestService\IRegisterAvailabilityRequest;
use App\Services\RegisterAvailabilityRequestService\RegisterAvailabilityRequestService;
use App\Services\SaveSoldStayService\ISaveSoldStayService;
use App\Services\SaveSoldStayService\SaveSoldStayService;
use App\Services\SearchAvailabilityService\SearchAvailabilityInterface;
use App\Services\SearchAvailabilityService\SearchAvailabilityService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(SearchAvailabilityInterface::class, SearchAvailabilityService::class);
        $this->app->bind(IRegisterAvailabilityRequest::class, RegisterAvailabilityRequestService::class);
        $this->app->bind(IFindDestiny::class, FindDestinyService::class);
        $this->app->bind(IFindStockService::class, FindStockService::class);
        $this->app->bind(ISuccessfulResponses::class, SuccessfulResponsesService::class);
        $this->app->bind(IFindTotalNumberReservationNights::class, FindTotalNumberReservationNightsService::class);
        $this->app->bind(IExchangeRatesService::class, ExchangeRatesService::class);
        $this->app->bind(IGetZonesService::class, GetZonesService::class);
        $this->app->bind(IGetHotelsService::class, GetHotelsService::class);
        $this->app->bind(ISaveSoldStayService::class, SaveSoldStayService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
