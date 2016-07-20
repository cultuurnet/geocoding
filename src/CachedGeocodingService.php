<?php

namespace CultuurNet\Geocoding;

use CultuurNet\Geocoding\Coordinate\Coordinates;
use CultuurNet\Geocoding\Coordinate\Latitude;
use CultuurNet\Geocoding\Coordinate\Longitude;
use Doctrine\Common\Cache\Cache;

class CachedGeocodingService implements GeocodingServiceInterface
{
    /**
     * @var GeocodingServiceInterface
     */
    private $geocodingService;

    /**
     * @var Cache
     */
    private $cache;

    /**
     * @param GeocodingServiceInterface $geocodingService
     * @param Cache $cache
     */
    public function __construct(GeocodingServiceInterface $geocodingService, Cache $cache)
    {
        $this->geocodingService = $geocodingService;
        $this->cache = $cache;
    }

    /**
     * @param string $address
     * @return Coordinates
     */
    public function getCoordinates($address)
    {
        $encodedCacheData = $this->cache->fetch($address);

        if ($encodedCacheData) {
            $cacheData = json_decode($encodedCacheData, true);

            if (isset($cacheData['lat']) && isset($cacheData['long'])) {
                return new Coordinates(
                    new Latitude((double) $cacheData['lat']),
                    new Longitude((double) $cacheData['long'])
                );
            }
        }

        $coordinates = $this->geocodingService->getCoordinates($address);

        $encodedCacheData = json_encode(
            [
                'lat' => $coordinates->getLatitude()->toDouble(),
                'long' => $coordinates->getLongitude()->toDouble(),
            ]
        );

        $this->cache->save($address, $encodedCacheData);

        return $coordinates;
    }
}
