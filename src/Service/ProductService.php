<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Service;

use PlugAndPay\Sdk\Contract\ClientInterface;
use PlugAndPay\Sdk\Contract\ClientPatchInterface;
use PlugAndPay\Sdk\Director\BodyTo\BodyToProduct;
use PlugAndPay\Sdk\Entity\Product;
use PlugAndPay\Sdk\Enum\OrderIncludes;

class ProductService
{
    private ClientPatchInterface $client;
    /** @var string[] */
    private array $includes = [];

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function include(OrderIncludes...$includes): self
    {
        $this->includes = $includes;

        return $this;
    }

    /**
     * @throws \PlugAndPay\Sdk\Exception\DecodeResponseException
     */
    public function find(int $id): Product
    {
//        $query    = Parameters::toString(['include' => $this->includes]);
//        $response = $this->client->get("/v2/products/$id$query");
        $response = $this->client->get("/v2/products/$id");
        return BodyToProduct::build($response->body()['data']);
    }
}
