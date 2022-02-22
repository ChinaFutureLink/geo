<?php
namespace Fu\Geo;

/**
 * 根据经纬度获取地理信息
 * @category
 */
class GeoCoder implements IAreaDecoder
{
    /**
     * @var double
     */
    protected $lat;
    /**
     * @var double
     */
    protected $lng;
    
    /**
     * @param float $lat
     * @param float $lng
     */
    public function __construct(float $lat, float $lng)
    {
        $this->lat = $lat;
        $this->lng = $lng;
    }

    /**
     * @param IService $service
     * @return Area
     */
    public function getArea(IService $service): Area
    {
        $area = new Area();
        if ($this->invalid()) return $area;
        $address = $service->getLocationByCoordinate($this->lat, $this->lng);
        if ($address['nation']) {
            if ($address['nation'] === '中国') {
                $area->nation = $address['nation'];
                $area->lv1 = $address['province'];
                $area->lv2 = $address['city'];
                $area->lv3 = $address['district'];
            } else {
                $area->nation = "海外";
                $area->lv1 = $area->getContinent($address['nation']);
                $area->lv2 = $address['nation'];
                $area->lv3 = $address['ad_level_1'];
            }
        }
        return $area;
    }
    
    /**
     * skip invalid latitude or longitude
     * @return bool
     */
    protected function invalid(): bool
    {
        if ($this->lat == 0   && $this->lng == 0)  return true;
        if ($this->lat < -85  || $this->lat > 85)  return true;
        if ($this->lng < -180 || $this->lng > 180) return true;
        return false;
    }
}

