<?php

namespace Fu\Geo\Service;

use baohan\Collection\Collection;
use Fu\Geo\Area;
use Fu\Geo\HttpStack;
use Fu\Geo\Service\Phone\PhoneLocationService;
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
            'handler' => HttpStack::getStack()
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