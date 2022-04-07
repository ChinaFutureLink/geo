<?php

namespace Fu\Geo\Data\Regional;

use Exception;

class District
{
    /**
     * @var Item
     */
    protected Item $china;

    /**
     * @var Item
     */
    protected Item $oversea;

    protected function __construct()
    {
    }

    /**
     * @param string $filepath
     * @return District
     * @throws Exception
     */
    public static function getInstanceFromJson(string $filepath): District
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

        $instance->china = new Item();
        $instance->china->setLabel('中国');
        $instance->china->setValue('中国');
        $instance->china->setEnglish('China');
        $instance->china->setChildren($instance->buildByJson($json[0]['children']));

        $instance->oversea = new Item();
        $instance->oversea->setLabel('海外');
        $instance->oversea->setValue('海外');
        $instance->oversea->setEnglish('Oversea');
        $instance->oversea->setChildren($instance->buildByJson($json[1]['children']));

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
            $item->setLabel($doc['label']);
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
     * @return Item
     */
    public function getChina(): Item
    {
        return $this->china;
    }

    /**
     * @param Item $china
     */
    public function setChina(Item $china): void
    {
        $this->china = $china;
    }

    /**
     * @return Item
     */
    public function getOversea(): Item
    {
        return $this->oversea;
    }

    /**
     * @param Item $oversea
     */
    public function setOversea(Item $oversea): void
    {
        $this->oversea = $oversea;
    }

    public function toArray(): array
    {
        return [
            $this->getChina()->toArray(),
            $this->getOversea()->toArray(),
        ];
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
        return "regional.{$version}.json";
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