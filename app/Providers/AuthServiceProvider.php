<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];
    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Passport::routes();

        // Token Lifetime
        // Personal access token
        /*
         * Passport::personalAccessTokensExpireIn(Carbon::now()->addHours(24));
        Passport::refreshTokensExpireIn(Carbon::now()->addDays(30));
         * */
        // For short lapses
        /*
         * personalAccessTokensExpireIn(now()->addMinutes(30))
         * */
        // Rest all
        /*Passport::tokensExpireIn(Carbon::now()->addHours(24));
        Passport::refreshTokensExpireIn(Carbon::now()->addDays(30)); */
    }
}