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

    /**
     * initial regional district
     */
    public function __construct()
    {
        $this->oversea = new Item();
        $this->oversea->setEnglish('Oversea');
        $this->oversea->setValue('海外');
        $this->oversea->setFullname('海外');

        $this->china = new Item();
        $this->china->setEnglish('China');
        $this->china->setValue('中国');
        $this->china->setFullname('中国');
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
     * @return Item
     */
    public function setChina(Item $china): Item
    {
        $this->china->setChildren($china->getChildren());
        return $this->china;
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
     * @return Item
     */
    public function setOversea(Item $oversea): Item
    {
        $this->oversea->setChildren($oversea->getChildren());
        return $this->oversea;
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