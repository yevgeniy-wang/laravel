<?php

namespace App\Jobs;

use App\Models\Visit;
use Hillel\GeoInterface\GeoServiceInterface;
use Hillel\UserAgentInterface\UserAgentServiceInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GeoUa implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $ip;
    protected $ua;

    /**
     * Create a new job instance.
     *
     * @param  string  $ip
     * @param  string  $ua
     */
    public function __construct(string $ip, string $ua)
    {
        $this->ip = $ip;
        $this->ua = $ua;
    }

    /**
     * Execute the job.
     *
     * @param  GeoServiceInterface  $geoService
     * @param  UserAgentServiceInterface  $agentService
     *
     * @return void
     */
    public function handle(GeoServiceInterface $geoService, UserAgentServiceInterface $agentService)
    {
        $geoService->parse($this->ip);
        $agentService->parse($this->ua);

        Visit::create([
            'ip'             => $this->ip,
            'continent_code' => $geoService->continentCode(),
            'country_code'   => $geoService->countryCode(),
            'browser'        => $agentService->browser(),
            'os'             => $agentService->os(),
        ]);
    }
}
