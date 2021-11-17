<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Service;

use PlugAndPay\Sdk\Contract\ClientGetInterface;
use PlugAndPay\Sdk\Director\BodyTo\BodyToOrder;
use PlugAndPay\Sdk\Entity\Order;
use PlugAndPay\Sdk\Filters\OrderFilter;
use PlugAndPay\Sdk\Support\Parameters;

class FetchOrderService
{
    private ClientGetInterface $client;
    /** @var string[] */
    private array $includes = [];

    public function __construct(ClientGetInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @throws \PlugAndPay\Sdk\Exception\DecodeResponseException
     */
    public function find(int $id): Order
    {
        $query    = Parameters::toString(['include' => $this->includes]);
        $response = $this->client->get("/v2/orders/$id$query");
        return BodyToOrder::build($response->body());
    }

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

    public function include(string...$includes): self
    {
        $this->includes = $includes;

        return $this;
    }
}
