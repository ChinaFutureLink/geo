<?php

use Fu\Geo\Data\Tencent\Service as TencentService;

require 'vendor/autoload.php';

$tencent = new TencentService();
$array = $tencent->toArray();
//var_dump($array);
exit;


//$regional = new Regional();
//$china = $regional->getChina();
//foreach ($china->getChildren() as $province) {
//    $id = $provinces->find($province);
//    if ($id) {
//        $province->setId($id);
//    } else {
//        var_dump('missing ... ' . $province->getValue());
//    }
//    foreach ($province->getChildren()??[] as $city) {
//        $id = $cities->find($city);
//        if ($id) {
//            $city->setId($id);
//        } else {
//            var_dump('missing ... ' . $city->getValue());
//        }
//        foreach ($city->getChildren()??[] as $region) {
//            $id = $regions->find($region);
//            if ($id) {
//                $region->setId($id);
//            } else {
//                var_dump('missing ... ' . $region->getValue());
//                $region->remove();
//            }
//        }
//    }
//}
//$array = $china->toArray();
//var_dump($array);



//curl -L -X GET 'https://maps.googleapis.com/maps/api/place/findplacefromtext/json?input=Museum%20of%20Contemporary%20Art%20Australia&inputtype=textquery&fields=formatted_address%2Cname%2Crating%2Copening_hours%2Cgeometry&key=YOUR_API_KEY'