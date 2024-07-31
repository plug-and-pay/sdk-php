<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Tests\Feature\Rule;

use PHPUnit\Framework\TestCase;
use PlugAndPay\Sdk\Entity\Rule;
use PlugAndPay\Sdk\Service\RuleService;
use PlugAndPay\Sdk\Tests\Feature\Rule\Mock\UpdateRuleMockClient;

class UpdateRuleTest extends TestCase
{
    /** @test */
    public function update_basic_Rule(): void
    {
        $client  = new UpdateRuleMockClient();
        $service = new RuleService($client);

        $rule = $service->update(1, function (Rule $rule) {
            $rule->setName('Testing Rule Updated');
        });

        static::assertEquals('Testing Rule Updated', $rule->name());
        static::assertEquals('/v2/rules/1', $client->path());
    }
}
