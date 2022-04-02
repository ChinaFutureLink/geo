<?php

namespace Fu\Geo\Data\Regional;

class Item
{
    /**
     * @var string|mixed
     */
    protected string $label;

    /**
     * @var string|mixed
     */
    protected string $value;

    /**
     * @var string|mixed
     */
    protected string $id = "";

    /**
     * @var array|mixed
     */
    protected array $children = [];

    /**
     * @var bool
     */
    protected bool $delete = false;

    /**
     * @param array $object
     */
    public function __construct(array $object)
    {
        $this->label = $object['label'];
        $this->value = $object['value'];
        $this->children = $object['children'] ?? [];
    }

    /**
     * @return mixed|string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @return mixed|string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return Items|null
     */
    public function getChildren(): ?Items
    {
        if ($this->children) {
            return new Items($this->children);
        }
        return null;
    }

    /**
     * @param Items|null $children
     * @param array|null $array
     * @return array
     */
    public function toArray(?Items $children = null, ?array &$array = []): array
    {
        if ($this->delete === true) {
            return [];
        }
        if (!$children) {
            $children = $this->getChildren();
        }
        if ($array === null) {
            $array = [];
        }
        foreach ($children as $child) {
            $grandson = $child->getChildren();
            if ($grandson) {
                $array[$child->getLabel()] = $this->toArray($grandson, $array[$child->getLabel()]);
            } else {
                $array[$child->getLabel()] = $child->getValue();
            }
        }
        return $array;
    }

    /**
     * @param string $id
     * @return void
     */
    public function setId(string $id)
    {
        $this->id = $id;
    }

    /**
     * @return void
     */
    public function remove()
    {
        $this->delete = true;
    }
}