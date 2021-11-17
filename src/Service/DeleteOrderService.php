<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Service;

use PlugAndPay\Sdk\Contract\ClientDeleteInterface;

class DeleteOrderService
{
    private ClientDeleteInterface $client;

    public function __construct(ClientDeleteInterface $client)
    {
        $this->client = $client;
    }

    public function delete(int $orderId): void
    {
        $this->client->delete("/v2/orders/$orderId");
    }
}
