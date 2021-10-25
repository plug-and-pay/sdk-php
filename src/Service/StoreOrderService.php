<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Service;

use PlugAndPay\Sdk\Contract\ClientPostInterface;
use PlugAndPay\Sdk\Director\OrderToBody;
use PlugAndPay\Sdk\Director\ResponseToOrder;
use PlugAndPay\Sdk\Entity\Order;

class StoreOrderService
{
    private ClientPostInterface $client;

    public function __construct(ClientPostInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @throws \PlugAndPay\Sdk\Exception\RelationNotLoadedException
     */
    public function post(Order $order): Order
    {
        $body     = (new OrderToBody())->build($order);
        $response = $this->client->post('/orders', $body);
        return (new ResponseToOrder())->build($response->body());
    }
}
