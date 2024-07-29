<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Tests\Feature\Rule;

use PHPUnit\Framework\TestCase;
use PlugAndPay\Sdk\Entity\Response;
use PlugAndPay\Sdk\Exception\NotFoundException;
use PlugAndPay\Sdk\Exception\UnauthenticatedException;
use PlugAndPay\Sdk\Service\RuleService;
use PlugAndPay\Sdk\Tests\Feature\ClientMock;
use PlugAndPay\Sdk\Tests\Feature\Rule\Mock\RuleShowMockClient;

class ShowRuleTest extends TestCase
{
    /** @test */
    public function show_unauthorized_rule(): void
    {
        $client    = new ClientMock(Response::HTTP_UNAUTHORIZED);
        $service   = new RuleService($client);
        $exception = null;

        try {
            $service->find(999);
        } catch (UnauthenticatedException $exception) {
        }

        static::assertEquals('Unable to connect with Plug&Pay. Request is unauthenticated.', $exception->getMessage());
    }

    /** @test */
    public function show_non_existing_rule(): void
    {
        $client    = new ClientMock(Response::HTTP_NOT_FOUND);
        $service   = new RuleService($client);
        $exception = null;

        try {
            $service->find(999);
        } catch (NotFoundException $exception) {
        }

        static::assertEquals('Not found', $exception->getMessage());
    }

    /** @test */
    public function show_rule(): void
    {
        $client  = new RuleShowMockClient(data: ['id' => 1]);
        $service = new RuleService($client);

        $rule = $service->find(1);

        static::assertSame(1, $rule->id());
        static::assertSame('call_webhook', $rule->actionType());
        static::assertSame(['hook_url' => 'https://example.com/webhook'], $rule->actionData());
        static::assertSame('order_created', $rule->triggerType());
        static::assertSame(["is_first" => true, "product_id" => [1]], $rule->conditionData());
        static::assertSame('Plug&Pay webhook rule', $rule->name());
        static::assertFalse($rule->readonly());
        static::assertSame('webhook', $rule->driver());
    }
}