<?php

declare(strict_types=1);

namespace Feature\MembershipsSetting;

use PHPUnit\Framework\TestCase;
use PlugAndPay\Sdk\Entity\Response;
use PlugAndPay\Sdk\Exception\UnauthenticatedException;
use PlugAndPay\Sdk\Filters\RuleFilter;
use PlugAndPay\Sdk\Service\MembershipsSettingService;
use PlugAndPay\Sdk\Service\RuleService;
use PlugAndPay\Sdk\Tests\Feature\ClientMock;
use PlugAndPay\Sdk\Tests\Feature\MembershipsSetting\Mock\IndexMembershipsSettingMockClient;
use PlugAndPay\Sdk\Tests\Feature\Rule\Mock\IndexRulesMockClient;

class IndexMembershipsSettingTest extends TestCase
{
    /** @test */
    public function it_should_throw_unauthorized_exception_when_user_is_not_authenticated(): void
    {
        $client    = new ClientMock(Response::HTTP_UNAUTHORIZED);
        $service   = new MembershipsSettingService($client);
        $exception = null;

        try {
            $service->get();
        } catch (UnauthenticatedException $exception) {
        }

        static::assertEquals('Unable to connect with Plug&Pay. Request is unauthenticated.', $exception->getMessage());
    }

    /** @test */
    public function it_should_return_memberships_setting(): void
    {
        $client  = new IndexMembershipsSettingMockClient();
        $service = new MembershipsSettingService($client);

        $membershipsSettings = $service->get();

        static::assertSame(1, $membershipsSettings[0]->id());
        static::assertSame('huddle', $membershipsSettings[0]->driver());
        static::assertTrue($membershipsSettings[0]->isActive());
        static::assertSame(1, $membershipsSettings[0]->tenantId());
        static::assertSame('secret_token', $membershipsSettings[0]->apiToken());
        static::assertSame('2021-01-01 00:00:00', $membershipsSettings[0]->createdAt()->format('Y-m-d H:i:s'));
        static::assertNull($membershipsSettings[0]->updatedAt());
    }

    /**
     * @test
     * @dataProvider MembershipsSettingFilterDataProvider
     */
    public function it_should_filter_memberships_settings(string $method, mixed $value, string $queryKey, string $queryValue): void
    {
        $client  = new IndexRulesMockClient();
        $service = new RuleService($client);

        $filter = (new RuleFilter())->$method($value);
        $service->get($filter);

        static::assertSame("/v2/rules?$queryKey=$queryValue", $client->path());
    }

    public static function MembershipsSettingFilterDataProvider(): array
    {
        return [
            [
                'method'     => 'driver',
                'value'      => 'huddle',
                'queryKey'   => 'driver',
                'queryValue' => 'huddle',
            ],
        ];
    }
}
