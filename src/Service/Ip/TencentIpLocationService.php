<?php

namespace Fu\Geo\Service\Ip;

use baohan\Collection\Collection;
use Fu\Geo\Area;
use Fu\Geo\AreaResponsable;
use Fu\Geo\Service\ServiceResponse;
use Fu\Geo\Service\TencentLocationService;

/**
 * 腾讯地理位置服务
 */
class TencentIpLocationService extends TencentLocationService implements IpLocationService
{
    /**
     * 根据IP地址查询所在地信息
     * {
     *     "status": 0,
     *     "message": "query ok",
     *     "result": {
     *         "ip": "171.221.208.34",
     *         "location": {
     *             "lat": 30.68144,
     *             "lng": 103.8559
     *         },
     *         "ad_info": {
     *             "nation": "中国",
     *             "province": "四川省",
     *             "city": "成都市",
     *             "district": "温江区",
     *             "adcode": 510115
     *         }
     *     }
     * }
     * @param string $ip
     * @return AreaResponsable
     */
    public function getLocation(string $ip): AreaResponsable
    {
        $response = new ServiceResponse();
        if ($this->invalid($ip)) {
            return $response;
        }
        $res = $this->getClient()->get(
            sprintf("ws/location/v1/ip?ip=%s&key=%s", $ip, $this->key)
        );
        if ($res->getStatusCode() != 200) {
            return $response;
        }
        $response->raw = (string) $res->getBody();
        $arr = json_decode($response->raw, true);
        if (json_last_error()) {
            return $response;
        }
        if (!isset($arr['result']['ad_info'])) {
            return $response;
        }
        $address = new Collection($arr['result']['ad_info']);
        if ($address['nation'] === '中国') {
            $response->area->nation = $address['nation'];
            $response->area->lv1 = $address['province'];
            $response->area->lv2 = $address['city'];
            $response->area->lv3 = $address['district'];
        } else {
            $response->area->nation = "海外";
            $response->area->lv1 = Area::getContinent($address['nation']);
            $response->area->lv2 = $address['nation'];
            $response->area->lv3 = $address['city'];
        }
        $response->ok = true;
        return $response;
    }

    /**
     * skip private ip
     * @param string $ip
     * @return bool
     */
    protected function invalid(string $ip): bool
    {
        $pattern = '/(^127\.)|(^10\.)|(^172\.1[6-9]\.)|(^172\.2[0-9]\.)|(^172\.3[0-1]\.)|(^192\.168\.)/';
        return preg_match($pattern, $ip) > 0;
    }
}
