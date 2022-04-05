<?php

namespace Fu\Geo;

interface AreaResponsable extends Responsable
{
    /**
     * @return Area
     */
    public function getArea(): Area;
}
