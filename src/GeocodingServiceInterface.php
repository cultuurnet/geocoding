<?php

namespace CultuurNet\Geocoding;

interface GeocodingServiceInterface
{
    /**
     * @param $address
     * @return Coordinates
     */
    public function getCoordinates($address);
}
