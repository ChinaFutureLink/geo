<?php

namespace Fu\Geo\Service\Phone;

use baohan\Collection\Collection;
use Fu\Geo\Area;
use Fu\Geo\AreaResponsable;
use Fu\Geo\Service\AliLocationService;
use Fu\Geo\Service\ServiceResponse;

class AliPhoneLocationService extends AliLocationService implements PhoneLocationService
{
    /**
     * @param string $areaCode
     * @param string $phone
     * @return AreaResponsable
     */
    public function getLocation(string $areaCode, string $phone): AreaResponsable
    {
        $countries = [
            '886' => '台湾',
            '852' => '香港',
            '853' => '澳门'
        ];
        if ($areaCode == '86') {
            return $this->getLocationByChinesePhoneNumber($phone);
        } elseif (array_key_exists($areaCode, $countries)) {
            return $this->getExceptionLocation($countries[$areaCode]);
        } else {
            return $this->getLocationByOverseaPhoneNumber($areaCode);
        }
    }

    /**
     * @param string $areaCode
     * @return AreaResponsable
     */
    public function getLocationByOverseaPhoneNumber(string $areaCode): AreaResponsable
    {
        $response = new ServiceResponse();
        $country = Area::getCountryByAreaCode((int) $areaCode);
        if ($country) {
            $response->ok = true;
            $response->area = new Area();
            $response->area->nation = '海外';
            $response->area->lv1 = Area::getContinent($country);
            $response->area->lv2 = $country;
        }
        return $response;
    }

    /**
     * @param $country
     * @return ServiceResponse
     */
    public function getExceptionLocation($country): ServiceResponse
    {
        $response = new ServiceResponse();
        $response->ok = true;
        $response->area = new Area();
        $response->area->nation = "中国";
        $response->area->lv1 = $country;
        $response->area->lv2 = $country;
        return $response;
    }

    /**
     * 根据国内手机号查询地理信息
     * array(6) {
     *   ["carrier"]=>
     *   string(6) "移动"
     *   ["province"]=>
     *   string(6) "四川"
     *   ["city"]=>
     *   string(6) "成都"
     *   ["mobile"]=>
     *   string(11) "13880799177"
     *   ["resultCode"]=>
     *   string(1) "0"
     *   ["resultMsg"]=>
     *   string(15) "查询成功！"
     * }
     * @param string $phone
     * @return AreaResponsable
     */
    public function getLocationByChinesePhoneNumber(string $phone): AreaResponsable
    {
        $response = new ServiceResponse();
        $res = $this->getClient()->post('/gsd?mobile=' . $phone, []);
        if ($res->getStatusCode() != 200) {
            return $response;
        }
        $response->raw = (string) $res->getBody();
        $arr = json_decode($response->raw, true);
        if (json_last_error()) {
            return $response;
        }
        if (!isset($arr['resultCode']) || $arr['resultCode'] != 0) {
            return $response;
        }
        $mapping = Area::getMapping();
        $col = new Collection($arr);
        if (!empty($col['city']) && $col['city'] == '吉林') {
            $col['city'] = '吉林市';
        }
        if (!empty($col['city']) && $col['city'] == '海南' && $col['province'] == '青海') {
            $col['city'] = '海南州';
        }
        if (!empty($col['province'])) {
            $col['province'] = $mapping[$col['province']] ?? $col['province'];
        }
        if (!empty($col['city'])) {
            $col['city'] = $mapping[$col['city']] ?? $col['city'];
        }
        $response->area = new Area();
        $response->area->nation = '中国';
        $response->area->lv1 = $col['province'];
        $response->area->lv2 = $col['city'];
        $response->ok = true;
        return $response;
    }
}
