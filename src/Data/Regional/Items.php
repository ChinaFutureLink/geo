<?php

namespace Fu\Geo\Data\Regional;

class Items implements \Iterator
{
    /**
     * @var array
     */
    protected array $array = [];
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
     * @return Item
     */
    public function current()
    {
        return new Item($this->array[$this->index]);
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
}