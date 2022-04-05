<?php

namespace Fu\Geo\Service\Ip;

use Fu\Geo\AreaResponsable;

interface IpLocationService
{
    /**
     * 根据IP地址查询所在地信息
     *
     * @param string $ip
     * @return AreaResponsable
     */
    public function getLocation(string $ip): AreaResponsable;
}
