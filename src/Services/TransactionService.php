<?php

namespace Cardflow\Client\Services;

use Cardflow\Client\Exceptions\ApiException;
use Cardflow\Client\Resources\Collection;
use Cardflow\Client\Resources\Transaction;
use Cardflow\Client\Services\Operation\All;
use Cardflow\Client\Services\Operation\Get;

/**
 * Class TransactionService
 * @package Cardflow\Client\Service
 * @method Transaction[]|Collection all(array $options = [])
 * @method Transaction get(string $id)
 */
final class TransactionService extends AbstractService
{
    use All;
    use Get;

    protected const API_PATH = 'transactions';

    protected function getResourceClassPath(): string
    {
        return Transaction::class;
    }

    /**
     * @param string $transactionId
     * @param array<string,string|bool|int> $options
     * @return Transaction
     * @throws ApiException
     */
    public function capture(string $transactionId, array $options = []): Transaction
    {
        $path = $this->buildApiPath([$transactionId, 'capture']);
        $response = $this->httpClient->request('POST', $path, $options);
        $resources = $this->parseApiResponse($response);

        return new Transaction($this->httpClient, (array)$resources);
    }

    /**
     * @param string $transactionId
     * @param array<string,string|bool|int> $options
     * @return Transaction
     * @throws ApiException
     */
    public function release(string $transactionId, array $options = []): Transaction
    {
        $path = $this->buildApiPath([$transactionId]);
        $response = $this->httpClient->request('DELETE', $path, $options);
        $resources = $this->parseApiResponse($response);

        return new Transaction($this->httpClient, (array)$resources);
    }
}
