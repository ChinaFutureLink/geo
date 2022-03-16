<?php

use Fu\Geo\Service\Phone\AliPhoneLocationService;
use PHPUnit\Framework\MockObject\Stub;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

class PhoneLocationTest extends TestCase
{
    /**
     * @param int $statusCode
     * @param string $body
     * @return Stub|ResponseInterface
     */
    protected function getResponse(int $statusCode = 200, string $body = ""): ResponseInterface
    {
        $res = $this->createStub(ResponseInterface::class);
        $res->method('getStatusCode')->willReturn($statusCode);
        $res->method('getBody')->willReturn($body);
        return $res;
    }

    public function testGetAreaFailureWithStatusCode()
    {
        $phone = '13880799123';
        $areaCode = '86';
        $client = $this->createStub(\GuzzleHttp\Client::class);
        $client->method('__call')->willReturn($this->getResponse(400));
        $service = $this->getMockBuilder(AliPhoneLocationService::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getClient'])
            ->getMock();
        $service->expects($this->any())->method('getClient')->willReturn($client);
        $response = $service->getLocation($areaCode, $phone);
        $this->assertEquals(false, $response->isOk());
    }

    public function testGetAreaSuccessInChina()
    {
        $phone = '13880799123';
        $areaCode = '86';
        $client = $this->createStub(\GuzzleHttp\Client::class);
        $client->method('__call')->willReturn($this->getResponse(200, '{"carrier":"移动","province":"四川","city":"成都","mobile":"13880799177","resultCode":"0","resultMsg":"查询成功！"}'));
        $service = $this->getMockBuilder(AliPhoneLocationService::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getClient'])
            ->getMock();
        $service->expects($this->any())->method('getClient')->willReturn($client);
        $response = $service->getLocation($areaCode, $phone);
        $this->assertEquals(true, $response->isOk());
        $area = $response->getArea();
        $this->assertEquals('中国', $area->nation);
        $this->assertEquals('四川省', $area->lv1);
        $this->assertEquals('成都市', $area->lv2);
        $this->assertEquals('', $area->lv3);
    }

    public function testGetAreaSuccessOversea()
    {
        $phone = '13880799123';
        $areaCode = '45';
        $client = $this->createStub(\GuzzleHttp\Client::class);
        $client->method('__call')->willReturn($this->getResponse());
        $service = $this->getMockBuilder(AliPhoneLocationService::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getClient'])
            ->getMock();
        $service->expects($this->any())->method('getClient')->willReturn($client);
        $response = $service->getLocation($areaCode, $phone);
        $this->assertEquals(true, $response->isOk());
        $area = $response->getArea();
        $this->assertEquals('海外', $area->nation);
        $this->assertEquals('欧洲', $area->lv1);
        $this->assertEquals('丹麦', $area->lv2);
        $this->assertEquals('', $area->lv3);
    }
}