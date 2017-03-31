<?php

namespace CultuurNet\Geocoding;

use CultuurNet\Geocoding\Coordinate\Coordinates;
use CultuurNet\Geocoding\Coordinate\Latitude;
use CultuurNet\Geocoding\Coordinate\Longitude;
use Geocoder\GeocoderInterface;
use Geocoder\Result\Geocoded;

class DefaultGeocodingServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var GeocoderInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $geocoder;

    /**
     * @var DefaultGeocodingService
     */
    private $service;

    public function setUp()
    {
        $this->geocoder = $this->createMock(GeocoderInterface::class);
        $this->service = new DefaultGeocodingService($this->geocoder);
    }

    /**
     * @test
     */
    public function it_returns_coordinates()
    {
        $address = 'Wetstraat 1, 1000 Brussel, BE';

        $latFloat = 1.07845;
        $longFloat = 2.76412;

        $coordinatesArray = [
            'latitude' => $latFloat,
            'longitude' => $longFloat,
        ];

        $result = new Geocoded();
        $result->fromArray($coordinatesArray);

        $this->geocoder->expects($this->once())
            ->method('geocode')
            ->with($address)
            ->willReturn($result);

        $expectedCoordinates = new Coordinates(
            new Latitude($latFloat),
            new Longitude($longFloat)
        );

        $actualCoordinates = $this->service->getCoordinates($address);

        $this->assertEquals($expectedCoordinates, $actualCoordinates);
    }
}
