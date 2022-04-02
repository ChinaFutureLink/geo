<?php

namespace Fu\Geo\Data\Tencent;

class City extends Item
{
    /**
     * @return string
     */
    public function getPrefix(): string
    {
        return substr($this->id, 0, 4);
    }
}