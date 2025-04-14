<?php

/** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

namespace PlugAndPay\Sdk\Tests\Feature\Checkout;

use PHPUnit\Framework\TestCase;
use PlugAndPay\Sdk\Enum\CheckoutSort;
use PlugAndPay\Sdk\Enum\CheckoutStatus;
use PlugAndPay\Sdk\Filters\CheckoutFilter;
use PlugAndPay\Sdk\Service\CheckoutService;
use PlugAndPay\Sdk\Tests\Feature\Checkout\Mock\CheckoutIndexMockClient;

class IndexCheckoutTest extends TestCase
{
    /** @test */
    public function is_should_return_checkouts(): void
    {
        $client    = (new CheckoutIndexMockClient());
        $service   = new CheckoutService($client);
        $checkouts = $service->get();

        static::assertSame(1, $checkouts[0]->id());
        static::assertSame('/v2/checkouts', $client->path());
    }

    /**
     * @dataProvider checkoutFilterDataProvider
     * @test
     */
    public function it_should_return_filtered_checkouts(string $method, mixed $value, string $queryKey, string $queryValue): void
    {
        $client  = (new CheckoutIndexMockClient());
        $service = new CheckoutService($client);

        $filter = (new CheckoutFilter())->$method($value);
        $service->get($filter);

        static::assertSame("/v2/checkouts?$queryKey=$queryValue", $client->path());
    }

    /** @test  */
    public function it_should_return_paginated_checkouts(): void
    {
        $client  = (new CheckoutIndexMockClient());
        $service = new CheckoutService($client);

        $filter = (new CheckoutFilter())->page(10);
        $service->get($filter);

        static::assertSame('/v2/checkouts?page=10', $client->path());
    }

    /** @test */
    public function it_should_return_meta_data_on_paginated_checkouts(): void
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

    public static function checkoutFilterDataProvider(): array
    {
        return [
            [
                'method'     => 'limit',
                'value'      => 4,
                'queryKey'   => 'limit',
                'queryValue' => '4',
            ],
            [
                'method'     => 'query',
                'value'      => 'test',
                'queryKey'   => 'q',
                'queryValue' => 'test',
            ],
            [
                'method'     => 'productId',
                'value'      => 1,
                'queryKey'   => 'product_id',
                'queryValue' => '1',
            ],
            [
                'method'     => 'status',
                'value'      => CheckoutStatus::DELETED,
                'queryKey'   => 'status',
                'queryValue' => 'deleted',
            ],
            [
                'method'     => 'sort',
                'value'      => CheckoutSort::CONVERSION,
                'queryKey'   => 'sort',
                'queryValue' => 'conversion%7Casc',
            ],
        ];
    }
}
