<?php /** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

namespace PlugAndPay\Sdk\Tests\Feature\Order;

use PHPUnit\Framework\TestCase;
use PlugAndPay\Sdk\Entity\Order;
use PlugAndPay\Sdk\Enum\CountryCode;
use PlugAndPay\Sdk\Enum\PaymentStatus;
use PlugAndPay\Sdk\Service\OrderService;
use PlugAndPay\Sdk\Tests\Feature\Order\Mock\OrderUpdateMockClient;

class UpdateOrderTest extends TestCase
{
    /** @test */
    public function update_basic_order(): void
    {
        $client  = new OrderUpdateMockClient();
        $service = new OrderService($client);

        $order = $service->update(1, function (Order $order) {
            $order->setHidden(true);
        });

        static::assertEquals(true, $order->isHidden());
        static::assertEquals('/v2/orders/1', $client->path());
    }

    /** @test */
    public function update_order_relations(): void
    {
        $client  = (new OrderUpdateMockClient())->billing()->payment();
        $service = new OrderService($client);

        $order = $service->update(1, function (Order $order) {
            $order->billing()->contact()->setEmail('updated@email.nl');
            $order->billing()->address()->setCountry(CountryCode::BE);
            $order->billing()->address()->setCountry(CountryCode::BE);
            $order->payment()->setStatus(PaymentStatus::PAID);
        });

        static::assertEquals(CountryCode::BE, $order->billing()->address()->country());
        static::assertEquals('updated@email.nl', $order->billing()->contact()->email());
        static::assertEquals(PaymentStatus::PAID, $order->payment()->status());
    }
}
