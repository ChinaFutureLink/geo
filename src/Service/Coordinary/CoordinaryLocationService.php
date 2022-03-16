<?php

namespace Fu\Geo\Service\Coordinary;

use Fu\Geo\Responsable;

interface CoordinaryLocationService
{
    /**
     * 根据经纬度查询所在地信息
     *
     * @param float $latitude
     * @param float $longitude
     * @return Responsable
     */
    public function getLocation(float $latitude, float $longitude): Responsable;
}
