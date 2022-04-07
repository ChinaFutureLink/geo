<?php

namespace Fu\Geo\Data\Regional;

use Closure;
use Exception;
use Fu\Geo\Service\Address\AddressLocationService;

class Item
{
    /**
     * @var string
     */
    protected string $value;

    /**
     * 英语名称
     * @var string
     */
    protected string $english = "";

    /**
     * 完整名称
     * @example 台湾省高雄市新兴区
     * @var string
     */
    protected string $fullname;

    /**
     * @var Item[]
     */
    protected array $children = [];

    /**
     * @var Closure|null
     */
    protected ?Closure $callback = null;

    /**
     * @var bool
     */
    protected bool $original = false;

    /**
     * @var string
     */
    protected string $language = 'zh';

    public static function getInstanceFromJson(string $filepath): Item
    {
        $content = file_get_contents($filepath);
        if (!$content) {
            throw new Exception("The filepath is invalid: `{$filepath}`", 4000);
        }
        $json = json_decode($content, true);
        if (json_last_error()) {
            throw new Exception(json_last_error_msg(), 4001);
        }
        $instance = new static();
        $instance->setValue($json['value']);
        $instance->setFullname($json['fullname']);
        $instance->setEnglish($json['english']);
        $instance->setChildren($instance->buildByJson($json['children']));
        return $instance;
    }

    /**
     * @param array $json
     * @param array $children
     * @return Item[]
     */
    protected function buildByJson(array $json, array &$children = []): array
    {
        foreach ($json as $idx => $doc) {
            $item = new Item();
            $item->setValue($doc['value']);
            if (isset($doc['english'])) {
                $item->setEnglish($doc['english']);
            }
            if (isset($doc['children'])) {
                $children[$idx] = [];
                $item->setChildren($this->buildByJson($doc['children'], $children[$idx]));
            }
            $children[$idx] = $item;
        }
        return $children;
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        if ($this->language == 'en') {
            return $this->english;
        } else {
            return $this->value;
        }
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
     * @return string
     */
    public function getFullname(): string
    {
        return $this->fullname;
    }

    /**
     * @param string $fullname
     */
    public function setFullname(string $fullname): void
    {
        $this->fullname = $fullname;
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
     * @param bool $original
     * @return $this
     */
    public function original(bool $original): Item
    {
        $this->original = $original;
        return $this;
    }

    /**
     * @param string $language
     * @return $this
     */
    public function language(string $language): Item
    {
        $this->language = $language;
        return $this;
    }

    /**
     * @param Item[] $children
     * @param array|null $array
     * @param string|null $parent
     * @return array
     */
    public function toArray(?array $children = null, ?array &$array = null, ?string $parent = ""): array
    {
        if (!$children) {
            $children = $this->getChildren();
        }
        if ($array === null) {
            $array = [
                'label' => $this->language == 'en' ? $this->getEnglish() : $this->getValue(),
                'value' => $this->getValue(),
            ];
            if ($this->original === false) {
                $array['fullname'] = $this->getFullname();
                $array['english']  = $this->getEnglish();
            }
            $array['children'] = [];
            $array['children'] = $this->toArray($children, $array['children'], $parent);
        } else {
            foreach ($children as $idx => $child) {
                $grandson = $child->getChildren();
                $array[$idx] = [];
                $array[$idx]['label'] = $this->language == 'en' ? $child->getEnglish() : $child->getValue();
                $array[$idx]['value'] = $child->getValue();
                if ($this->original === false) {
                    $array[$idx]['fullname'] = $parent . $child->getValue();
                    $array[$idx]['english'] = $child->getEnglish();
                }
                if ($this->callback) {
                    $callback = $this->callback;
                    $callback($array[$idx]);
                }
                if ($grandson) {
                    $array[$idx]['children'] = [];
                    $array[$idx]['children'] = $this->toArray(
                        $grandson,
                        $array[$idx]['children'],
                        $parent . $child->getValue()
                    );
                }
            }
        }
        return $array;
    }

    /**
     * @param Closure|null $closure
     * @return $this
     */
    public function setArrayHandle(Closure $closure = null): Item
    {
        $this->callback = $closure;
        return $this;
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
    public function saveJsonFile(string $filename): string
    {
        $fp = fopen($filename, 'wb');
        fwrite($fp, $this->toJson());
        fclose($fp);
        return $filename;
    }
}