<?php

namespace Fu\Geo\Service;

use Fu\Geo\Area;
use Fu\Geo\Responsable;

class ServiceResponse implements Responsable
{
    /**
     * @var bool
     */
    public bool $ok = false;

    /**
     * Response raw data
     * @var string
     */
    public string $raw = "";

    /**
     * @var Area
     */
    public Area $area;

    public function __construct()
    {
        $this->area = new Area();
    }

    /**
     * @return bool
     */
    public function isOk(): bool
    {
        return $this->ok;
    }

    public function getArea(): Area
    {
        return $this->area;
    }

    public function getRaw(): string
    {
        return $this->raw;
    }
}