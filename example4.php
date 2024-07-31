<?php
include "./vendor/autoload.php";

use Fu\Geo\Service\Ip\IpGeoLocationService;

$latitude  = 29.60001;
$longitude = 91.00001;

// example of cache
$ip = "198.27.124.186";  // 加拿大 魁北克 博阿努瓦 OVH
$ip = "193.47.102.45";   // 沙特阿拉伯
$ip = "185.60.216.11";   // 德国 黑森 法兰克福
$ip = "254.255.253.233";   // unknown
$ip = "174.37.243.85";   // 美国 弗吉尼亚 阿什本 SoftLayer
$ip = "31.13.94.7";      // 阿根廷 布宜诺斯艾利斯
$ip = "110.191.253.233"; // chengdu
$ip = "36.22.1.112";     // 浙江
$service = new IpGeoLocationService();
$response = $service->getLocation($ip);

if ($response->isOk()) {
    $area = $response->getArea();
    var_dump($area->toJson());
} else {
    // get the response raw data...
    var_dump($response->getRaw());
}