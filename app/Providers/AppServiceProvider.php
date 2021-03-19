<?php

namespace App\Providers;

use App\Service\Geo\GeoServiceInterface;
use App\Service\Geo\IpApiService;
use App\Service\Geo\MaxmindGeoService;
use App\Service\UserAgent\DonatjParserService;
use App\Service\UserAgent\UAParserService;
use App\Service\UserAgent\UserAgentServiceInterface;
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
        $this->app->singleton(GeoServiceInterface::class, function(){
            return new IpApiService();
            // return new MaxmindGeoService();
        });

        $this->app->singleton(UserAgentServiceInterface::class, function(){
            //return new UAParserService();
            return new DonatjParserService();
        });
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
