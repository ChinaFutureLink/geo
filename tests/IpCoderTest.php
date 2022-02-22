<?php
use baohan\Collection\Collection;
use Fu\Geo\IpCoder;
use Fu\Geo\TencentGeoService;
use PHPUnit\Framework\TestCase;

class IpCoderTest extends TestCase
{
    /**
     * 国内IP地点查询
     */
    public function testGetAreaChina1()
    {
        $ip = '171.221.208.34';
        $coder = new IpCoder($ip);
        $stub = $this->createStub(TencentGeoService::class);
        $stub->method('getLocationByIp')
            ->willReturn(new Collection([
                'nation' => '中国',
                'province' => '四川省',
                'city' => '成都市',
                'district' => '温江区',
                'adcode' => 510115
            ]));
        $area = $coder->getArea($stub);
        $this->assertEquals('中国', $area->nation);
        $this->assertEquals('四川省', $area->lv1);
        $this->assertEquals('成都市', $area->lv2);
        $this->assertEquals('温江区', $area->lv3);
    }

    /**
     * 海外IP地点查询
     */
    public function testGetAreaOversea()
    {
        $ip = '147.78.177.107';
        $coder = new IpCoder($ip);
        $stub = $this->createStub(TencentGeoService::class);
        $stub->method('getLocationByIp')
            ->willReturn(new Collection([
                'nation' => '德国',
                'province' => '',
                'city' => '',
                'district' => '',
                'adcode' => -1
            ]));
        $area = $coder->getArea($stub);
        $this->assertEquals('海外', $area->nation);
        $this->assertEquals('欧洲', $area->lv1);
        $this->assertEquals('德国', $area->lv2);
        $this->assertEquals('', $area->lv3);
    }

    /**
     * 内网IP地点查询
     */
    public function testGetAreaInternalIp()
    {
        $stub = $this->createStub(TencentGeoService::class);
        $stub->method('getLocationByIp')
            ->willReturn(new Collection(['message' => 'invalid area']));

        $ip = '127.0.0.1';
        $coder = new IpCoder($ip);
        $area = $coder->getArea($stub);
        $this->assertEquals('', $area->nation);

        $ip = '10.0.0.1';
        $coder = new IpCoder($ip);
        $area = $coder->getArea($stub);
        $this->assertEquals('', $area->nation);

        $ip = '172.16.0.1';
        $coder = new IpCoder($ip);
        $area = $coder->getArea($stub);
        $this->assertEquals('', $area->nation);

        $ip = '172.17.0.1';
        $coder = new IpCoder($ip);
        $area = $coder->getArea($stub);
        $this->assertEquals('', $area->nation);

        $ip = '172.18.0.1';
        $coder = new IpCoder($ip);
        $area = $coder->getArea($stub);
        $this->assertEquals('', $area->nation);

        $ip = '172.19.0.1';
        $coder = new IpCoder($ip);
        $area = $coder->getArea($stub);
        $this->assertEquals('', $area->nation);

        $ip = '172.29.0.1';
        $coder = new IpCoder($ip);
        $area = $coder->getArea($stub);
        $this->assertEquals('', $area->nation);

        $ip = '172.31.0.1';
        $coder = new IpCoder($ip);
        $area = $coder->getArea($stub);
        $this->assertEquals('', $area->nation);

        $ip = '192.168.0.1';
        $coder = new IpCoder($ip);
        $area = $coder->getArea($stub);
        $this->assertEquals('', $area->nation);
    }
}