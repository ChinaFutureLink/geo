<?php

namespace Fu\Geo\Service;

use GuzzleHttp\Client;

abstract class AliLocationService
{
    /**
     * @var Client
     */
    protected Client $client;

    public function __construct(string $key)
    {
        $this->client = new Client([
            'base_uri' => 'https://mobapi.market.alicloudapi.com',
            'headers' => ['Authorization' => 'APPCODE ' . $key],
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
