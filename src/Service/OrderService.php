<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Service;

use PlugAndPay\Sdk\Contract\ClientInterface;
use PlugAndPay\Sdk\Director\BodyTo\BodyToOrder;
use PlugAndPay\Sdk\Director\ToBody\OrderToBody;
use PlugAndPay\Sdk\Entity\Order;
use PlugAndPay\Sdk\Enum\OrderIncludes;
use PlugAndPay\Sdk\Exception\DecodeResponseException;
use PlugAndPay\Sdk\Exception\RelationNotLoadedException;
use PlugAndPay\Sdk\Filters\OrderFilter;
use PlugAndPay\Sdk\Support\Parameters;

class OrderService
{
    private ClientInterface $client;

    /** @var string[] */
    private array $includes = [];

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function include(OrderIncludes ...$includes): self
    {
        $this->includes = $includes;

        return $this;
    }

    /**
     * @throws DecodeResponseException
     * @throws RelationNotLoadedException
     */
    public function create(Order $order): Order
    {
        $body     = OrderToBody::build($order);
        $query    = Parameters::toString(['include' => $this->includes]);
        $response = $this->client->post("/v2/orders$query", $body);

        return BodyToOrder::build($response->body()['data']);
    }

    public function delete(int $orderId): void
    {
        $this->client->delete("/v2/orders/$orderId");
    }

    /**
     * @throws DecodeResponseException
     */
    public function find(int $id): Order
    {
        $query    = Parameters::toString(['include' => $this->includes]);
        $response = $this->client->get("/v2/orders/$id$query");

        return BodyToOrder::build($response->body()['data']);
    }

    /**
     * @return Order[]
     * @throws DecodeResponseException
     */
    public function get(OrderFilter $orderFilter = null): array
    {
        $parameters = $orderFilter ? $orderFilter->parameters() : [];
        if (!empty($this->includes)) {
            $parameters['include'] = $this->includes;
        }
        $query = Parameters::toString($parameters);

        $response = $this->client->get("/v2/orders$query");

        return BodyToOrder::buildMulti($response->body()['data']);
    }

    /**
     * @throws DecodeResponseException
     * @throws RelationNotLoadedException
     */
    public function update(int $orderId, callable $update): Order
    {
        $order = new Order(true);
        $update($order);
        $body     = OrderToBody::build($order);
        $query    = Parameters::toString(['include' => $this->includes]);
        $response = $this->client->patch("/v2/orders/$orderId$query", $body);

        return BodyToOrder::build($response->body()['data']);
    }
}
