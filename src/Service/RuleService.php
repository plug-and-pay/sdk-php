<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Service;

use PlugAndPay\Sdk\Contract\ClientInterface;
use PlugAndPay\Sdk\Director\BodyTo\BodyToRule;
use PlugAndPay\Sdk\Director\ToBody\RuleToBody;
use PlugAndPay\Sdk\Entity\Rule;
use PlugAndPay\Sdk\Filters\RuleFilter;
use PlugAndPay\Sdk\Support\Parameters;

class RuleService
{
    private ClientInterface $client;

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

    public function deleteMany(array $ruleIds): void
    {
        $this->client->deleteMany('/v2/rules', ['ids' => $ruleIds]);
    }

    public function create(Rule $rule): Rule
    {
        $body     = RuleToBody::build($rule);
        $response = $this->client->post('/v2/rules', $body);

        return BodyToRule::build($response->body()['data']);
    }

    public function update(int $ruleId, callable $update): Rule
    {
        $rule = new Rule();
        $update($rule);
        $body     = RuleToBody::build($rule);
        $response = $this->client->patch("/v2/rules/$ruleId", $body);

        return BodyToRule::build($response->body()['data']);
    }
}
