<?php

namespace Fu\Geo\Service\Address;

use Fu\Geo\LocationResponsable;

interface AddressLocationService
{
    /**
     * 根据地名查询所在地信息
     *
     * @param string $address
     * @return LocationResponsable
     */
    public function getLocation(string $address): LocationResponsable;
}
