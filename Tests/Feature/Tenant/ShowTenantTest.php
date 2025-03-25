<?php

/** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

namespace PlugAndPay\Sdk\Tests\Feature\Tenant;

use PHPUnit\Framework\TestCase;
use PlugAndPay\Sdk\Entity\Response;
use PlugAndPay\Sdk\Exception\NotFoundException;
use PlugAndPay\Sdk\Exception\UnauthenticatedException;
use PlugAndPay\Sdk\Service\TenantService;
use PlugAndPay\Sdk\Tests\Feature\ClientMock;
use PlugAndPay\Sdk\Tests\Feature\Tenant\Mock\TenantShowMockClient;

class ShowTenantTest extends TestCase
{
    /** @test */
    public function it_should_throw_unauthorized_when_call_is_not_authenticated(): void
    {
        $client    = new ClientMock(Response::HTTP_UNAUTHORIZED);
        $service   = new TenantService($client);
        $exception = null;

        try {
            $service->find();
        } catch (UnauthenticatedException $exception) {
        }

        static::assertEquals('Unable to connect with Plug&Pay. Request is unauthenticated.', $exception->getMessage());
    }

    /** @test */
    public function it_should_return_not_found_for_non_existing_tenant(): void
    {
        $client    = new ClientMock(Response::HTTP_NOT_FOUND);
        $service   = new TenantService($client);
        $exception = null;

        try {
            $service->find();
        } catch (NotFoundException $exception) {
        }

        static::assertEquals('Not found', $exception->getMessage());
    }

    /** @test */
    public function it_should_show_current_tenant(): void
    {
        $client  = new TenantShowMockClient(data: ['id' => 1]);
        $service = new TenantService($client);

        $tenant = $service->find();

        static::assertSame(1, $tenant->id());
        static::assertSame('lite', $tenant->plan());
    }
}
