<?php

/** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

namespace PlugAndPay\Sdk\Tests\Feature\Checkout;

use PHPUnit\Framework\TestCase;
use PlugAndPay\Sdk\Entity\Checkout;
use PlugAndPay\Sdk\Entity\Response;
use PlugAndPay\Sdk\Exception\UnauthenticatedException;
use PlugAndPay\Sdk\Service\CheckoutService;
use PlugAndPay\Sdk\Tests\Feature\Checkout\Mock\CheckoutShowMockClient;
use PlugAndPay\Sdk\Tests\Feature\Checkout\Mock\CheckoutUpdateMockClient;

class UpdateCheckoutTest extends TestCase
{
    /** @test */
    public function it_should_throw_unauthorized_exception(): void
    {
        $client    = new CheckoutShowMockClient(status: Response::HTTP_UNAUTHORIZED);
        $service   = new CheckoutService($client);
        $exception = null;

        try {
            $service->update(999, function (Checkout $checkout) {
            });
        } catch (UnauthenticatedException $exception) {
        }

        static::assertEquals('Unable to connect with Plug&Pay. Request is unauthenticated.', $exception->getMessage());
    }

    /** @test */
    public function it_should_update_basic_checkout(): void
    {
        $client  = new CheckoutUpdateMockClient();
        $service = new CheckoutService($client);

        $checkout = $service->update(1, function (Checkout $checkout) {
            $checkout->setIsActive(false);
        });

        static::assertFalse($checkout->isActive());
        static::assertEquals('/v2/checkouts/1', $client->path());
    }

    /** @test */
    public function it_should_update_product_id(): void
    {
        $client  = (new CheckoutUpdateMockClient())->productPricing();
        $service = new CheckoutService($client);

        $checkout = $service->update(1, function (Checkout $checkout) {
            $checkout->setProductId(123);
        });

        static::assertEquals(123, $checkout->product()->id());
    }
}
