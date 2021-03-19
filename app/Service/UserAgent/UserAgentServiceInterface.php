<?php


namespace App\Service\UserAgent;


interface UserAgentServiceInterface
{
    public function parse($ua);
    public function browser();
    public function os();
}
