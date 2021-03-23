<?php

namespace App\Providers;

use Hillel\GeoInterface\GeoServiceInterface;
use Hillel\GeoService1\MaxmindGeoService;
use Hillel\GeoService2\IpApiService;
use Hillel\UserAgentInterface\UserAgentServiceInterface;
use Hillel\UserAgentService1\UAParserService;
use Hillel\UserAgentService2\DonatjParserService;
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
            // return new MaxmindGeoService();
            return new IpApiService();
        });

        $this->app->singleton(UserAgentServiceInterface::class, function(){
            return new UAParserService();
            // return new DonatjParserService();
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
