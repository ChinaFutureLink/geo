<?php

use Fu\Geo\Service\Ip\IpGeoLocationService;
use PHPUnit\Framework\TestCase;

class IpGeoLocationServiceTest extends TestCase
{
    public function testInvalid()
    {
        $serv = new IpGeoLocationService();
        $this->assertTrue($serv->invalid("192.168.31.31"));
        $this->assertFalse($serv->invalid("214.32.64.128"));
        $this->assertTrue($serv->invalid("240e:468:882:163d:5db4:e616:e647:82e8"));
    }
}
