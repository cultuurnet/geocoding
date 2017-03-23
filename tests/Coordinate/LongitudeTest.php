<?php

namespace CultuurNet\Geocoding\Coordinate;

class LongitudeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_does_not_accept_a_double_under_negative_90()
    {
        $this->expectException(\InvalidArgumentException::class);
        new Longitude(-90.1);
    }

    /**
     * @test
     */
    public function it_does_not_accept_a_double_over_90()
    {
        $this->expectException(\InvalidArgumentException::class);
        new Longitude(90.1);
    }

    /**
     * @test
     */
    public function it_accepts_any_doubles_between_negative_90_and_90()
    {
        new Longitude(-90.0);
        new Longitude(-5.123456789);
        new Longitude(-0.25);
        new Longitude(0.0);
        new Longitude(0.25);
        new Longitude(5.123456789);
        new Longitude(90.0);
    }
}
