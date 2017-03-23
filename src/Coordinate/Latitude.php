<?php

namespace CultuurNet\Geocoding\Coordinate;

class Latitude extends Coordinate
{
    public function __construct($value)
    {
        parent::__construct($value);

        if ($value < -180 || $value > 180) {
            throw new \InvalidArgumentException('Latitude should be between -180 and 180.');
        }
    }
}
