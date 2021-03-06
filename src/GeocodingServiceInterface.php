<?php

namespace CultuurNet\Geocoding;

use CultuurNet\Geocoding\Coordinate\Coordinates;

interface GeocodingServiceInterface
{
    /**
     * Gets the coordinates of the given address.
     * Returns null when no coordinates are found for the given address.
     * This can happen in case of a wrong/unknown address.
     *
     * @param $address
     * @return Coordinates|null
     */
    public function getCoordinates($address);
}
