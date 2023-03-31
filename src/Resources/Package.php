<?php

namespace Cardflow\Client\Resources;

use Cardflow\Client\Exceptions\MissingParameterException;
use Cardflow\Client\HttpClient\CardflowHttpClientInterface;

final class Package extends AbstractResource
{
    /**
     * Package constructor.
     * @param CardflowHttpClientInterface $httpClient
     * @param array<string|int|bool> $data
     * @throws MissingParameterException
     */
    public function __construct(CardflowHttpClientInterface $httpClient, array $data = [])
    {
        parent::__construct($httpClient, $data);

        $this->container['id'] = $data['id'] ?? null;
        $this->container['title'] = $data['title'] ?? null;
        $this->container['description'] = $data['description'] ?? null;
        $this->container['amount'] = $data['amount'] ?? 0;
        $this->container['currency'] = $data['currency'] ?? null;
        $this->container['active'] = $data['active'] ?? false;
    }

    public function getId(): ?string
    {
        return $this->container['id'] ? strval($this->container['id']) : null;
    }

    public function getTitle(): ?string
    {
        return $this->container['title'] ? strval($this->container['title']) : null;
    }

    public function getDescription(): ?string
    {
        return $this->container['description'] ? strval($this->container['description']) : null;
    }

    public function getAmount(): int
    {
        return intval($this->container['amount']);
    }

    public function getCurrency(): ?string
    {
        return $this->container['currency'] ? strval($this->container['currency']) : null;
    }

    public function getActive(): bool
    {
        return boolval($this->container['active']);
    }
}
