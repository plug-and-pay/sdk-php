<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Tests\Feature\MembershipsSetting;

use PHPUnit\Framework\TestCase;
use PlugAndPay\Sdk\Entity\Response;
use PlugAndPay\Sdk\Exception\NotFoundException;
use PlugAndPay\Sdk\Exception\UnauthenticatedException;
use PlugAndPay\Sdk\Service\MembershipsSettingService;
use PlugAndPay\Sdk\Tests\Feature\ClientMock;
use PlugAndPay\Sdk\Tests\Feature\MembershipsSetting\Mock\ShowMembershipsSettingMockClient;

class ShowMembershipsSettingTest extends TestCase
{
    /** @test */
    public function it_should_throw_unauthorized_exception_when_user_is_not_authenticated(): void
    {
        // Given
        $client    = new ClientMock(Response::HTTP_UNAUTHORIZED);
        $service   = new MembershipsSettingService($client);
        $exception = null;

        // When
        try {
            $service->find(999);
        } catch (UnauthenticatedException $exception) {
        }

        // Then
        static::assertEquals('Unable to connect with Plug&Pay. Request is unauthenticated.', $exception->getMessage());
    }

    /** @test */
    public function it_should_throw_not_found_exception_when_memberships_setting_is_not_found(): void
    {
        // Given
        $client    = new ClientMock(Response::HTTP_NOT_FOUND);
        $service   = new MembershipsSettingService($client);
        $exception = null;

        // When
        try {
            $service->find(999);
        } catch (NotFoundException $exception) {
        }

        // Then
        static::assertEquals('Not found', $exception->getMessage());
    }

    /** @test */
    public function it_should_show_memberships_setting(): void
    {
        // Given
        $client  = new ShowMembershipsSettingMockClient(data: ['id' => 1]);
        $service = new MembershipsSettingService($client);

        // When
        $setting = $service->find(1);

        // Then
        static::assertSame(1, $setting->id());
        static::assertSame('huddle', $setting->driver());
        static::assertTrue($setting->isActive());
        static::assertSame(1, $setting->tenantId());
        static::assertSame('secret_token', $setting->apiToken());
        static::assertSame('2021-01-01 00:00:00', $setting->createdAt()->format('Y-m-d H:i:s'));
        static::assertNull($setting->updatedAt());
    }
}
