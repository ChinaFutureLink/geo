<?php

use Fu\Geo\Data\Tencent\District as TencentService;

require 'vendor/autoload.php';

$tencent = TencentService::getInstanceFromJson('./data/tencent.china.regions.json');
$array = $tencent->toArray();
var_dump($array);
$tencent->saveJsonFile('./data/tencent.china.regions.'.strftime('%Y%m%d%H%M%S').'.json');