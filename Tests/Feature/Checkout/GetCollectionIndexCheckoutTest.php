<?php

/** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

namespace PlugAndPay\Sdk\Tests\Feature\Checkout;

use PHPUnit\Framework\TestCase;
use PlugAndPay\Sdk\Service\CheckoutService;
use PlugAndPay\Sdk\Tests\Feature\Checkout\Mock\CheckoutIndexMockClient;

class GetCollectionIndexCheckoutTest extends TestCase
{
    /** @test */
    public function is_should_return_checkouts(): void
    {
        $client    = (new CheckoutIndexMockClient(meta: [
            'current_page' => 1,
            'last_page'    => 1,
            'per_page'     => 10,
            'total'        => 1,
        ]));

        $service   = new CheckoutService($client);

        $checkoutCollection = $service->getCollection();

        static::assertSame(1, $checkoutCollection->checkouts[0]->id());
        static::assertSame('/v2/checkouts', $client->path());
        static::assertSame(1, $checkoutCollection->meta['current_page']);
        static::assertSame(1, $checkoutCollection->meta['last_page']);
        static::assertSame(10, $checkoutCollection->meta['per_page']);
        static::assertSame(1, $checkoutCollection->meta['total']);
    }
}
