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
    protected array $items = [];
    /**
     * @var int
     */
    protected int $index = 0;
    /**
     * @var string
     */
    protected string $class = Item::class;

    public function __construct(array $array, string $class)
    {
        $this->array = $array;
        $this->index = 0;
        $this->class = $class;
        foreach ($this as $item) {
            $this->items[$item->getId()] = $item;
        }
    }

    /**
     * @return Item
     */
    public function current()
    {
        $class = $this->class;
        return new $class($this->array[$this->index]);
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

    /**
     * @param Item $parent
     * @return Item[]
     */
    public function prefixMatch(Item $parent): array
    {
        $arr = [];
        foreach ($this->items as $item) {
            if (substr($item->getId(), 0, strlen($parent->getPrefix())) === $parent->getPrefix()) {
                $arr[] = $item;
            }
        }
        return $arr;
    }

    /**
     * @param int $start
     * @param int $end
     * @return Item[]
     */
    public function slice(int $start, int $end): array
    {
        var_dump('start='.$start);
        var_dump('end='.$end);
        $this->index = $start;
        $array = [];
        foreach ($this as $item) {
//            $array[] = $item;
            if ($this->index === $end) {
                var_dump('index === end'. $this->index);
                break;
            }
        }
        $this->rewind();
        return $array;
    }
}