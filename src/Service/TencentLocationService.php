<?php

namespace Fu\Geo\Service;

use Fu\Geo\HttpStack;
use GuzzleHttp\Client;

/**
 * 腾讯地理位置服务
 */
abstract class TencentLocationService
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
            'base_uri' => 'https://apis.map.qq.com/',
            'headers' => [
                'Content-Type' => "application/json",
                'Referer'      => 'https://stage.chinafuturelink.org'
            ],
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
