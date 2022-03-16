<?php

namespace Fu\Geo\Service\Coordinary;

use baohan\Collection\Collection;
use Fu\Geo\Area;
use Fu\Geo\Responsable;
use Fu\Geo\Service\ServiceResponse;
use Fu\Geo\Service\TencentLocationService;

/**
 * 腾讯地理位置服务
 */
class TencentCoordinaryLocationService extends TencentLocationService implements CoordinaryLocationService
{
    /**
     * 根据经纬度查询所在地信息
     * {
     *   "status": 0,
     *   "message": "query ok",
     *   "request_id": "990ca67c-a4ef-11ec-affd-5254005b3ff4",
     *   "result": {
     *     "location": {
     *       "lat": 29.6,
     *       "lng": 91
     *     },
     *     "address": "西藏自治区拉萨市堆龙德庆区",
     *     "formatted_addresses": {
     *       "recommend": "堆龙德庆乃琼街道奇米温",
     *       "rough": "堆龙德庆乃琼街道奇米温"
     *     },
     *     "address_component": {
     *       "nation": "中国",
     *       "province": "西藏自治区",
     *       "city": "拉萨市",
     *       "district": "堆龙德庆区",
     *       "street": "",
     *       "street_number": ""
     *     },
     *     "ad_info": {
     *       "nation_code": "156",
     *       "adcode": "540103",
     *       "city_code": "156540100",
     *       "name": "中国,西藏自治区,拉萨市,堆龙德庆区",
     *       "location": {
     *         "lat": 29.539949,
     *         "lng": 91.007027
     *       },
     *       "nation": "中国",
     *       "province": "西藏自治区",
     *       "city": "拉萨市",
     *       "district": "堆龙德庆区"
     *     },
     *     "address_reference": {
     *       "town": {
     *         "id": "540103002",
     *         "title": "乃琼街道",
     *         "location": {
     *           "lat": 29.583599,
     *           "lng": 90.743408
     *         },
     *         "_distance": 0,
     *         "_dir_desc": "内"
     *       },
     *       "landmark_l2": {
     *         "id": "11143199694290767541",
     *         "title": "奇米温",
     *         "location": {
     *           "lat": 29.598579,
     *           "lng": 90.997543
     *         },
     *         "_distance": 285.6,
     *         "_dir_desc": "东北"
     *       }
     *     }
     *   }
     * }
     * @param float $latitude
     * @param float $longitude
     * @return Responsable
     */
    public function getLocation(float $latitude, float $longitude): Responsable
    {
        $response = new ServiceResponse();
        if ($this->invalid($latitude, $longitude)) {
            return $response;
        }
        $res = $this->getClient()->get(
            sprintf("ws/geocoder/v1/?location=%s,%s&key=%s", $latitude, $longitude, $this->key)
        );
        if ($res->getStatusCode() != 200) {
            return $response;
        }
        $response->raw = (string) $res->getBody();
        $json = json_decode($response->raw, true);
        if (json_last_error()) {
            return $response;
        }
        if (!isset($json['result']['address_component'])) {
            return $response;
        }
        $address = new Collection($json['result']['address_component']);
        if ($address['nation']) {
            if ($address['nation'] === '中国') {
                $response->area->nation = $address['nation'];
                $response->area->lv1 = $address['province'];
                $response->area->lv2 = $address['city'];
                $response->area->lv3 = $address['district'];
            } else {
                $response->area->nation = "海外";
                $response->area->lv1 = Area::getContinent($address['nation']);
                $response->area->lv2 = $address['nation'];
                $response->area->lv3 = $address['ad_level_1'];
            }
        }
        $response->ok = true;
        return $response;
    }

    /**
     * skip invalid latitude or longitude
     * @param float $lat
     * @param float $lng
     * @return bool
     */
    protected function invalid(float $lat, float $lng): bool
    {
        if ($lat == 0   && $lng == 0) {
            return true;
        }
        if ($lat < -85  || $lat > 85) {
            return true;
        }
        if ($lng < -180 || $lng > 180) {
            return true;
        }
        return false;
    }
}
