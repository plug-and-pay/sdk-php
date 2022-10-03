<?php /** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

namespace PlugAndPay\Sdk\Tests\Feature\Order;

use PHPUnit\Framework\TestCase;
use PlugAndPay\Sdk\Entity\Payment;
use PlugAndPay\Sdk\Enum\PaymentStatus;
use PlugAndPay\Sdk\Service\OrderService;
use PlugAndPay\Sdk\Tests\Feature\Order\Mock\OrderPaymentUpdateMockClient;

class UpdateOrderPaymentTest extends TestCase
{
    /** @test */
    public function update_basic_order_payment(): void
    {
        $client  = new OrderPaymentUpdateMockClient();
        $service = new OrderService($client);

        $orderPayment = $service->updateOrderPayment(1, function (Payment $payment) {
            $payment->setStatus(PaymentStatus::OPEN);
        });

        dd($orderPayment);

        static::assertEquals('/v2/orders/1/payment', $client->path());
    }
}
