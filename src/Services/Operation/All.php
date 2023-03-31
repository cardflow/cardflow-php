<?php

namespace Cardflow\Client\Services\Operation;

use Cardflow\Client\Exceptions\ApiException;
use Cardflow\Client\Resources\AbstractResource;
use Cardflow\Client\Resources\Collection;

trait All
{
    /**
     * @param array<string, int|bool|string|null> $options
     * @return Collection<AbstractResource>
     * @throws ApiException
     */
    public function all(array $options = []): Collection
    {
        $path = $this->buildApiPath();
        $response = $this->httpClient->request('GET', $path, [
            'query' => $options,
        ]);
        $resources = $this->parseApiResponse($response);
        $resourceClass = $this->getResourceClassPath();
        $collection = new Collection();

        foreach ($resources as $key => $object) {
            $collection->append(new $resourceClass($this->httpClient, (array)$object));
        }

        return $collection;
    }
}
