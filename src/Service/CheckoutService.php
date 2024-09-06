<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Service;

use Exception;
use PlugAndPay\Sdk\Contract\ClientInterface;
use PlugAndPay\Sdk\Director\BodyTo\BodyToCheckout;
use PlugAndPay\Sdk\Entity\Checkout;
use PlugAndPay\Sdk\Enum\CheckoutIncludes;
use PlugAndPay\Sdk\Exception\DecodeResponseException;
use PlugAndPay\Sdk\Filters\CheckoutFilter;
use PlugAndPay\Sdk\Support\Parameters;

class CheckoutService
{
    private ClientInterface $client;
    /** @var string[] */
    private array $includes = [];

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function include(CheckoutIncludes ...$includes): self
    {
        $this->includes = $includes;

        return $this;
    }

    /** @throws DecodeResponseException */
    public function find(int $id): Checkout
    {
        $query    = Parameters::toString(['include' => $this->includes]);
        $response = $this->client->get("/v2/checkouts/$id$query");

        return BodyToCheckout::build($response->body()['data']);
    }

    /**
     * @return Checkout[]
     * @throws DecodeResponseException
     * @throws Exception
     */
    public function get(CheckoutFilter $checkoutFilter = null): array
    {
        $parameters = $checkoutFilter ? $checkoutFilter->parameters() : [];
        if (!empty($this->includes)) {
            $parameters['include'] = $this->includes;
        }
        $query = Parameters::toString($parameters);

        $response = $this->client->get("/v2/checkouts$query");

        return BodyToCheckout::buildMulti($response->body()['data']);
    }
}
