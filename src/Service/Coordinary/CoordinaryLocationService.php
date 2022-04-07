<?php

namespace Fu\Geo\Service\Coordinary;

use Fu\Geo\AreaResponsable;

interface CoordinaryLocationService
{
    /**
     * 根据经纬度查询所在地信息
     *
     * @param float $latitude
     * @param float $longitude
     * @return AreaResponsable
     */
    public function getLocation(float $latitude, float $longitude): AreaResponsable;
}
