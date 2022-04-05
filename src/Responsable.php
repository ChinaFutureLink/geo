<?php

namespace Fu\Geo;

interface Responsable
{
    /**
     * @return bool
     */
    public function isOk(): bool;
    /**
     * @return string
     */
    public function getMessage(): string;
    /**
     * @return string
     */
    public function getRaw(): string;
}
