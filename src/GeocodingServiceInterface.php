<?php

namespace CultuurNet\Geocoding;

use CultuurNet\Geocoding\Coordinate\Coordinates;

interface GeocodingServiceInterface
{
    /**
     * @param $address
     * @return Coordinates
     */
    public function getCoordinates($address);
}
