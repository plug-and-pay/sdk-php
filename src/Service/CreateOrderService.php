<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Service;

use PlugAndPay\Sdk\Contract\ClientPostInterface;
use PlugAndPay\Sdk\Director\BodyTo\BodyToOrder;
use PlugAndPay\Sdk\Director\ToBody\OrderToBody;
use PlugAndPay\Sdk\Entity\Order;

class CreateOrderService
{
    private ClientPostInterface $client;

    public function __construct(ClientPostInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @throws \PlugAndPay\Sdk\Exception\DecodeResponseException
     * @throws \PlugAndPay\Sdk\Exception\RelationNotLoadedException
     */
    public function create(Order $order): Order
    {
        $body     = OrderToBody::build($order);
        $response = $this->client->post('/v2/orders', $body);

        return BodyToOrder::build($response->body());
    }
}
