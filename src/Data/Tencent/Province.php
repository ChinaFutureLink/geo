<?php

namespace Fu\Geo\Data\Tencent;

class Province extends Item
{
    /**
     * @return string
     */
    public function getPrefix(): string
    {
        return substr($this->id, 0, 2);
    }
}