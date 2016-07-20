<?php

namespace CultuurNet\Geocoding;

use CultuurNet\Geocoding\Coordinate\Coordinates;
use CultuurNet\Geocoding\Coordinate\Latitude;
use CultuurNet\Geocoding\Coordinate\Longitude;
use Doctrine\Common\Cache\ArrayCache;

class CachedGeocodingServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ArrayCache
     */
    private $cache;

    /**
     * @var GeocodingServiceInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $decoratee;

    /**
     * @var CachedGeocodingService
     */
    private $service;

    public function setUp()
    {
        $this->cache = new ArrayCache();
        $this->decoratee = $this->getMock(GeocodingServiceInterface::class);
        $this->service = new CachedGeocodingService($this->decoratee, $this->cache);
    }

    /**
     * @test
     */
    public function it_returns_cached_coordinates_if_possible()
    {
        $address = 'Wetstraat 1, 1000 Brussel, BE';

        $expectedCoordinates = new Coordinates(
            new Latitude(1.07845),
            new Longitude(2.76412)
        );

        $this->decoratee->expects($this->once())
            ->method('getCoordinates')
            ->with($address)
            ->willReturn($expectedCoordinates);

        $freshCoordinates = $this->service->getCoordinates($address);
        $cachedCoordinates = $this->service->getCoordinates($address);

        $this->assertEquals($expectedCoordinates, $freshCoordinates);
        $this->assertEquals($expectedCoordinates, $cachedCoordinates);
    }
}
