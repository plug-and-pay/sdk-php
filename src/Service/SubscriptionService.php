<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Service;

use PlugAndPay\Sdk\Contract\ClientInterface;
use PlugAndPay\Sdk\Contract\ClientPatchInterface;
use PlugAndPay\Sdk\Director\BodyTo\BodyToSubscription;
use PlugAndPay\Sdk\Entity\Subscription;
use PlugAndPay\Sdk\Enum\SubscriptionIncludes;
use PlugAndPay\Sdk\Support\Parameters;

class SubscriptionService
{
    private ClientPatchInterface $client;
    /** @var string[] */
    private array $includes = [];

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function include(SubscriptionIncludes ...$includes): self
    {
        $this->includes = $includes;
        return $this;
    }

    /**
     * @throws \PlugAndPay\Sdk\Exception\DecodeResponseException
     */
    public function find(int $id): Subscription
    {
        $query    = Parameters::toString(['include' => $this->includes]);
        $response = $this->client->get("/v2/subscriptions/$id$query");

        return BodyToSubscription::build($response->body()['data']);
    }
}
