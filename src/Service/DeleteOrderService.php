<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Service;

use PlugAndPay\Sdk\Contract\ClientDeleteInterface;
use PlugAndPay\Sdk\Exception\ExceptionFactory;

class DeleteOrderService
{
    private ClientDeleteInterface $client;

    public function __construct(ClientDeleteInterface $client)
    {
        $this->client = $client;
    }

    public function delete(int $orderId): void
    {
        $response  = $this->client->delete("/v2/orders/$orderId");
        $exception = ExceptionFactory::createByResponse($response);
        if ($exception) {
            throw $exception;
        }
    }
}
