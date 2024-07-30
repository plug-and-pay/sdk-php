<?php

/** @noinspection EfferentObjectCouplingInspection */
/* @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

namespace PlugAndPay\Sdk\Tests\Feature\Rule;

use BadFunctionCallException;
use PHPUnit\Framework\TestCase;
use PlugAndPay\Sdk\Director\ToBody\RuleToBody;
use PlugAndPay\Sdk\Entity\Rule;
use PlugAndPay\Sdk\Service\RuleService;
use PlugAndPay\Sdk\Tests\Feature\Rule\Mock\RuleStoreMockClient;

class StoreRuleTest extends TestCase
{
    /** @test */
    public function bad_function_call(): void
    {
        $exception = null;

        try {
            $rule = new Rule();
            $rule->isset('bad_function');
        } catch (BadFunctionCallException $exception) {
        }

        static::assertInstanceOf(BadFunctionCallException::class, $exception);
    }

    /** @test */
    public function convert_basic_rule(): void
    {
        $rule = $this->makeBasicRule();

        $body = RuleToBody::build($rule);

        static::assertSame('call_webhook', $body['action_type']);
        static::assertSame(['url' => 'https://example.com/webhook'], $body['action_data']);
        static::assertSame('order_created', $body['trigger_type']);
        static::assertSame(['product_id' => [1]], $body['condition_data']);
        static::assertSame('Plug&Pay example rule', $body['name']);
        static::assertSame('webhook', $body['driver']);
    }

    /** @test */
    public function store_basic_rule(): void
    {
        $client  = new RuleStoreMockClient();
        $service = new RuleService($client);

        $rule = $this->makeBasicRule();
        $rule = $service->create($rule);

        static::assertEquals('/v2/rules', $client->path());
        static::assertEquals(1, $rule->id());
        static::assertEquals('call_webhook', $client->requestBody()['action_type']);
    }

    private function makeBasicRule(): Rule
    {
        return (new Rule)
            ->setActionType('call_webhook')
            ->setActionData(['url' => 'https://example.com/webhook'])
            ->setTriggerType('order_created')
            ->setConditionData(['product_id' => [1]])
            ->setName('Plug&Pay example rule')
            ->setDriver('webhook');
    }
}
