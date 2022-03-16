<?php

namespace Fu\Geo\Service\Phone;

use Fu\Geo\Responsable;

interface PhoneLocationService
{
    /**
     * 根据区号和电话号码查询所在地信息
     * @param string $areaCode
     * @param string $phone
     * @return Responsable
     */
    public function getLocation(string $areaCode, string $phone): Responsable;
}
