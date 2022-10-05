<?php /** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

namespace PlugAndPay\Sdk\Tests\Feature\Order;

use PHPUnit\Framework\TestCase;
use PlugAndPay\Sdk\Service\OrderService;
use PlugAndPay\Sdk\Tests\Feature\Order\Mock\OrderPaymentShowMockClient;

class ShowOrderPaymentTest extends TestCase
{
    /** @test */
    public function show_basic_order_payment(): void
    {
        $client = (new OrderPaymentShowMockClient());
        $service = new OrderService($client);

        $orderPayment = $service->findPayment(11);

        static::assertSame('manual', $orderPayment->type()->value);
        static::assertSame(11, $orderPayment->orderId());
        static::assertSame('paid', $orderPayment->status()->value);
        static::assertSame('https://consequatur-quisquam.testing.test/orders/payment-link/0b13e52d-b058-32fb-8507-10dec634a07c', $orderPayment->url());
    }
}
