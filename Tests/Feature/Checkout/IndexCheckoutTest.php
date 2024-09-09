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
        static::assertSame('/v2/checkouts?include=product', $client->path());
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
                'method'     => 'status',
                'value'      => CheckoutStatus::DELETED,
                'queryKey'   => 'status',
                'queryValue' => 'deleted',
            ],
            [
                'method'     => 'sort',
                'value'      => CheckoutSort::CONVERSION,
                'queryKey'   => 'sort',
                'queryValue' => 'conversion|desc',
            ],
        ];
    }
}
