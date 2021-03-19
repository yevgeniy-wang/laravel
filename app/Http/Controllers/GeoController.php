<?php


namespace App\Http\Controllers;


use App\Models\Visit;
use App\Service\Geo\GeoServiceInterface;
use UAParser\Parser;

class GeoController
{
    public function __invoke(GeoServiceInterface $geoService)
    {
        $ip = request()->ip() != '127.0.0.1' ?: $_SERVER['HTTP_X_FORWARDED_FOR'];
        $geoService->parse($ip);

        Visit::create([
            'ip' => $ip,
            'continent_code' => $geoService->continentCode(),
            'country_code' => $geoService->countryCode(),
        ]);

        return view('pages.geo', compact('geoService'));
    }
}
