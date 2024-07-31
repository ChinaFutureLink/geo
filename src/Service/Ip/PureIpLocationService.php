<?php

namespace Fu\Geo\Service\Ip;

use baohan\Collection\Collection;
use Fu\Geo\Area;
use Fu\Geo\AreaResponsable;
use Fu\Geo\Service\ServiceResponse;
use Fu\Geo\Data\Regional;
use GuzzleHttp\Client;

/**
 * 纯真全球IP地理位置库
 * https://market.aliyun.com/apimarket/detail/cmapi00053387#sku=yuncode4738700005
 */
class PureIpLocationService implements IpLocationService
{
    /**
     * @var Client
     */
    protected Client $client;
    private Regional\Item $item;
    private Regional\Patch $patch;

    public function __construct(string $appcode)
    {
        $this->client = new Client([
            'base_uri' => 'https://cz88geoaliyun.cz88.net',
            'headers' => [
                'Content-Type' => "application/json",
                'Authorization' => "APPCODE " . $appcode
            ],
            'timeout' => 5.0,
            'verify' => true,
            'debug' => false,
            'http_errors' => false,
        ]);
        $file = dirname(dirname(dirname(dirname(__FILE__)))).'/data/regional.china.model.json';
        $this->item = Regional\Item::getInstanceFromJson($file);
        $this->patch = new Regional\Patch();
    }

    /**
     * 根据IP地址查询所在地信息
     * {
     *     "code": 200,
     *     "data": {
     *         "continent": "AS",
     *         "countryCode": "CN",
     *         "geoCenter": {
     *             "latitude": "30.682071",
     *             "longitude": "103.979611"
     *         },
     *         "iana": "中国",
     *         "ianaEn": "CN",
     *         "ip": "110.191.253.233",
     *         "country": "中国",
     *         "province": "四川",
     *         "city": "成都",
     *         "districts": "青羊区",
     *         "isp": "中国电信",
     *         "geocode": "156051001005",
     *         "provinceCode": "510000",
     *         "cityCode": "510100",
     *         "districtCode": "510105"
     *     },
     *     "message": "操作成功",
     *     "success": true,
     *     "time": "2024-07-31 14:24:54"
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
        $res = $this->client->get(
            sprintf("/search/ip/geo?ip=%s", $ip)
        );
        if ($res->getStatusCode() != 200) {
            return $response;
        }
        $response->raw = (string) $res->getBody();
        $arr = json_decode($response->raw, true);
        if (json_last_error()) {
            return $response;
        }
        if (!$arr['success']) {
            return $response;
        }
        $address = new Collection($arr['data']);
        if ($address['country'] === '中国') {
            $area = [
                $address['country'],
                $address['province'],
                $address['city'],
                $address['districts']
            ];
            $this->patch->fix($area, $this->item);
            $response->area->nation = $area[0];
            $response->area->lv1 = $area[1];
            $response->area->lv2 = $area[2];
            $response->area->lv3 = $area[3];
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
