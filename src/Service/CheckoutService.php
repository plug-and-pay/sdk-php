<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Service;

use PlugAndPay\Sdk\Contract\ClientInterface;
use PlugAndPay\Sdk\Director\BodyTo\BodyToCheckout;
use PlugAndPay\Sdk\Entity\Checkout;
use PlugAndPay\Sdk\Exception\DecodeResponseException;

class CheckoutService
{
    private ClientInterface $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /** @throws DecodeResponseException */
    public function find(int $id): Checkout
    {
        $response = $this->client->get("/v2/checkouts/$id");

        return BodyToCheckout::build($response->body()['data']);
    }
}
