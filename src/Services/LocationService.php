<?php

namespace Cardflow\Client\Services;

use Cardflow\Client\Resources\Collection;
use Cardflow\Client\Resources\Location;
use Cardflow\Client\Services\Operation\All;

/**
 * Class LocationService
 * @package Cardflow\Client\Service
 * @method Location[]|Collection all(array $options = [])
 */
final class LocationService extends AbstractService
{
    use All;

    protected const API_PATH = 'locations';

    protected function getResourceClassPath(): string
    {
        return Location::class;
    }
}
