<?php

namespace Cardflow\Client;

use Cardflow\Client\Exceptions\ApiException;
use Cardflow\Client\Factories\ServiceFactory;
use Cardflow\Client\HttpClient\CardflowHttpClient;
use Cardflow\Client\HttpClient\CardflowHttpClientInterface;
use Cardflow\Client\Services\GiftCardService;
use Cardflow\Client\Services\LocationService;

/**
 * Class CardflowClient
 * @package Cardflow\Client
 * @property GiftCardService $giftCards
 * @property LocationService $locations
 */
final class CardflowClient
{
    public const VERSION = '1.0.0';
    private const USER_AGENT_FORMAT = 'Cardflow/Cardflow-PHP/%s/PHP/%s/%s';

    /**
     * @var string
     */
    //private $apiEndpoint = 'http://api.cardhub.nl/api/v1/';
    private $apiEndpoint = 'http://api.cardhub.mv-ict.nl/api/v1/';

    /**
     * @var CardflowHttpClientInterface
     */
    private $httpClient;

    /**
     * @var ServiceFactory
     */
    private $serviceFactory;

    /**
     * CardflowClient constructor.
     * @param string $apiKey
     * @param array<string, string> $options
     * @param CardflowHttpClientInterface|null $httpClient
     */
    public function __construct(string $apiKey, $options = [], ?CardflowHttpClientInterface $httpClient = null)
    {
        if (isset($options['api_endpoint'])) {
            $this->setApiEndpoint($options['api_endpoint']);
        }

        $this->setHttpClient($httpClient);
        $this->httpClient->setAccessToken($apiKey);
    }

    /**
     * @param string $name
     *
     * @return mixed|null
     */
    public function __get(string $name)
    {
        if (null === $this->serviceFactory) {
            $this->serviceFactory = new ServiceFactory($this->httpClient);
        }

        return $this->serviceFactory->__get($name);
    }

    public function validateApiKey(): bool
    {
        try {
            $this->locations->all();
        } catch (ApiException $e) {
            return false;
        }

        return true;
    }

    /**
     * Set the HTTP client to our default (Curl) or use the user
     * specified client. This is useful for testing so we can use
     * the Guzzle Mock client.
     * @param CardflowHttpClientInterface|null $httpClient
     * @return CardflowClient
     */
    private function setHttpClient(?CardflowHttpClientInterface $httpClient = null): self
    {
        if ($httpClient !== null) {
            $this->httpClient = $httpClient;

            return $this;
        }

        $this->httpClient = new CardflowHttpClient(
            $this->apiEndpoint,
            10,
            2,
            [
                'User-Agent' => $this->getUserAgent(CardflowHttpClient::getClientName()),
                'Accept' => 'application/json',
            ]
        );

        return $this;
    }

    private function setApiEndpoint(string $endpoint): self
    {
        $this->apiEndpoint = $endpoint;

        return $this;
    }

    private function getUserAgent(string $httpClientName): string
    {
        return sprintf(
            self::USER_AGENT_FORMAT,
            self::VERSION,
            phpversion(),
            $httpClientName
        );
    }
}
