<?php

namespace Fu\Geo;

use baohan\Collection\Collection;

interface Responsable
{
    /**
     * @return bool
     */
    public function isOk(): bool;

    /**
     * @return Area
     */
    public function getArea(): Area;

    /**
     * @return string
     */
    public function getRaw(): string;
}