<?php

namespace CultuurNet\Geocoding;

use CultuurNet\Geocoding\Coordinate\Coordinates;
use CultuurNet\Geocoding\Coordinate\Latitude;
use CultuurNet\Geocoding\Coordinate\Longitude;
use Geocoder\Exception\NoResultException;
use Geocoder\GeocoderInterface;
use Geocoder\Result\Geocoded;
use Psr\Log\LoggerInterface;

class DefaultGeocodingServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var GeocoderInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $geocoder;

    /**
     * @var LoggerInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $logger;

    /**
     * @var DefaultGeocodingService
     */
    private $service;

    public function setUp()
    {
        $this->geocoder = $this->createMock(GeocoderInterface::class);
        $this->logger = $this->createMock(LoggerInterface::class);

        $this->service = new DefaultGeocodingService($this->geocoder, $this->logger);
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

    /**
     * @test
     */
    public function it_returns_null_on_no_result_exception_from_geocoder()
    {
        $address = 'Eikelberg (achter de bibliotheek), 8340 Sijsele (Damme), BE';

        $this->geocoder->expects($this->once())
            ->method('geocode')
            ->with($address)
            ->willThrowException(
                new NoResultException('Could not execute query')
            );

        $this->logger->expects($this->once())
            ->method('error')
            ->with('No results for address: "'. $address . '". Exception message: Could not execute query');

        $actualCoordinates = $this->service->getCoordinates($address);

        $this->assertNull($actualCoordinates);
    }
}
