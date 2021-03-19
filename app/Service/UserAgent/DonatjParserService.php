<?php


namespace App\Service\UserAgent;


use donatj\UserAgent\UserAgentParser;

class DonatjParserService implements UserAgentServiceInterface
{
    protected $data;
    protected $parser;

    public function __construct()
    {
        $this->parser = new UserAgentParser();
    }

    public function parse($ua)
    {
        $this->data = $this->parser->parse($ua);
    }

    public function browser()
    {
        return $this->data->browser();
    }

    public function os()
    {
        return $this->data->platform();
    }
}
