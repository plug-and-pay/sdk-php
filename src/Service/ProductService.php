<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Service;

use PlugAndPay\Sdk\Contract\ClientInterface;
use PlugAndPay\Sdk\Contract\ClientPatchInterface;
use PlugAndPay\Sdk\Director\BodyTo\BodyToProduct;
use PlugAndPay\Sdk\Director\ToBody\ProductToBody;
use PlugAndPay\Sdk\Entity\Product;
use PlugAndPay\Sdk\Enum\ProductIncludes;
use PlugAndPay\Sdk\Filters\ProductFilter;
use PlugAndPay\Sdk\Support\Parameters;

class ProductService
{
    private ClientPatchInterface $client;
    /** @var string[] */
    private array $includes = [];

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function create(Product $product): Product
    {
        $body     = ProductToBody::build($product);
        $query    = Parameters::toString(['include' => $this->includes]);
        $response = $this->client->post("/v2/products$query", $body);

        return BodyToProduct::build($response->body()['data']);
    }

    public function include(ProductIncludes ...$includes): self
    {
        $this->includes = $includes;

        return $this;
    }

    /**
     * @throws \PlugAndPay\Sdk\Exception\DecodeResponseException
     * @return Product[]
     */
    public function get(ProductFilter $productFilter = null): array
    {
        $parameters = $productFilter ? $productFilter->parameters() : [];
        if (!empty($this->includes)) {
            $parameters['include'] = $this->includes;
        }
        $query = Parameters::toString($parameters);

        $response = $this->client->get("/v2/products$query");

        return BodyToProduct::buildMulti($response->body()['data']);
    }

    /**
     * @throws \PlugAndPay\Sdk\Exception\DecodeResponseException
     */
    public function find(int $id): Product
    {
        $query    = Parameters::toString(['include' => $this->includes]);
        $response = $this->client->get("/v2/products/$id$query");
        return BodyToProduct::build($response->body()['data']);
    }

    /**
     * @throws \PlugAndPay\Sdk\Exception\DecodeResponseException
     * @throws \PlugAndPay\Sdk\Exception\RelationNotLoadedException
     */
    public function update(int $productId, callable $update): Product
    {
        $product = new Product(true);
        $update($product);
        $body     = ProductToBody::build($product);
        $query    = Parameters::toString(['include' => $this->includes]);
        $response = $this->client->patch("/v2/products/$productId$query", $body);

        return BodyToProduct::build($response->body()['data']);
    }

    public function delete(int $productId): void
    {
        $this->client->delete("/v2/products/$productId");
    }
}
