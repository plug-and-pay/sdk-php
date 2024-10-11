<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Tests\Feature\MembershipsSetting;

use PHPUnit\Framework\TestCase;
use PlugAndPay\Sdk\Entity\Response;
use PlugAndPay\Sdk\Exception\NotFoundException;
use PlugAndPay\Sdk\Exception\UnauthenticatedException;
use PlugAndPay\Sdk\Service\MembershipsSettingService;
use PlugAndPay\Sdk\Tests\Feature\ClientMock;
use PlugAndPay\Sdk\Tests\Feature\MembershipsSetting\Mock\DestroyMembershipsSettingMockClient;
use PlugAndPay\Sdk\Tests\Feature\Rule\Mock\DestroyRuleMockClient;

class DestroyMembershipsSettingTest extends TestCase
{
    /** @test */
    public function it_should_throw_not_found_exception_when_memberships_setting_is_not_found(): void
    {
        $client    = new DestroyMembershipsSettingMockClient(Response::HTTP_NOT_FOUND);
        $service   = new MembershipsSettingService($client);
        $exception = null;

        try {
            $service->delete(1);
        } catch (NotFoundException $exception) {
        }

        static::assertInstanceOf(NotFoundException::class, $exception);
    }

    /** @test */
    public function it_should_throw_unauthorized_exception_when_user_is_not_authenticated(): void
    {
        // Given
        $client    = new ClientMock(Response::HTTP_UNAUTHORIZED);
        $service   = new MembershipsSettingService($client);
        $exception = null;

        // When
        try {
            $service->delete(1);
        } catch (UnauthenticatedException $exception) {
        }

        // Then
        static::assertEquals('Unable to connect with Plug&Pay. Request is unauthenticated.', $exception->getMessage());
    }

    /** @test */
    public function it_should_delete_existing_memberships_setting(): void
    {
        $client  = new DestroyRuleMockClient(Response::HTTP_NO_CONTENT, []);
        $service = new MembershipsSettingService($client);

        $service->delete(1);

        static::assertEquals('/v2/memberships/settings/1', $client->path());
    }
}
