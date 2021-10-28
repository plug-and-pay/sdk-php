<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Service;

use PlugAndPay\Sdk\Contract\ClientGetInterface;
use PlugAndPay\Sdk\Director\BodyTo\BodyToOrder;
use PlugAndPay\Sdk\Entity\Order;
use PlugAndPay\Sdk\Entity\Response;
use PlugAndPay\Sdk\Exception\NotFoundException;

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
        $parameters = 'include=' . implode(',', $this->includes);
        $response   = $this->client->get("/orders/$id?$parameters");
        if ($response->status() === Response::HTTP_NOT_FOUND) {
            throw new NotFoundException('Order', $id);
        }
        return BodyToOrder::build($response->body());
    }

    /**
     * @return Order[]
     */
    public function get(): array
    {
        $response = $this->client->get('/orders');
        return BodyToOrder::buildMulti($response->body());
    }

    public function include(string...$includes): self
    {
        $this->includes = $includes;

        return $this;
    }
}
