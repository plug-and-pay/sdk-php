<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Service;

use PlugAndPay\Sdk\Contract\ClientInterface;
use PlugAndPay\Sdk\Contract\ClientPatchInterface;
use PlugAndPay\Sdk\Director\BodyTo\BodyToRule;
use PlugAndPay\Sdk\Entity\Rule;
use PlugAndPay\Sdk\Filters\RuleFilter;
use PlugAndPay\Sdk\Support\Parameters;

class RuleService
{
    private ClientPatchInterface $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function find(int $id): Rule
    {
        $response = $this->client->get("/v2/rules/$id");

        return BodyToRule::build($response->body()['data']);
    }

    public function get(RuleFilter $ruleFilter = null): array
    {
        $ruleFilter = $ruleFilter ?? new RuleFilter();
        $query      = Parameters::toString($ruleFilter->parameters());

        $response = $this->client->get("/v2/rules$query");

        return BodyToRule::buildMulti($response->body()['data']);
    }

    public function delete(int $ruleId): void
    {
        $this->client->delete("/v2/rules/$ruleId");
    }
}
