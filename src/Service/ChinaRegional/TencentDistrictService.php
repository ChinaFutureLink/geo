<?php

namespace Fu\Geo\Service\ChinaRegional;

use baohan\Collection\Collection;
use Fu\Geo\Area;
use Fu\Geo\Responsable;
use Fu\Geo\Service\ServiceResponse;
use Fu\Geo\Service\TencentLocationService;

/**
 * 腾讯地理位置服务
 * 查询最新中国行政区
 */
class TencentDistrictService extends TencentLocationService implements DistrictService
{
    /**
     * 查询最新中国行政区
     * https://apis.map.qq.com/ws/district/v1/list?key=QAQBZ-W6WC4-7GXUY-XF4RA-GXRW7-Y2BRX
     * @example ./data/tencent.china.regions.json
     * @return Responsable
     */
    public function getLocation(): Responsable
    {
        $response = new ServiceResponse();
        $res = $this->getClient()->get(
            sprintf("ws/district/v1/list?key=%s", $this->key)
        );
        if ($res->getStatusCode() != 200) {
            $response->message = $res->getReasonPhrase();
            return $response;
        }
        $response->raw = (string) $res->getBody();
        $response->ok = true;
        return $response;
    }
}
