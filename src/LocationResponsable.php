<?php

namespace Fu\Geo;

interface LocationResponsable extends Responsable
{
    /**
     * @return string
     */
    public function getLocationName(): string;
}
