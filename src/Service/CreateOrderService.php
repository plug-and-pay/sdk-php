<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Service;

use PlugAndPay\Sdk\Contract\ClientPostInterface;
use PlugAndPay\Sdk\Director\BodyTo\BodyToOrder;
use PlugAndPay\Sdk\Director\ToBody\OrderToBody;
use PlugAndPay\Sdk\Entity\Order;
use PlugAndPay\Sdk\Support\Parameters;

class CreateOrderService
{
    private ClientPostInterface $client;
    /** @var string[] */
    private array $includes = [];

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
        $query    = Parameters::toString(['include' => $this->includes]);
        $response = $this->client->post("/v2/orders$query", $body);

        return BodyToOrder::build($response->body());
    }

    public function include(string...$includes): self
    {
        $this->includes = $includes;

        return $this;
    }
}
