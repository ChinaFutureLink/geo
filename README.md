![CircleCI](https://img.shields.io/circleci/build/github/ChinaFutureLink/geo?token=ee171180870495cfee063b82e5884041441e8e5a)


ChinaFutureLink/GEO
====

提供地理服务相关接口。

## Installing / Getting started

将下面的代码加入composer.json
```json
{
    "require": {
    	"fu/geo": "dev-master"
    },
    "repositories":[{
        "type": "vcs",
        "url": "git@bitbucket.org:china_future_link/fu-geo.git"
    }]
}
```
然后运行（确保ssh Key已经部署到了bitbucket.org的相关仓库）：

```shell
> git clone git@github.com:ChinaFutureLink/geo.git
> composer install -v
```

## Developing

### Building
```bash
> ./vendor/bin/phpcs --standard=PSR12 ./src

FILE: /data/src/GeoCoder.php
-------------------------------------------------------------------------
FOUND 9 ERRORS AFFECTING 9 LINES
-------------------------------------------------------------------------
  1 | ERROR | [x] Header blocks must be separated by a single blank line
  5 | ERROR | [x] Header blocks must be separated by a single blank line
 22 | ERROR | [x] Whitespace found at end of line
 40 | ERROR | [x] Inline control structures are not allowed
 57 | ERROR | [x] Whitespace found at end of line
 64 | ERROR | [x] Inline control structures are not allowed
 65 | ERROR | [x] Inline control structures are not allowed
 66 | ERROR | [x] Inline control structures are not allowed
 69 | ERROR | [x] Expected 1 blank line at end of file; 2 found
-------------------------------------------------------------------------
PHPCBF CAN FIX THE 9 MARKED SNIFF VIOLATIONS AUTOMATICALLY
-------------------------------------------------------------------------

> ./vendor/bin/phpcbf --standard=PSR12 ./src

PHPCBF RESULT SUMMARY
----------------------------------------------------------------------
FILE                                                  FIXED  REMAINING
----------------------------------------------------------------------
/data/src/IAreaDecoder.php                            2      0
/data/src/Area.php                                    6      0
/data/src/TencentGeoService.php                       10     0
/data/src/IService.php                                3      0
/data/src/IpCoder.php                                 5      0
/data/src/GeoCoder.php                                9      0
----------------------------------------------------------------------
A TOTAL OF 35 ERRORS WERE FIXED IN 6 FILES
----------------------------------------------------------------------

Time: 559ms; Memory: 12MB

> vendor/bin/phpunit 

PHPUnit 9.5.14 by Sebastian Bergmann and contributors.

Runtime:       PHP 7.4.27 with PCOV 1.0.9
Configuration: /data/phpunit.xml

..........                                                        10 / 10 (100%)

Time: 00:00.015, Memory: 8.00 MB

OK (10 tests, 46 assertions)

Generating code coverage report in HTML format ... done [00:00.020]

```

## Features
### 根据经纬度查询地理位置信息
```php
include "./vendor/autoload.php";

use Fu\Geo\GeoCoder;
use Fu\Geo\TencentGeoService;

const KEY = "YOUR-TENCENT-GEO-SERVICE-KEY";

$latitude  = 29.60001;
$longitude = 91.00001;

$service = new TencentGeoService(KEY);
$coder = new GeoCoder($latitude, $longitude);
$area = $coder->getArea($service);

$area->nation; // 中国
$area->lv1;    // 西藏自治区
$area->lv2;    // 拉萨市
$area->lv3;    // 堆龙德庆区
```

### 根据IP地址查询地理位置信息
```php
include "./vendor/autoload.php";

use Fu\Geo\IpCoder;
use Fu\Geo\TencentGeoService;

const KEY = "YOUR-TENCENT-GEO-SERVICE-KEY";

$ip = '171.221.208.34';

$service = new TencentGeoService(KEY);
$coder = new IpCoder($ip);
$area = $coder->getArea($service);

$area->nation; // 中国
$area->lv1;    // 四川省
$area->lv2;    // 成都市
$area->lv3;    // 温江区
```

## Links

* 腾讯地理位置服务：https://lbs.qq.com

## Licensing

The code in this project is licensed under MIT license.