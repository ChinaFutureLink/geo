<?php

namespace Fu\Geo\Service\ChinaRegional;

use Fu\Geo\Responsable;

interface DistrictService
{
    /**
     * 查询最新中国行政区
     *
     * @return Responsable
     */
    public function getLocation(): Responsable;
}
