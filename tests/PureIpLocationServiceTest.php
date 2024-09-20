<?php

use Fu\Geo\Service\Ip\PureIpLocationService;
use PHPUnit\Framework\TestCase;

class PureIpLocationServiceTest extends TestCase
{
    public function testGetLocation()
    {
        $serv = new PureIpLocationService('');
        $this->assertEquals('', $serv->getLocation("223.104.40.201")->getArea()->lv3);
        $this->assertEquals('', $serv->getLocation("39.144.53.237")->getArea()->lv3);
    }
}
