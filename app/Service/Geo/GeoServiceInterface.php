<?php


namespace App\Service\Geo;


interface GeoServiceInterface
{
    public function parse($ip);
    public function continentCode();
    public function countryCode();
}
