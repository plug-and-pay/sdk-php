<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Service;

use PlugAndPay\Sdk\Contract\ClientInterface;
use PlugAndPay\Sdk\Contract\ClientPatchInterface;
use PlugAndPay\Sdk\Director\BodyTo\BodyToSubscription;
use PlugAndPay\Sdk\Director\ToBody\SubscriptionToBody;
use PlugAndPay\Sdk\Entity\Subscription;
use PlugAndPay\Sdk\Enum\SubscriptionIncludes;
use PlugAndPay\Sdk\Exception\DecodeResponseException;
use PlugAndPay\Sdk\Exception\RelationNotLoadedException;
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
     * @throws DecodeResponseException
     */
    public function find(int $id): Subscription
    {
        $query    = Parameters::toString(['include' => $this->includes]);
        $response = $this->client->get("/v2/subscriptions/$id$query");

        return BodyToSubscription::build($response->body()['data']);
    }

    /**
     * @return Subscription[]
     * @throws DecodeResponseException
     */
    public function get($subscriptionFilter = null): array
    {
        $parameters = $subscriptionFilter ? $subscriptionFilter->parameters() : [];
        if (!empty($this->includes)) {
            $parameters['include'] = $this->includes;
        }
        $query = Parameters::toString($parameters);

        $response = $this->client->get("/v2/subscriptions$query");

        return BodyToSubscription::buildMulti($response->body()['data']);
    }

    /**
     * @throws DecodeResponseException
     * @throws RelationNotLoadedException
     */
    public function create(Subscription $subscription): Subscription
    {
        $body     = SubscriptionToBody::build($subscription);
        $query    = Parameters::toString(['include' => $this->includes]);
        $response = $this->client->post("/v2/subscriptions$query", $body);

        return BodyToSubscription::build($response->body()['data']);
    }

    public function delete(int $subscriptionId): void
    {
        $this->client->delete("/v2/subscriptions/$subscriptionId");
    }
}
