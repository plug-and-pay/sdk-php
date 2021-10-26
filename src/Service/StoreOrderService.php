<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Service;

use PlugAndPay\Sdk\Contract\ClientPostInterface;
use PlugAndPay\Sdk\Director\BodyToOrder;
use PlugAndPay\Sdk\Director\OrderToBody;
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
        $body     = OrderToBody::build($order);
        $response = $this->client->post('/orders', $body);
        return BodyToOrder::build($response->body());
    }
}
