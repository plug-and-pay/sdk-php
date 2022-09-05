<?php /** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

namespace PlugAndPay\Sdk\Tests\Feature\Order;

use PHPUnit\Framework\TestCase;
use PlugAndPay\Sdk\Enum\CountryCode;
use PlugAndPay\Sdk\Enum\OrderIncludes;
use PlugAndPay\Sdk\Filters\OrderFilter;
use PlugAndPay\Sdk\Service\OrderService;
use PlugAndPay\Sdk\Tests\Feature\Order\Mock\OrdersIndexMockClient;

class IndexOrdersTest extends TestCase
{
    /** @test */
    public function fetch_orders(): void
    {
        $client  = (new OrdersIndexMockClient());
        $service = new OrderService($client);
        $orders  = $service->include(OrderIncludes::PAYMENT)->get();

        static::assertSame(1, $orders[0]->id());
        static::assertSame('/v2/orders?include=payment', $client->path());
    }

    /** @test */
    public function fetch_orders_with_filter(): void
    {
        $client  = (new OrdersIndexMockClient());
        $service = new OrderService($client);

        $filter = (new OrderFilter())->country(CountryCode::NL);
        $service->get($filter);

        static::assertSame('/v2/orders?country=NL', $client->path());
    }
}
