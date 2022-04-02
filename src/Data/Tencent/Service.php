<?php

namespace Fu\Geo\Data\Tencent;

class Service
{
    /**
     * @var Items
     */
    protected $provinces;

    /**
     * @var Items
     */
    protected $cities;

    /**
     * @var Items
     */
    protected $regions;

    public function __construct()
    {
        $content = file_get_contents('./data/tencent.china.regions.json');
        $json = json_decode($content, true);
        $this->provinces = new Items($json['result'][0], Province::class);
        $this->cities    = new Items($json['result'][1], City::class);
        $this->regions   = new Items($json['result'][2], Item::class);
    }

    public function toArray(): array
    {
        $provinces = [];
        foreach ($this->provinces as $province) {
            $province->setChildren($this->cities);
//            foreach ($province->getChildren() as $city) {
//                $city->setChildren($this->regions);
//            }
            $provinces[] = $province->toArray();
        }
        return $provinces;
    }

    /**
     * @param Item $item
     * @param Items $map
     * @return Item[]
     */
    public function find(Item $item, Items $map): array
    {
        return $map->prefixMatch($item);
    }
}