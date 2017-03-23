<?php

namespace CultuurNet\Geocoding\Coordinate;

class Longitude extends Coordinate
{
    public function __construct($value)
    {
        parent::__construct($value);

        if ($value < -90 || $value > 90) {
            throw new \InvalidArgumentException('Longitude should be between -90 and 90.');
        }
    }
}
