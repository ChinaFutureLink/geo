<?php
namespace Fu\Geo\Data\Tencent;

use Iterator;
use Fu\Geo\Data\Regional\Item as RegionalItem;

class Items implements Iterator
{
    /**
     * @var array
     */
    protected array $array = [];
    /**
     * @var Item[]
     */
    protected array $caches = [];
    /**
     * @var int
     */
    protected int $index = 0;

    public function __construct(array $array)
    {
        $this->array = $array;
        $this->index = 0;
    }

    /**
     * @param int $index
     * @return Item
     */
    public function getItem(int $index): Item
    {
        if (!isset($this->caches[$index])) {
            $this->caches[$index] = new Item($this->array[$index]);
        }
        return $this->caches[$index];
    }

    /**
     * @return Item
     */
    public function current()
    {
        return $this->getItem($this->index);
    }

    /**
     * @return void
     */
    public function next()
    {
        $this->index++;
    }

    /**
     * @return int
     */
    public function key()
    {
        return $this->index;
    }

    /**
     * @return bool
     */
    public function valid(): bool
    {
        return isset($this->array[$this->index]);
    }

    /**
     * @return void
     */
    public function rewind()
    {
        $this->index = 0;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $array = [];
        foreach ($this as $item) {
            $array[$item->getId()] = $item->getName();
        }
        return $array;
    }

    /**
     * @param int $start
     * @param int $end
     * @return Item[]
     */
    public function slice(int $start, int $end): array
    {
        $array = [];
        for ($i = $start; $i < $end; $i++) {
            $item = $this->getItem($i);
            $array[] = $item;
        }
        return $array;
    }

    /**
     * @param RegionalItem $region
     * @return string
     */
    public function find(RegionalItem $region): string
    {
        foreach ($this as $item) {
            if ($region->getValue() === $item->getName()) {
                return $item->getId();
            }
        }
        return "";
    }
}