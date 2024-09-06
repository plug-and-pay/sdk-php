<?php

/** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

namespace PlugAndPay\Sdk\Tests\Feature\Checkout;

use PHPUnit\Framework\TestCase;
use PlugAndPay\Sdk\Entity\Response;
use PlugAndPay\Sdk\Exception\NotFoundException;
use PlugAndPay\Sdk\Exception\UnauthenticatedException;
use PlugAndPay\Sdk\Service\CheckoutService;
use PlugAndPay\Sdk\Service\OrderService;
use PlugAndPay\Sdk\Tests\Feature\Checkout\Mock\CheckoutDestroyMockClient;
use PlugAndPay\Sdk\Tests\Feature\Order\Mock\OrderDestroyMockClient;

class DeleteCheckoutTest extends TestCase
{
    /** @test */
    public function it_should_throw_not_found_exception(): void
    {
        $client    = new CheckoutDestroyMockClient(Response::HTTP_NOT_FOUND, []);
        $service   = new CheckoutService($client);
        $exception = null;

        try {
            $service->delete(1);
        } catch (NotFoundException $exception) {
        }

        static::assertInstanceOf(NotFoundException::class, $exception);
    }

    /** @test */
    public function it_should_throw_unauthorised_exception(): void
    {
        $client    = new CheckoutDestroyMockClient(Response::HTTP_UNAUTHORIZED, []);
        $service   = new CheckoutService($client);
        $exception = null;

        try {
            $service->delete(1);
        } catch (UnauthenticatedException $exception) {
        }

        static::assertInstanceOf(UnauthenticatedException::class, $exception);
    }

    /** @test */
    public function it_should_delete_checkout(): void
    {
        $client  = new CheckoutDestroyMockClient(Response::HTTP_NO_CONTENT, []);
        $service = new CheckoutService($client);

        $service->delete(1);

        static::assertEquals('/v2/checkouts/1', $client->path());
    }
}
