<?php

namespace Fu\Geo\Service\Address;

use Fu\Geo\LocationResponsable;
use Fu\Geo\Service\ServiceResponse;

/**
 *
 */
class LocationResponse extends ServiceResponse implements LocationResponsable
{
    /**
     * @var string
     */
    public string $locationName;

    /**
     * @param array $json
     * @return void
     */
    public function setLocationName(array $json)
    {
        $this->locationName = $this->trim(
            $json['results'][0]['address_components'][0]['long_name']
                ?? $json['results'][0]['formatted_address']
        );
    }

    /**
     * @return string
     */
    public function getLocationName(): string
    {
        return $this->locationName;
    }

    /**
     * @param string|null $name
     * @return string
     */
    protected function trim(?string $name): string
    {
        if (!$name) {
            return "";
        }
        $replace = ['County', 'Township', 'City', 'District'];
        $names = explode(' ', explode(',', $name)[0]);
        return implode(
            ' ',
            array_filter($names, function ($val) use ($replace) {
                return !in_array($val, $replace);
            })
        );
    }
}
