<?php

namespace Cardflow\Client\Resources;

use Cardflow\Client\Exceptions\MissingParameterException;
use Cardflow\Client\HttpClient\CardflowHttpClientInterface;

abstract class AbstractResource
{
    /**
     * @var string
     */
    protected $apiIdentifierField = 'id';

    /**
     * Associative array for storing property values
     *
     * @var mixed[]
     */
    protected $container = [];

    /**
     * @var CardflowHttpClientInterface
     */
    protected $httpClient;

    /**
     * AbstractResource constructor.
     * @param CardflowHttpClientInterface $httpClient
     * @param array<string|int|bool> $data
     * @throws MissingParameterException
     */
    public function __construct(CardflowHttpClientInterface $httpClient, array $data = [])
    {
        if (isset($data[$this->apiIdentifierField]) === false) {
            throw new MissingParameterException(
                sprintf('The \'%s\' parameter is required.', $this->apiIdentifierField)
            );
        }

        $this->httpClient = $httpClient;
    }

    public function getApiIdentifier(): string
    {
        return $this->container[$this->apiIdentifierField];
    }
}
