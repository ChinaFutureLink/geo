<?php

namespace Fu\Geo;

use baohan\Collection\Collection;

interface IService
{
    /**
     * 根据IP地址查询所在地信息
     *
     * @param  string $ip
     * @return Collection
     */
    public function getLocationByIp(string $ip): Collection;

    /**
     * 根据经纬度查询所在地信息
     *
     * @param  float $latitude
     * @param  float $longitude
     * @return Collection
     */
    public function getLocationByCoordinate(float $latitude, float $longitude): Collection;
}
