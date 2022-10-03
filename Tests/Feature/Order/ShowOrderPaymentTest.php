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
        static::assertSame('2022-09-30', $orderPayment->paidAt()->format('Y-m-d'));
        static::assertSame('paid', $orderPayment->status()->value);
        static::assertSame('https://plugandpay.nl/orders/payment-link/ec57a6b6-4fe2-45de-9aff-2183ec60ea20', $orderPayment->url());
    }
}
