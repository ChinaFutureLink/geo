<?php

namespace Fu\Geo\Service\Ip;

use Fu\Geo\Responsable;

interface IpLocationService
{
    /**
     * 根据IP地址查询所在地信息
     *
     * @param string $ip
     * @return Responsable
     */
    public function getLocation(string $ip): Responsable;
}
