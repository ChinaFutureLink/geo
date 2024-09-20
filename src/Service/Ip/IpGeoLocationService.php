<?php

namespace Fu\Geo\Service\Ip;

use Fu\Geo\Area;
use Fu\Geo\AreaResponsable;
use Fu\Geo\Service\ServiceResponse;
use Fu\Geo\Data\Regional;
use GeoIp2\Database\Reader;
use GeoIp2\Exception\AddressNotFoundException;
use MaxMind\Db\Reader\InvalidDatabaseException;

/**
 * IPGEO基于maxmind地理数据库服务
 */
class IpGeoLocationService implements IpLocationService
{
    private Regional\Item $item;
    private Regional\Patch $patch;

    public function __construct()
    {
        $file = dirname(dirname(dirname(dirname(__FILE__)))).'/data/regional.china.model.json';
        $this->item = Regional\Item::getInstanceFromJson($file);
        $this->patch = new Regional\Patch();
    }

    /**
     * 根据IP地址查询所在地信息
     * @param string $ip
     * @return AreaResponsable
     * @throws InvalidDatabaseException
     */
    public function getLocation(string $ip): AreaResponsable
    {
        $response = new ServiceResponse();
        if ($this->invalid($ip)) {
            return $response;
        }
        try {
            $reader = new Reader(dirname(__FILE__).'/GeoLite2-City.mmdb', ['en', 'zh-CN']);
            $result = $reader->city($ip);
        } catch (AddressNotFoundException $e) {
            return $response;
        }
//        var_dump($result->city->names);
//        var_dump($result->subdivisions[0]->names['zh-CN']);
//        var_dump($result->country->names['zh-CN']);
//        var_dump($result->continent->names['zh-CN']);
//        var_dump($result);
        $nation = (string) ($result->country->names['zh-CN'] ?? $result->country->names['en'] ?? '');
        if ($nation === '中国') {
            $area = [
                $nation,
                (string) ($result->subdivisions[0]->names['zh-CN'] ?? $result->subdivisions[0]->names['en'] ?? ''),
                (string) ($result->city->names['zh-CN'] ?? $result->city->names['en'] ?? ''),
                ''
            ];
            $this->patch->fix($area, $this->item);
            $response->area->nation = $area[0];
            $response->area->lv1 = $area[1];
            $response->area->lv2 = $area[2];
            $response->area->lv3 = $area[3];
        } else {
            $response->area->nation = "海外";
            $response->area->lv1 = Area::getContinent($nation);
            $response->area->lv2 = $nation;
            $response->area->lv3 = (string) ($result->city->names['zh-CN'] ?? $result->city->names['en'] ?? '');
        }
        $response->ok = true;
        return $response;
    }

    /**
     * skip private ip
     * @param string $ip
     * @return bool
     */
    public function invalid(string $ip): bool
    {
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            $pattern = '/(^127\.)|(^10\.)|(^172\.1[6-9]\.)|(^172\.2[0-9]\.)|(^172\.3[0-1]\.)|(^192\.168\.)/';
            return preg_match($pattern, $ip) > 0;
        }
        return true;
    }
}
