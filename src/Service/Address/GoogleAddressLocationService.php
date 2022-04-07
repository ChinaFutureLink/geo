<?php

namespace Fu\Geo\Service\Address;

use Fu\Geo\LocationResponsable;
use Fu\Geo\Service\GoogleLocationService;

/**
 * Google地理位置服务
 */
class GoogleAddressLocationService extends GoogleLocationService implements AddressLocationService
{
    /**
     * 根据地名查询所在地信息
     * @example ./data/google.geocode.address.json
     * @param string $address
     * @return LocationResponsable
     */
    public function getLocation(string $address): LocationResponsable
    {
        $response = new LocationResponse();
        $res = $this->getClient()->get(
            sprintf("maps/api/geocode/json?address=%s&key=%s", $address, $this->key)
        );
        if ($res->getStatusCode() != 200) {
            $response->message = $res->getReasonPhrase();
            return $response;
        }
        $response->raw = (string) $res->getBody();
        $json = json_decode($response->raw, true);
        if (json_last_error()) {
            $response->message = json_last_error_msg();
            return $response;
        }
        $response->setLocationName($json);
        $response->ok = true;
        return $response;
    }
}
