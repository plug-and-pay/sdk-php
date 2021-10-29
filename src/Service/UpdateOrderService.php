<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Service;

use PlugAndPay\Sdk\Contract\ClientPatchInterface;
use PlugAndPay\Sdk\Director\BodyTo\BodyToOrder;
use PlugAndPay\Sdk\Director\ToBody\OrderToBody;
use PlugAndPay\Sdk\Entity\Order;
use PlugAndPay\Sdk\Exception\ExceptionFactory;

class UpdateOrderService
{
    private ClientPatchInterface $client;

    public function __construct(ClientPatchInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @throws \PlugAndPay\Sdk\Exception\RelationNotLoadedException
     */
    public function update(int $orderId, callable $update): Order
    {
        $order = new Order();
        $update($order);
        $body      = OrderToBody::build($order);
        $response  = $this->client->patch("/orders/$orderId", $body);
        $exception = ExceptionFactory::createByResponse($response);
        if ($exception) {
            throw $exception;
        }
        return BodyToOrder::build($response->body());
    }
}
