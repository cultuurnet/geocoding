<?php

namespace CultuurNet\Geocoding\Coordinate;

class Longitude extends Coordinate
{
    public function __construct($value)
    {
        parent::__construct($value);

        if ($value < -180 || $value > 180) {
            throw new \InvalidArgumentException('Longitude should be between --180 and 180.');
        }
    }
}
