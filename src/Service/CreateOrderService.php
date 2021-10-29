<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Service;

use PlugAndPay\Sdk\Contract\ClientPostInterface;
use PlugAndPay\Sdk\Director\BodyTo\BodyToOrder;
use PlugAndPay\Sdk\Director\ToBody\OrderToBody;
use PlugAndPay\Sdk\Entity\Order;
use PlugAndPay\Sdk\Exception\ExceptionFactory;

class CreateOrderService
{
    private ClientPostInterface $client;

    public function __construct(ClientPostInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @throws \PlugAndPay\Sdk\Exception\RelationNotLoadedException|\Exception
     */
    public function create(Order $order): Order
    {
        $body      = OrderToBody::build($order);
        $response  = $this->client->post('/orders', $body);
        $exception = ExceptionFactory::createByResponse($response);
        if ($exception) {
            throw $exception;
        }
        return BodyToOrder::build($response->body());
    }
}
