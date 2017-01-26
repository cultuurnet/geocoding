<?php

namespace CultuurNet\Geocoding\Coordinate;

class CoordinatesTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_can_be_compared_to_another_instance_of_coordinates()
    {
        $coordinates = new Coordinates(
            new Latitude(1.07845),
            new Longitude(2.76412)
        );

        $sameCoordinates = new Coordinates(
            new Latitude(1.07845),
            new Longitude(2.76412)
        );

        $otherCoordinates = new Coordinates(
            new Latitude(4.07845),
            new Longitude(2.76412)
        );

        $this->assertTrue($coordinates->sameAs($sameCoordinates));
        $this->assertFalse($coordinates->sameAs($otherCoordinates));
    }
}
