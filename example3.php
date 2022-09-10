<?php
include "./vendor/autoload.php";

use Fu\Geo\Service\Coordinary\TencentCoordinaryLocationService;

$key = "QAQBZ-W6WC4-7GXUY-XF4RA-GXRW7-Y2BRX";

$latitude  = 29.60001;
$longitude = 91.00001;

// example of cache
$service = new TencentCoordinaryLocationService($key);
$hash = $latitude.$latitude;
$ttl = 86400;
$response = $cache->get($hash);
if ($response) {
    $response = $service->getLocation($latitude, $longitude);
    $cache->set($hash, $response, $ttl);
}

if ($response->isOk()) {
    $area = $response->getArea();
    var_dump($area->toJson());
//    $area->nation; // 中国
//    $area->lv1;    // 西藏自治区
//    $area->lv2;    // 拉萨市
//    $area->lv3;    // 堆龙德庆区
} else {
    // get the response raw data...
    var_dump($response->getRaw());
}