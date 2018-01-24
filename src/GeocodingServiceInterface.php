<?php

namespace CultuurNet\Geocoding;

use CultuurNet\Geocoding\Coordinate\Coordinates;

interface GeocodingServiceInterface
{
    /**
     * @param $address
     * @return Coordinates|null
     */
    public function getCoordinates($address);
}
