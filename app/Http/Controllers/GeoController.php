<?php


namespace App\Http\Controllers;

use App\Jobs\GeoUa;

class GeoController
{
    public function __invoke()
    {
        $ua = request()->userAgent();

        $ip = request()->ip() != '127.0.0.1'
            ?: $_SERVER['HTTP_X_FORWARDED_FOR'];

        GeoUa::dispatch($ip, $ua)->onQueue('parsing');

        return redirect()->route('home');
    }
}
