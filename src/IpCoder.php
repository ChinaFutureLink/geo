<?php
namespace Fu\Geo;

class IpCoder implements IAreaDecoder
{
    /**
     * @var string
     */
    protected $ip;
    
    /**
     * @param string $ip
     */
    public function __construct(string $ip)
    {
        $this->ip = $ip;
    }

    /**
     * @param IService $service
     * @return Area
     */
    public function getArea(IService $service): Area
    {
        $area = new Area();
        if ($this->invalid()) return $area;
        $address = $service->getLocationByIp($this->ip);
        if ($address['nation'] === '中国') {
            $area->nation = $address['nation'];
            $area->lv1 = $address['province'];
            $area->lv2 = $address['city'];
            $area->lv3 = $address['district'];
        } else {
            $area->nation = "海外";
            $area->lv1 = $area->getContinent($address['nation']);
            $area->lv2 = $address['nation'];
            $area->lv3 = $address['city'];
        }
        return $area;
    }
    
    /**
     * skip private ip
     * @return bool
     */
    protected function invalid(): bool
    {
        $pattern = '/(^127\.)|(^10\.)|(^172\.1[6-9]\.)|(^172\.2[0-9]\.)|(^172\.3[0-1]\.)|(^192\.168\.)/';
        return preg_match($pattern, $this->ip) > 0;
    }
}

