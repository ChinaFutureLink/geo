<?php

use baohan\Collection\Collection;
use Fu\Geo\GeoCoder;
use Fu\Geo\TencentGeoService;
use PHPUnit\Framework\TestCase;

class GeoCoderTest extends TestCase
{
    /**
     * 拉萨经纬度:(91.00000,29.60000)
     */
    public function testGetAreaChina1()
    {
        $lng = 91.00000;
        $lat = 29.60000;

        $stub = $this->createStub(TencentGeoService::class);
        $stub->method('getLocationByCoordinate')
            ->willReturn(new Collection([
                'nation' => '中国1',
                'province' => '西藏自治区',
                'city' => '拉萨市',
                'district' => '堆龙德庆区',
            ]));

        $coder = new GeoCoder($lat, $lng);
        $area = $coder->getArea($stub);
        $this->assertEquals('中国', $area->nation);
        $this->assertEquals('西藏自治区', $area->lv1);
        $this->assertEquals('拉萨市', $area->lv2);
        $this->assertEquals('堆龙德庆区', $area->lv3);
    }

    /**
     * 乌鲁木齐经纬度:(87.68333,43.76667)
     */
    public function testGetAreaChina2()
    {
        $lng = 87.68333;
        $lat = 43.76667;
        $stub = $this->createStub(TencentGeoService::class);
        $stub->method('getLocationByCoordinate')
            ->willReturn(new Collection([
                'nation' => '中国',
                'province' => '新疆维吾尔自治区',
                'city' => '乌鲁木齐市',
                'district' => '天山区',
                'street' => 'C068',
                'street_number' => 'C068'
            ]));
        $coder = new GeoCoder($lat, $lng);
        $area = $coder->getArea($stub);
        $this->assertEquals('中国', $area->nation);
        $this->assertEquals('新疆维吾尔自治区', $area->lv1);
        $this->assertEquals('乌鲁木齐市', $area->lv2);
        $this->assertEquals('天山区', $area->lv3);
    }

    /**
     * 获取海外地址
     * Atlanta    亚特兰大    美国    北纬:33°46'    西经:84°25'
     */
    public function testGetAreaOversea1()
    {
        $lng = -84.25000;
        $lat = 33.46000;
        $coder = new GeoCoder($lat, $lng);
        $stub = $this->createStub(TencentGeoService::class);
        $stub->method('getLocationByCoordinate')
            ->willReturn(new Collection([
                'nation' => '美国',
                'ad_level_1' => '佐治亚州',
                'ad_level_2' => '亨利县',
                'ad_level_3' => '',
                'street' => '',
                'locality' => ''
            ]));
        $area = $coder->getArea($stub);
        $this->assertEquals('海外', $area->nation);
        $this->assertEquals('美洲', $area->lv1);
        $this->assertEquals('美国', $area->lv2);
        $this->assertEquals('佐治亚州', $area->lv3);
    }

    /**
     * 获取海外地址
     * Addis Ababa    亚的斯亚贝巴    埃塞俄比亚    北纬:9°03'    东经:38°42'
     */
    public function testGetAreaOversea2()
    {
        $lng = 38.42000;
        $lat = 9.03000;
        $coder = new GeoCoder($lat, $lng);
        $stub = $this->createStub(TencentGeoService::class);
        $stub->method('getLocationByCoordinate')
            ->willReturn(new Collection([
                'nation' => '埃塞俄比亚',
                'ad_level_1' => 'Oromia',
                'ad_level_2' => 'Mirab Shewa',
                'ad_level_3' => 'Ejere',
                'street' => '',
                'locality' => ''
            ]));
        $area = $coder->getArea($stub);
        $this->assertEquals('海外', $area->nation);
        $this->assertEquals('非洲', $area->lv1);
        $this->assertEquals('埃塞俄比亚', $area->lv2);
        $this->assertEquals('Oromia', $area->lv3);
    }

    /**
     * 获取未知地域
     */
    public function testGetAreaUnknownPlace()
    {
        $lng = -179.89300;
        $lat = 84.60000;
        $coder = new GeoCoder($lat, $lng);
        $stub = $this->createStub(TencentGeoService::class);
        $stub->method('getLocationByCoordinate')
            ->willReturn(new Collection([
                'nation' => 'Ocean',
                'ad_level_1' => '',
                'ad_level_2' => '',
                'ad_level_3' => '',
                'street' => '',
                'locality' => ''
            ]));
        $area = $coder->getArea($stub);
        $this->assertEquals('海外', $area->nation);
        $this->assertEquals('', $area->lv1);
        $this->assertEquals('Ocean', $area->lv2);
        $this->assertEquals('', $area->lv3);
    }

    /**
     * 成都
     */
    public function testGetAreaPlace2()
    {
        $lng = 104.0472;
        $lat = 30.6674;
        $coder = new GeoCoder($lat, $lng);
        $stub = $this->createStub(TencentGeoService::class);
        $stub->method('getLocationByCoordinate')
            ->willReturn(new Collection([
                'nation' => '中国',
                'province' => '四川省',
                'city' => '成都市',
                'district' => '金牛区',
                'street' => '枣子巷',
                'street_number' => '枣子巷'
            ]));
        $area = $coder->getArea($stub);
        $this->assertEquals('中国', $area->nation);
        $this->assertEquals('四川省', $area->lv1);
        $this->assertEquals('成都市', $area->lv2);
        $this->assertEquals('金牛区', $area->lv3);
    }

    /**
     * 非法经纬度查询地域
     */
    public function testGetAreaInvalid()
    {
        $stub = $this->createStub(TencentGeoService::class);
        $stub->method('getLocationByCoordinate')
            ->willReturn(new Collection(['unknown area']));
        $this->assertEquals('', (new GeoCoder(0.0, 0.0))->getArea($stub)->nation);
        $this->assertEquals('', (new GeoCoder(-85.1, 1.0))->getArea($stub)->nation);
        $this->assertEquals('', (new GeoCoder(85.1, 1.0))->getArea($stub)->nation);
        $this->assertEquals('', (new GeoCoder(1.0, 180.1))->getArea($stub)->nation);
        $this->assertEquals('', (new GeoCoder(1.0, -180.1))->getArea($stub)->nation);
    }
}