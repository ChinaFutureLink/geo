<?php

namespace Fu\Geo;

use baohan\Collection\Collection;
use Doctrine\Common\Cache\FilesystemCache;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\MessageFormatter;
use GuzzleHttp\Middleware;
use Kevinrob\GuzzleCache\CacheMiddleware;
use Kevinrob\GuzzleCache\Storage\DoctrineCacheStorage;
use Kevinrob\GuzzleCache\Strategy\GreedyCacheStrategy;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

/**
 * 腾讯地理位置服务
 */
class TencentGeoService implements IService
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var string
     */
    protected $key;

    public function __construct(string $key)
    {
        $this->key = $key;
        $log = new Logger('geo');
        $log->pushHandler(new StreamHandler('/var/log/fu/geo.log', Logger::DEBUG));
        $stack = HandlerStack::create();
        $stack->push(
            new CacheMiddleware(
                new GreedyCacheStrategy(
                    new DoctrineCacheStorage(
                        new FilesystemCache('/tmp/cache/')
                    ),
                    86400 * 30 * 12
                )
            ),
            'cache'
        );
        $stack->push(
            Middleware::log(
                $log,
                new MessageFormatter(),
                Logger::DEBUG
            )
        );
        $this->client = new Client(
            [
            'base_uri' => 'https://apis.map.qq.com/',
            'headers' => [
                'Content-Type' => "application/json",
                'Referer'      => 'https://stage.chinafuturelink.org'
            ],
            'timeout' => 30.0,
            'verify' => true,
            'debug' => false,
            'http_errors' => false,
            'handler' => $stack
            ]
        );
    }

    /**
     * 根据IP地址查询所在地信息
     *
     * @param  string $ip
     * @return Collection
     */
    public function getLocationByIp(string $ip): Collection
    {
        $res = $this->client->get(
            sprintf("ws/location/v1/ip?ip=%s&key=%s", $ip, $this->key)
        );
        if ($res->getStatusCode() != 200) {
            return new Collection();
        }
        $arr = json_decode((string)$res->getBody(), true);
        if (!isset($arr['result']['ad_info'])) {
            return new Collection();
        }
        return new Collection($arr['result']['ad_info']);
    }

    /**
     * 根据经纬度查询所在地信息
     *
     * @param  float $latitude
     * @param  float $longitude
     * @return Collection
     */
    public function getLocationByCoordinate(float $latitude, float $longitude): Collection
    {
        $res = $this->client->get(
            sprintf("ws/geocoder/v1/?location=%s,%s&key=%s", $latitude, $longitude, $this->key)
        );
        if ($res->getStatusCode() != 200) {
            return new Collection();
        }
        $json = json_decode((string) $res->getBody(), true);
        if (!isset($json['result']['address_component'])) {
            return new Collection();
        }
        return new Collection($json['result']['address_component']);
    }
}
