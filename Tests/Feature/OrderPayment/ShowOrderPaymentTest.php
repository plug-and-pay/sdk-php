<?php /** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

namespace PlugAndPay\Sdk\Tests\Feature\OrderPayment;

use PHPUnit\Framework\TestCase;
use PlugAndPay\Sdk\Service\OrderPaymentService;
use PlugAndPay\Sdk\Tests\Feature\OrderPayment\Mock\OrderPaymentShowMockClient;

class ShowOrderPaymentTest extends TestCase
{
    /** @test */
    public function show_basic_order_payment(): void
    {
        $client = (new OrderPaymentShowMockClient());
        $service = new OrderPaymentService($client);

        $paymentId = 11;
        $payment = $service->find($paymentId);

        static::assertSame('manual', $payment->type()->value);
        static::assertSame(11, $payment->orderId());
        static::assertSame('paid', $payment->status()->value);
        static::assertSame('https://consequatur-quisquam.testing.test/orders/payment-link/0b13e52d-b058-32fb-8507-10dec634a07c', $payment->url());
    }
}
