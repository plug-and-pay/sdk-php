<?php /** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

namespace PlugAndPay\Sdk\Tests\Feature\OrderPayment;

use PHPUnit\Framework\TestCase;
use PlugAndPay\Sdk\Entity\Payment;
use PlugAndPay\Sdk\Enum\PaymentStatus;
use PlugAndPay\Sdk\Service\OrderPaymentService;
use PlugAndPay\Sdk\Tests\Feature\OrderPayment\Mock\OrderPaymentUpdateMockClient;

class UpdateOrderPaymentTest extends TestCase
{
    /** @test */
    public function update_basic_order_payment(): void
    {
        $client  = new OrderPaymentUpdateMockClient();
        $service = new OrderPaymentService($client);

        $paymentId = 1;
        $payment = $service->update($paymentId, function (Payment $payment) {
            $payment->setStatus(PaymentStatus::OPEN);
        });

        static::assertEquals('open', $payment->status()->value);
        static::assertEquals('/v2/orders/1/payment', $client->path());
    }
}
