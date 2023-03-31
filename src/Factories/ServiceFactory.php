<?php

namespace Cardflow\Client\Factories;

use Cardflow\Client\HttpClient\CardflowHttpClientInterface;
use Cardflow\Client\Services\AbstractService;
use Cardflow\Client\Services\GiftCardService;
use Cardflow\Client\Services\LocationService;
use Cardflow\Client\Services\PackageService;
use Cardflow\Client\Services\TransactionService;

final class ServiceFactory
{
    /**
     * @var CardflowHttpClientInterface
     */
    private CardflowHttpClientInterface $httpClient;

    /**
     * @var array<AbstractService>
     */
    private array $services;

    /**
     * @var array<string, class-string<AbstractService>>
     */
    protected static $classMap = [
        'giftCards'    => GiftCardService::class,
        'transactions' => TransactionService::class,
        'locations'    => LocationService::class,
        'packages'     => PackageService::class,
    ];

    /**
     * AbstractServiceFactory constructor.
     * @param CardflowHttpClientInterface $httpClient
     */
    public function __construct(CardflowHttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
        $this->services = [];
    }

    /**
     * @param string $name
     * @return AbstractService|null
     */
    public function __get(string $name): ?AbstractService
    {
        if (array_key_exists($name, self::$classMap) === false) {
            return null;
        }

        $serviceClass = self::$classMap[$name];

        if (array_key_exists($name, $this->services) === false) {
            $this->services[$name] = new $serviceClass($this->httpClient);
        }

        return $this->services[$name];
    }
}
