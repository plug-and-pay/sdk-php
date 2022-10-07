<?php

/** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

namespace PlugAndPay\Sdk\Tests\Feature\Order;

use PHPUnit\Framework\TestCase;
use PlugAndPay\Sdk\Entity\Response;
use PlugAndPay\Sdk\Exception\NotFoundException;
use PlugAndPay\Sdk\Exception\UnauthenticatedException;
use PlugAndPay\Sdk\Service\OrderService;
use PlugAndPay\Sdk\Tests\Feature\Order\Mock\OrderDestroyMockClient;

class DeleteOrderTest extends TestCase
{
    /** @test */
    public function delete_order_not_found(): void
    {
        $client    = new OrderDestroyMockClient(Response::HTTP_NOT_FOUND, []);
        $service   = new OrderService($client);
        $exception = null;

        try {
            $service->delete(1);
        } catch (NotFoundException $exception) {
        }

        static::assertInstanceOf(NotFoundException::class, $exception);
    }

    /** @test */
    public function delete_order_unauthenticated(): void
    {
        $client    = new OrderDestroyMockClient(Response::HTTP_UNAUTHORIZED, []);
        $service   = new OrderService($client);
        $exception = null;

        try {
            $service->delete(1);
        } catch (UnauthenticatedException $exception) {
        }

        static::assertInstanceOf(UnauthenticatedException::class, $exception);
    }

    /** @test */
    public function delete_basic_order(): void
    {
        $client  = new OrderDestroyMockClient(Response::HTTP_NO_CONTENT, []);
        $service = new OrderService($client);

        $service->delete(1);

        static::assertEquals('/v2/orders/1', $client->path());
    }
}
