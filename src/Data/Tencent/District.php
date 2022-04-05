<?php

namespace Fu\Geo\Data\Tencent;

use Exception;
use Fu\Geo\Data\Regional;
use Fu\Geo\Service\ChinaRegional\DistrictService;

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
        $this->provinces = new Items($json['result'][0], Item::class);
        $this->cities    = new Items($json['result'][1], Item::class);
        $this->regions   = new Items($json['result'][2], Item::class);
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
     * @param array $array
     * @return string
     */
    public function toJson(array $array = []): string
    {
        if ($array) {
            $array = $this->toArray();
        }
        return json_encode($array);
    }

    /**
     * 输出在线regional格式的数据
     * @example ./data/regional_zh.json
     * @example ./data/regional_en.json
     * @return array
     */
    public function toRegional(): array
    {
        $regional = new Regional\District($this);
        return $regional->toArray();
    }

    /**
     * @param string $filename
     * @return void
     */
    public function saveJsonFile(string $filename = "")
    {
        if (!$filename) {
            $filename = "tencent.china.regions.{$this->version}.json";
        }
        $fp = fopen($filename, 'wb');
        fwrite($fp, $this->toJson());
        fclose($fp);
    }
}