<?php

namespace CultuurNet\Geocoding;

use CultuurNet\Geocoding\Coordinate\Coordinates;
use CultuurNet\Geocoding\Coordinate\Latitude;
use CultuurNet\Geocoding\Coordinate\Longitude;
use Geocoder\GeocoderInterface;

class DefaultGeocodingService implements GeocodingServiceInterface
{
    /**
     * @var GeocoderInterface
     */
    private $geocoder;

    /**
     * @param GeocoderInterface $geocoder
     */
    public function __construct(GeocoderInterface $geocoder)
    {
        $this->geocoder = $geocoder;
    }

    /**
     * @param string $address
     * @return Coordinates
     */
    public function getCoordinates($address)
    {
        $result = $this->geocoder->geocode($address);
        $coordinates = $result->getCoordinates();

        return new Coordinates(
            new Latitude((double) $coordinates[0]),
            new Longitude((double) $coordinates[1])
        );
    }
}
