<?php

namespace Fu\Geo\Data\Tencent;

use Exception;
use Fu\Geo\Data\Regional;
use Fu\Geo\Service\Address\AddressLocationService;
use Fu\Geo\Service\District\DistrictService;

class District
{
    /**
     * @var Items
     */
    protected Items $provinces;

    /**
     * @var Items
     */
    protected Items $cities;

    /**
     * @var Items
     */
    protected Items $regions;

    /**
     * @var string
     */
    protected string $version;

    /**
     * @throws Exception
     */
    protected function __construct(array $json)
    {
        $this->version   = $json['data_version'];
        $this->provinces = new Items($json['result'][0]);
        $this->cities    = new Items($json['result'][1]);
        $this->regions   = new Items($json['result'][2]);
    }

    /**
     * @param DistrictService $service
     * @return District
     * @throws Exception
     */
    public static function getInstanceFromService(DistrictService $service): District
    {
        $response = $service->getLocation();
        if (!$response->isOk()) {
            throw new Exception($response->getMessage());
        }
        $json = json_decode($response->getRaw(), true);
        if (json_last_error()) {
            throw new Exception(json_last_error_msg(), 4001);
        }
        return new static($json);
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
        return new static($json);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $provinces = [];
        foreach ($this->provinces as $province) {
            $province->setChildren($this->cities);
            foreach ($province->getChildren() as $city) {
                $city->setChildren($this->regions);
            }
            $provinces[] = $province->toArray();
        }
        return $provinces;
    }

    /**
     * @return string
     */
    public function toJson(): string
    {
        return json_encode($this->toArray());
    }

    /**
     * 输出在线regional格式的数据
     * @return Regional\District
     * @throws Exception
     * @example ./data/regional_en.json
     * @example ./data/regional_zh.json
     */
    public function toRegional(): Regional\District
    {
        $lv1s = [];
        foreach ($this->provinces as $province) {
            $lv1 = new Regional\Item();
            $lv1->setLabel($province->getName());
            $lv1->setValue($province->getName());
            $province->setChildren($this->cities);
            $lv2s = [];
            foreach ($province->getChildren() as $city) {
                $lv2 = new Regional\Item();
                $lv2->setLabel($city->getName());
                $lv2->setValue($city->getName());
                $city->setChildren($this->regions);
                $lv3s = [];
                foreach ($city->getChildren() as $region) {
                    $lv3 = new Regional\Item();
                    $lv3->setLabel($region->getName());
                    $lv3->setValue($region->getName());
                    $lv3s[] = $lv3;
                }
                $lv2->setChildren($lv3s);
                $lv2s[] = $lv2;
            }
            $lv1->setChildren($lv2s);
            $lv1s[] = $lv1;
        }
        $item = new Regional\Item();
        $item->setLabel('中国');
        $item->setValue('中国');
        $item->setChildren($lv1s);

        $district = Regional\District::getInstanceFromJson('./data/regional_zh.json');
        $district->setChina($item);
        return $district;
    }

    /**
     * @return string
     */
    protected function getJsonFilename(): string
    {
        $version = $this->version ?? strftime('%Y%m%d');
        return "tencent.china.regions.{$version}.json";
    }

    /**
     * @param string $dirname
     * @return void
     */
    public function saveJsonFile(string $dirname)
    {
        $filename = rtrim($dirname, '/') . "/" . $this->getJsonFilename();
        $fp = fopen($filename, 'wb');
        fwrite($fp, $this->toJson());
        fclose($fp);
    }
}