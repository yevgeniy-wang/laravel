<?php


namespace App\Http\Controllers;


use App\Models\Visit;
use Hillel\GeoInterface\GeoServiceInterface;
use Hillel\UserAgentInterface\UserAgentServiceInterface;

class GeoController
{
    public function __invoke( GeoServiceInterface $geoService, UserAgentServiceInterface $agentService)
    {
        $ua = request()->userAgent();
        $agentService->parse($ua);

        $ip = request()->ip() != '127.0.0.1'
            ?: $_SERVER['HTTP_X_FORWARDED_FOR'];
        $geoService->parse($ip);

        Visit::create([
            'ip'             => $ip,
            'continent_code' => $geoService->continentCode(),
            'country_code'   => $geoService->countryCode(),
            'browser'        => $agentService->browser(),
            'os'             => $agentService->os(),
        ]);

        return view('pages.geo', compact('geoService', 'agentService'));
    }
}
