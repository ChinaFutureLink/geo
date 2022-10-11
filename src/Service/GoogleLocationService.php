<?php

namespace Fu\Geo\Service;

use GuzzleHttp\Client;

/**
 * Google地理位置服务
 */
abstract class GoogleLocationService
{
    /**
     * @var Client
     */
    protected Client $client;

    /**
     * @var string
     */
    protected string $key = "";

    public function __construct(string $key)
    {
        $this->key = $key;
        $this->client = new Client([
            'base_uri' => 'https://maps.googleapis.com/',
            'headers' => [
                'Content-Type' => "application/json",
                'Referer'      => 'https://stage.chinafuturelink.org'
            ],
            'timeout' => 30.0,
            'verify' => true,
            'debug' => false,
            'http_errors' => false,
        ]);
    }

    /**
     * @return Client
     */
    public function getClient(): Client
    {
        return $this->client;
    }
}
