<?php


namespace App\Service\Geo;


use Illuminate\Support\Facades\Http;

class IpApiService implements GeoServiceInterface
{
    protected $data;

    public function parse($ip)
    {
        $response = Http::get('http://ip-api.com/json/' . $ip . '?fields=continentCode,countryCode');
        //if ok
        $this->data = $response->json();
    }

    public function continentCode()
    {
        return $this->data['continentCode'];
    }


    public function countryCode()
    {
        return $this->data['countryCode'];
    }
}
