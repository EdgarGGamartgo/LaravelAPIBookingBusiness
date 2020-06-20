<?php

namespace App\Providers;

use App\Services\FindDestinyService\FindDestinyService;
use App\Services\FindDestinyService\IFindDestiny;
use App\Services\FindStockService\FindStockService;
use App\Services\FindStockService\IFindStockService;
use App\Services\RegisterAvailabilityRequestService\IRegisterAvailabilityRequest;
use App\Services\RegisterAvailabilityRequestService\RegisterAvailabilityRequestService;
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
