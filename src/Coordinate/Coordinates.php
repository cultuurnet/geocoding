<?php

namespace CultuurNet\Geocoding\Coordinate;

class Coordinates
{
    /**
     * @var Latitude
     */
    private $lat;

    /**
     * @var Longitude
     */
    private $long;

    /**
     * @param Latitude $lat
     * @param Longitude $long
     */
    public function __construct(Latitude $lat, Longitude $long)
    {
        $this->lat = $lat;
        $this->long = $long;
    }

    /**
     * @return Latitude
     */
    public function getLatitude()
    {
        return $this->lat;
    }

    /**
     * @return Longitude
     */
    public function getLongitude()
    {
        return $this->long;
    }

    /**
     * @param Coordinates $coordinates
     * @return bool
     */
    public function sameAs(Coordinates $coordinates)
    {
        return $coordinates->getLatitude()->sameAs($this->lat) &&
            $coordinates->getLongitude()->sameAs($this->long);
    }
}
