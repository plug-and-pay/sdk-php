<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Tests\Feature\Rule;

use PHPUnit\Framework\TestCase;
use PlugAndPay\Sdk\Entity\Response;
use PlugAndPay\Sdk\Exception\NotFoundException;
use PlugAndPay\Sdk\Exception\UnauthenticatedException;
use PlugAndPay\Sdk\Service\RuleService;
use PlugAndPay\Sdk\Tests\Feature\Rule\Mock\DestroyRuleMockClient;

class DestroyRuleTest extends TestCase
{
    /** @test */
    public function delete_rule_not_fount_test(): void
    {
        $client    = new DestroyRuleMockClient(Response::HTTP_NOT_FOUND);
        $service   = new RuleService($client);
        $exception = null;

        try {
            $service->delete(1);
        } catch (NotFoundException $exception) {
        }

        static::assertInstanceOf(NotFoundException::class, $exception);
    }

    /** @test */
    public function delete_rule_unauthenticated(): void
    {
        $client    = new DestroyRuleMockClient(Response::HTTP_UNAUTHORIZED, []);
        $service   = new RuleService($client);
        $exception = null;

        try {
            $service->delete(1);
        } catch (UnauthenticatedException $exception) {
        }

        static::assertInstanceOf(UnauthenticatedException::class, $exception);
    }

    /** @test */
    public function delete_existing_product(): void
    {
        $client  = new DestroyRuleMockClient(Response::HTTP_NO_CONTENT, []);
        $service = new RuleService($client);

        $service->delete(1);

        static::assertEquals('/v2/rules/1', $client->path());
    }
}
