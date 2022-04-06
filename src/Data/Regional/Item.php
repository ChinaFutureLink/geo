<?php

namespace Fu\Geo\Data\Regional;

use Fu\Geo\Service\Address\AddressLocationService;

class Item
{
    /**
     * @var string
     */
    protected string $label;

    /**
     * @var string
     */
    protected string $value;

    /**
     * 英语名称
     * @var string
     */
    protected string $english;

    /**
     * @var Item[]
     */
    protected array $children = [];

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @param string $label
     */
    public function setLabel(string $label): void
    {
        $this->label = $label;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param string $value
     */
    public function setValue(string $value): void
    {
        $this->value = $value;
    }

    /**
     * @return Item[]
     */
    public function getChildren(): array
    {
        return $this->children??[];
    }

    /**
     * @param Item[] $children
     */
    public function setChildren(array $children): void
    {
        $this->children = $children;
    }

    /**
     * @return string
     */
    public function getEnglish(): string
    {
        return $this->english;
    }

    /**
     * @param string $english
     */
    public function setEnglish(string $english): void
    {
        $this->english = $english;
    }

    /**
     * @param AddressLocationService $service
     * @return string
     */
    public function setEnglishByService(AddressLocationService $service): string
    {
        $res = $service->getLocation($this->getValue());
        $this->english = $res->getLocationName();
        return $this->english;
    }

    /**
     * @param Item[] $children
     * @param array|null $array
     * @return array
     */
    public function toArray(?array $children = null, ?array &$array = []): array
    {
        if (!$children) {
            $children = $this->getChildren();
        }
        if ($array === null) {
            $array = [];
        }
        foreach ($children as $idx => $child) {
            $grandson = $child->getChildren();
            $array[$idx] = [];
            if ($grandson) {
                $array[$idx]['label'] = $child->getLabel();
                $array[$idx]['value'] = $child->getValue();
                $array[$idx]['children'] = $this->toArray($grandson, $array[$idx]['children']);
            } else {
                $array[$idx]['label'] = $child->getLabel();
                $array[$idx]['value'] = $child->getValue();
            }
        }
        return $array;
    }

    /**
     * @param array|null $children
     * @param array|null $array
     * @return array
     */
    public function toNames(?array $children = null, ?array &$array = [], ?string $parent = ""): array
    {
        if (!$children) {
            $children = $this->getChildren();
        }
        if ($array === null) {
            $array = [];
        }
        if ($parent === null) {
            $parent = "";
        }
        foreach ($children as $child) {
            $grandson = $child->getChildren();
            if ($grandson) {
                $array[] = ['zh' => $parent.$child->getValue()];
                $this->toNames($grandson, $array, $parent.$child->getValue());
            } else {
                $array[] = ['zh' => $parent.$child->getValue()];
            }
        }
        return $array;
    }

    /**
     * @return string
     */
    public function toJson(): string
    {
        return json_encode($this->toArray());
    }

    /**
     * @return string
     */
    protected function getJsonFilename(): string
    {
        $version = strftime('%Y%m%d');
        return "regional.regions.{$version}.json";
    }

    /**
     * @param string $dirname
     * @return string saved filename
     */
    public function saveJsonFile(string $dirname): string
    {
        $filename = rtrim($dirname, '/') . "/" . $this->getJsonFilename();
        $fp = fopen($filename, 'wb');
        fwrite($fp, $this->toJson());
        fclose($fp);
        return $filename;
    }
}