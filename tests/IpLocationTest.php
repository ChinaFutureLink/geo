<?php
use Fu\Geo\Service\Ip\TencentIpLocationService;
use PHPUnit\Framework\MockObject\Stub\Stub;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

class IpLocationTest extends TestCase
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
        $ip = '171.221.208.34';
        $client = $this->createStub(\GuzzleHttp\Client::class);
        $client->method('__call')->willReturn($this->getResponse(400));
        $service = $this->getMockBuilder(TencentIpLocationService::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getClient'])
            ->getMock();
        $service->expects($this->any())->method('getClient')->willReturn($client);
        $response = $service->getLocation($ip);
        $this->assertEquals(false, $response->isOk());
    }

    public function testGetAreaSuccess()
    {
        $ip = '171.221.208.34';
        $client = $this->createStub(\GuzzleHttp\Client::class);
        $client->method('__call')->willReturn($this->getResponse(200, '{"status":0,"message":"query ok","result":{"ip":"171.221.208.34","location":{"lat":30.68144,"lng":103.8559},"ad_info":{"nation":"中国","province":"四川省","city":"成都市","district":"温江区","adcode":510115}}}'));
        $service = $this->getMockBuilder(TencentIpLocationService::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getClient'])
            ->getMock();
        $service->expects($this->any())->method('getClient')->willReturn($client);
        $response = $service->getLocation($ip);
        $this->assertEquals(true, $response->isOk());
        $area = $response->getArea();
        $this->assertEquals('中国', $area->nation);
        $this->assertEquals('四川省', $area->lv1);
        $this->assertEquals('成都市', $area->lv2);
        $this->assertEquals('温江区', $area->lv3);
    }

    /**
     * 内网IP地点查询
     */
    public function testGetAreaInternalIp()
    {
        $client = $this->createStub(\GuzzleHttp\Client::class);
        $client->method('__call')->willReturn($this->getResponse());
        $service = $this->getMockBuilder(TencentIpLocationService::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getClient'])
            ->getMock();
        $service->expects($this->any())->method('getClient')->willReturn($client);

        $this->assertEquals(false, $service->getLocation('127.0.0.1')->isOk());
        $this->assertEquals(false, $service->getLocation('10.0.0.1')->isOk());
        $this->assertEquals(false, $service->getLocation('172.16.0.1')->isOk());
        $this->assertEquals(false, $service->getLocation('172.17.0.1')->isOk());
        $this->assertEquals(false, $service->getLocation('172.18.0.1')->isOk());
        $this->assertEquals(false, $service->getLocation('172.19.0.1')->isOk());
        $this->assertEquals(false, $service->getLocation('172.29.0.1')->isOk());
        $this->assertEquals(false, $service->getLocation('172.31.0.1')->isOk());
        $this->assertEquals(false, $service->getLocation('192.168.0.1')->isOk());
    }
}