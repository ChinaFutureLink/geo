<?php

namespace Fu\Geo\Data\Regional;

class District
{
    /**
     * @var array
     */
    protected $china = [];

    /**
     * @var array
     */
    protected $oversea = [];

    public function __construct()
    {
        $content = file_get_contents('./regional_zh.json');
        $json = json_decode($content, true);
        $this->china = $json[0];
        $this->oversea = $json[1];
    }

    public function getChina(): Item
    {
        return new Item($this->china);
    }

    public function getOversea(): Item
    {
        return new Item($this->oversea);
    }
}