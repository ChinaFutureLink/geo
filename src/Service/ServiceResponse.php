<?php

namespace Fu\Geo\Service;

use Fu\Geo\Area;
use Fu\Geo\AreaResponsable;

class ServiceResponse implements AreaResponsable
{
    /**
     * @var bool
     */
    public bool $ok = false;

    /**
     * Response raw data
     * @var string
     */
    public string $message = "";

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

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return Area
     */
    public function getArea(): Area
    {
        return $this->area;
    }

    /**
     * @return string
     */
    public function getRaw(): string
    {
        return $this->raw;
    }
}
