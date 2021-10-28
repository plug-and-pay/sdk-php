<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Service;

use PlugAndPay\Sdk\Contract\ClientGetInterface;
use PlugAndPay\Sdk\Director\BodyTo\BodyToOrder;
use PlugAndPay\Sdk\Entity\Order;
use PlugAndPay\Sdk\Entity\Response;
use PlugAndPay\Sdk\Exception\NotFoundException;
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
     * @throws NotFoundException
     */
    public function find(int $id): Order
    {
        $query    = Parameters::toString(['include' => $this->includes]);
        $response = $this->client->get("/orders/$id?$query");
        if ($response->status() === Response::HTTP_NOT_FOUND) {
            throw new NotFoundException('Order', $id);
        }
        return BodyToOrder::build($response->body());
    }

    /**
     * @return Order[]
     */
    public function get(OrderFilter $orderFilter = null): array
    {
        $parameters = $orderFilter ? $orderFilter->parameters() : [];
        if (!empty($this->includes)) {
            $parameters['include'] = $this->includes;
        }
        $query = Parameters::toString($parameters);

        $response = $this->client->get("/orders?$query");

        return BodyToOrder::buildMulti($response->body());
    }

    public function include(string...$includes): self
    {
        $this->includes = $includes;

        return $this;
    }
}
