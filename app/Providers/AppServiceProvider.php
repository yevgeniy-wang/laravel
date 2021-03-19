<?php

namespace App\Providers;

use App\Service\Geo\GeoServiceInterface;
use App\Service\Geo\IpApiService;
use App\Service\Geo\MaxmindGeoService;
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
