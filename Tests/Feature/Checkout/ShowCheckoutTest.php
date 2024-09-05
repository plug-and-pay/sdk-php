<?php

namespace PlugAndPay\Sdk\Tests\Feature\Checkout;

use PHPUnit\Framework\TestCase;
use PlugAndPay\Sdk\Entity\Response;
use PlugAndPay\Sdk\Exception\NotFoundException;
use PlugAndPay\Sdk\Exception\UnauthenticatedException;
use PlugAndPay\Sdk\Service\CheckoutService;
use PlugAndPay\Sdk\Tests\Feature\Checkout\Mock\CheckoutShowMockClient;

class ShowCheckoutTest extends TestCase
{
    /** @test */
    public function it_should_throw_unauthorized_exception(): void
    {
        $client    = new CheckoutShowMockClient(status: Response::HTTP_UNAUTHORIZED);
        $service   = new CheckoutService($client);
        $exception = null;

        try {
            $service->find(999);
        } catch (UnauthenticatedException $exception) {
        }

        static::assertEquals('Unable to connect with Plug&Pay. Request is unauthenticated.', $exception->getMessage());
    }

    /** @test */
    public function it_should_throw_not_found_when_checkout_not_found(): void
    {
        $client    = new CheckoutShowMockClient(status: Response::HTTP_NOT_FOUND);
        $service   = new CheckoutService($client);
        $exception = null;

        try {
            $service->find(999);
        } catch (NotFoundException $exception) {
        }

        static::assertEquals('Not found', $exception->getMessage());
    }

    /** @test */
    public function it_should_return_basic_order(): void
    {
        $client  = new CheckoutShowMockClient(status: 200, data: ['id' => 1]);
        $service = new CheckoutService($client);

        $checkout = $service->find(1);

        static::assertSame(1, $checkout->id());
        static::assertTrue($checkout->isActive());
        static::assertFalse($checkout->isExpired());
        static::assertSame('lorem-ipsum-test', $checkout->name());
        static::assertSame('https://example.com/preview-url', $checkout->previewUrl());
        static::assertSame('#ff0000', $checkout->primaryColor());
        static::assertSame('https://example.com/return-url', $checkout->returnUrl());
        static::assertSame('#00ff00', $checkout->secondaryColor());
        static::assertSame('lorem-ipsum-test', $checkout->slug());
        static::assertSame('https://example.com/url', $checkout->url());
        static::assertSame('2019-01-16 00:00:00', $checkout->createdAt()->format('Y-m-d H:i:s'));
        static::assertSame('2019-01-16 00:00:00', $checkout->updatedAt()->format('Y-m-d H:i:s'));
        static::assertSame('2019-01-16 00:00:00', $checkout->deletedAt()->format('Y-m-d H:i:s'));
    }
}
