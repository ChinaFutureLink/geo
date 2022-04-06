<?php

namespace Fu\Geo\Data\Tencent;

class Item implements \JsonSerializable
{
    /**
     * @var string
     */
    protected string $name;

    /**
     * @var string
     */
    protected string $id;

    /**
     * @var array
     */
    protected array $alias = [];

    /**
     * @var array
     */
    protected array $pinyin = [];

    /**
     * @var float
     */
    protected float $latitude = 0.0;

    /**
     * @var float
     */
    protected float $longitude = 0.0;

    /**
     * @var int
     */
    protected int $start = 0;

    /**
     * @var int
     */
    protected int $end = 0;

    /**
     * @var Item[]
     */
    protected array $children = [];

    /**
     * @param array $object
     */
    public function __construct(array $object)
    {
        $this->id        = $object['id'];
        $this->name      = $object['fullname'];
        $this->alias     = array_unique([
            $object['name'],
            $object['fullname']
        ]);
        $this->pinyin    = (array) $object['pinyin'];
        $this->latitude  = (double) $object['location']['lat'];
        $this->longitude = (double) $object['location']['lng'];
        $this->start     = (int) $object['cidx'][0] ?? 0;
        $this->end       = (int) $object['cidx'][1] ?? 0;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return array
     */
    public function getAlias(): array
    {
        return $this->alias;
    }

    /**
     * @return array
     */
    public function getPinyin()
    {
        return $this->pinyin;
    }

    /**
     * @return float
     */
    public function getLatitude(): float
    {
        return $this->latitude;
    }

    /**
     * @return float
     */
    public function getLongitude(): float
    {
        return $this->longitude;
    }

    /**
     * @return int
     */
    public function getStart(): int
    {
        return $this->start;
    }

    /**
     * @return int
     */
    public function getEnd(): int
    {
        return $this->end;
    }

    /**
     * @return Items[]
     */
    public function getChildren(): array
    {
        return $this->children;
    }

    /**
     * @param Items $items
     */
    public function setChildren(Items $items): void
    {
        if ($this->start > 0) {
            $this->children = $items->slice($this->start, $this->end);
        }
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        $vars = get_object_vars($this);
        $vars['children'] = [];
        foreach ($this->getChildren() as $child) {
            $vars['children'][] = $child->jsonSerialize();
        }
        return $vars;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->jsonSerialize();
    }
}