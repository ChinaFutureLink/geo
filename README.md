![CircleCI](https://img.shields.io/circleci/build/github/ChinaFutureLink/geo?token=ee171180870495cfee063b82e5884041441e8e5a)
[![codecov](https://codecov.io/gh/ChinaFutureLink/geo/branch/main/graph/badge.svg?token=IPK00XGNNG)](https://codecov.io/gh/ChinaFutureLink/geo)

ChinaFutureLink/GEO
====

提供地理服务相关接口。

## Installing / Getting started

通过Composer安装

```
composer require fu/geo 2.*
```

将下面的代码加入composer.json
```json
{
    "require": {
    	"fu/geo": "2.*"
    }
}
```

## Developing

### Building
```bash
> vendor/bin/phpcs --standard=PSR12 src
> vendor/bin/phpcbf --standard=PSR12 src
> vendor/bin/phpunit 

Generating code coverage report in HTML format ... done [00:00.020]
```

## Features
### 根据经纬度查询地理位置信息
```php
include "./vendor/autoload.php";

use Fu\Geo\GeoCoder;
use Fu\Geo\Service\Coordinary\TencentCoordinaryLocationService;

const KEY = "YOUR-TENCENT-GEO-SERVICE-KEY";

$latitude  = 29.60001;
$longitude = 91.00001;

$service = new TencentCoordinaryLocationService(KEY);
$response = $service->getLocation($latitude, $longitude);

if ($response->isOk()) {
    $area = $response->getArea();
    $area->nation; // 中国
    $area->lv1;    // 西藏自治区
    $area->lv2;    // 拉萨市
    $area->lv3;    // 堆龙德庆区
} else {
    // get the response raw data...
    var_dump($response->getRaw());   
}
```

### 根据IP地址查询地理位置信息
```php
include "./vendor/autoload.php";

use Fu\Geo\IpCoder;
use Fu\Geo\Service\Ip\TencentIpLocationService;

const KEY = "YOUR-TENCENT-GEO-SERVICE-KEY";

$ip = '171.221.208.34';
$service = new TencentIpLocationService(KEY);
$response = $service->getLocation($ip);

if ($response->isOk()) {
    $area = $response->getArea()
    $area->nation; // 中国
    $area->lv1;    // 四川省
    $area->lv2;    // 成都市
    $area->lv3;    // 温江区
} else {
    // get the response raw data...
    var_dump($response->getRaw());
}
```

### 根据手机号码查询地理位置信息
```php
include "./vendor/autoload.php";

use Fu\Geo\IpCoder;
use Fu\Geo\Service\Phone\AliPhoneLocationService;

const KEY = "YOUR-ALI-SERVICE-KEY";

$areaCode = '86';
$phone = '13880799123';
$service = new AliPhoneLocationService(KEY);
$response = $service->getLocation($areaCode, $phone);

if ($response->isOk()) {
    $area = $response->getArea()
    $area->nation; // 中国
    $area->lv1;    // 四川省
    $area->lv2;    // 成都市
    $area->lv3;    // 温江区
} else {
    // get the response raw data...
    var_dump($response->getRaw());
}
```

## Links

* 腾讯地理位置服务：https://lbs.qq.com
* 阿里云市场[手机归属地查询服务](https://market.aliyun.com/products/57126001/cmapi00035993.html?spm=5176.730005.result.2.508935247c8qJv&innerSource=search_%E6%89%8B%E6%9C%BA%E5%BD%92%E5%B1%9E%E5%9C%B0_%E6%89%8B%E6%9C%BA%E5%8F%B7%E5%BD%92%E5%B1%9E%E5%9C%B0%E6%9F%A5%E8%AF%A2_%E6%89%8B%E6%9C%BA%E5%8F%B7%E6%9F%A5%E8%AF%A2%E8%BF%90%E8%90%A5%E5%95%86%20-%E6%89%8B%E6%9C%BA%E5%8F%B7%E5%BD%92%E5%B1%9E%E5%9C%B0%E7%B2%BE%E5%87%86%E6%9F%A5%E8%AF%A2API%E6%8E%A5%E5%8F%A3%E3%80%90%E6%94%AF%E6%8C%81%E4%B8%89%E7%BD%91%E5%92%8C%E8%99%9A%E5%95%86%E3%80%91#sku=yuncode2999300001) 

## Licensing

The code in this project is licensed under MIT license.