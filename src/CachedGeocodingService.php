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
     * @inheritdoc
     */
    public function getCoordinates($address)
    {
        $encodedCacheData = $this->cache->fetch($address);

        if ($encodedCacheData) {
            $cacheData = json_decode($encodedCacheData, true);

            // Some addresses have no coordinates, to cache these addresses 'NO_COORDINATES_FOUND' is used as value.
            // When the 'NO_COORDINATES_FOUND' cached value is found null is returned as coordinate.
            if ('NO_COORDINATES_FOUND' === $cacheData) {
                return null;
            }

            if (isset($cacheData['lat']) && isset($cacheData['long'])) {
                return new Coordinates(
                    new Latitude((double) $cacheData['lat']),
                    new Longitude((double) $cacheData['long'])
                );
            }
        }

        $coordinates = $this->geocodingService->getCoordinates($address);

        // Some addresses have no coordinates, to cache these addresses 'NO_COORDINATES_FOUND' is used as value.
        // When null is passed in as the coordinates, then 'NO_COORDINATES_FOUND' is stored as cache value.
        $encodedCacheData = json_encode('NO_COORDINATES_FOUND');
        if ($coordinates) {
            $encodedCacheData = json_encode(
                [
                    'lat' => $coordinates->getLatitude()->toDouble(),
                    'long' => $coordinates->getLongitude()->toDouble(),
                ]
            );
        }

        $this->cache->save($address, $encodedCacheData);

        return $coordinates;
    }
}
