<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Service;

use PlugAndPay\Sdk\Contract\ClientPatchInterface;
use PlugAndPay\Sdk\Director\BodyTo\BodyToOrder;
use PlugAndPay\Sdk\Director\ToBody\OrderToBody;
use PlugAndPay\Sdk\Entity\Order;
use PlugAndPay\Sdk\Exception\ExceptionFactory;
use PlugAndPay\Sdk\Support\Parameters;

class UpdateOrderService
{
    private ClientPatchInterface $client;
    /** @var string[] */
    private array $includes = [];

    public function __construct(ClientPatchInterface $client)
    {
        $this->client = $client;
    }

    public function include(string...$includes): self
    {
        $this->includes = $includes;

        return $this;
    }

    /**
     * @throws \PlugAndPay\Sdk\Exception\RelationNotLoadedException
     */
    public function update(int $orderId, callable $update): Order
    {
        $order = new Order(true);
        $update($order);
        $body      = OrderToBody::build($order);
        $query     = Parameters::toString(['include' => $this->includes]);
        $response  = $this->client->patch("/v2/orders/$orderId$query", $body);
        $exception = ExceptionFactory::createByResponse($response);
        if ($exception) {
            throw $exception;
        }
        return BodyToOrder::build($response->body());
    }
}
