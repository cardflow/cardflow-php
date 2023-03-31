<?php

namespace Cardflow\Client\Services;

use Cardflow\Client\Resources\Collection;
use Cardflow\Client\Resources\Package;
use Cardflow\Client\Services\Operation\All;

/**
 * Class PackageService
 * @package Cardflow\Client\Service
 * @method Package[]|Collection all(array $options = [])
 */
final class PackageService extends AbstractService
{
    use All;

    protected const API_PATH = 'packages';

    protected function getResourceClassPath(): string
    {
        return Package::class;
    }
}
