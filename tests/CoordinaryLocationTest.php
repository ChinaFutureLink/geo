<?php

use Fu\Geo\Service\Coordinary\TencentCoordinaryLocationService;
use PHPUnit\Framework\MockObject\Stub;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

class CoordinaryLocationTest extends TestCase
{
    public function testGetAreaFailureWithStatusCode()
    {
        $lng = 91.00000;
        $lat = 29.60000;
        $client = $this->createStub(\GuzzleHttp\Client::class);
        $client->method('__call')->willReturn($this->getResponse(400));
        $service = $this->getMockBuilder(TencentCoordinaryLocationService::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getClient'])
            ->getMock();
        $service->expects($this->any())->method('getClient')->willReturn($client);
        $response = $service->getLocation($lat, $lng);
        $this->assertEquals(false, $response->isOk());
    }

    public function testGetAreaFailureWithJson()
    {
        $lng = 91.00000;
        $lat = 29.60000;
        $client = $this->createStub(\GuzzleHttp\Client::class);
        $client->method('__call')->willReturn($this->getResponse(200, "ok"));
        $service = $this->getMockBuilder(TencentCoordinaryLocationService::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getClient'])
            ->getMock();
        $service->expects($this->any())->method('getClient')->willReturn($client);
        $response = $service->getLocation($lat, $lng);
        $this->assertEquals(false, $response->isOk());
        $this->assertEquals("ok", $response->getRaw());
    }

    public function testGetAreaSuccessWithChina()
    {
        $lng = 91.00000;
        $lat = 29.60000;
        $client = $this->createStub(\GuzzleHttp\Client::class);
        $client->method('__call')->willReturn($this->getResponse(200, '{"status":0,"message":"query ok","request_id":"990ca67c-a4ef-11ec-affd-5254005b3ff4","result":{"location":{"lat":29.6,"lng":91},"address":"西藏自治区拉萨市堆龙德庆区","formatted_addresses":{"recommend":"堆龙德庆乃琼街道奇米温","rough":"堆龙德庆乃琼街道奇米温"},"address_component":{"nation":"中国","province":"西藏自治区","city":"拉萨市","district":"堆龙德庆区","street":"","street_number":""},"ad_info":{"nation_code":"156","adcode":"540103","city_code":"156540100","name":"中国,西藏自治区,拉萨市,堆龙德庆区","location":{"lat":29.539949,"lng":91.007027},"nation":"中国","province":"西藏自治区","city":"拉萨市","district":"堆龙德庆区"},"address_reference":{"town":{"id":"540103002","title":"乃琼街道","location":{"lat":29.583599,"lng":90.743408},"_distance":0,"_dir_desc":"内"},"landmark_l2":{"id":"11143199694290767541","title":"奇米温","location":{"lat":29.598579,"lng":90.997543},"_distance":285.6,"_dir_desc":"东北"}}}}'));
        $service = $this->getMockBuilder(TencentCoordinaryLocationService::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getClient'])
            ->getMock();
        $service->expects($this->any())->method('getClient')->willReturn($client);
        $response = $service->getLocation($lat, $lng);
        $this->assertEquals(true, $response->isOk());
        $area = $response->getArea();
        $this->assertEquals('中国', $area->nation);
        $this->assertEquals('西藏自治区', $area->lv1);
        $this->assertEquals('拉萨市', $area->lv2);
        $this->assertEquals('堆龙德庆区', $area->lv3);
    }

    public function testGetAreaSuccessWithOversea()
    {
        $lng = 38.42000;
        $lat = 9.03000;
        $client = $this->createStub(\GuzzleHttp\Client::class);
        $client->method('__call')->willReturn($this->getResponse(200, '{"status":0,"message":"query ok","request_id":"c871d32c-a4f1-11ec-9503-525400ec65d1","result":{"location":{"lat":9.03,"lng":38.42},"address_component":{"nation":"埃塞俄比亚","ad_level_1":"Oromia","ad_level_2":"Mirab Shewa","ad_level_3":"Ejere","street":"","locality":""},"ad_info":{"nation_code":"231","city_code":"","location":{"lat":9.03,"lng":38.419998}},"address":"埃塞俄比亚OromiaMirab Shewa"}}'));
        $service = $this->getMockBuilder(TencentCoordinaryLocationService::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getClient'])
            ->getMock();
        $service->expects($this->any())->method('getClient')->willReturn($client);
        $response = $service->getLocation($lat, $lng);
        $this->assertEquals(true, $response->isOk());
        $area = $response->getArea();
        $this->assertEquals('海外', $area->nation);
        $this->assertEquals('非洲', $area->lv1);
        $this->assertEquals('埃塞俄比亚', $area->lv2);
        $this->assertEquals('Oromia', $area->lv3);
    }

    /**
     * 非法经纬度查询地域
     */
    public function testGetAreaInvalid()
    {
        $client = $this->createStub(\GuzzleHttp\Client::class);
        $client->method('__call')->willReturn($this->getResponse(200, "ok"));
        $service = $this->getMockBuilder(TencentCoordinaryLocationService::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getClient'])
            ->getMock();
        $service->expects($this->any())->method('getClient')->willReturn($client);
        $this->assertEquals(false, $service->getLocation(0.0, 0.0)->isOk());
        $this->assertEquals(false, $service->getLocation(-85.1, 1.0)->isOk());
        $this->assertEquals(false, $service->getLocation(85.1, 1.0)->isOk());
        $this->assertEquals(false, $service->getLocation(1.0, 180.1)->isOk());
        $this->assertEquals(false, $service->getLocation(1.0, -180.1)->isOk());
    }

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
}