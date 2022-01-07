<?php /** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

namespace PlugAndPay\Sdk\Tests\Feature\Order;

use BadFunctionCallException;
use PHPUnit\Framework\TestCase;
use PlugAndPay\Sdk\Entity\Order;
use PlugAndPay\Sdk\Entity\Response;
use PlugAndPay\Sdk\Enum\PaymentStatus;
use PlugAndPay\Sdk\Service\OrderService;
use PlugAndPay\Sdk\Tests\Feature\ClientMock;
use PlugAndPay\Sdk\Tests\Feature\Order\Mock\OrderUpdateClientMock;

class UpdateOrdersTest extends TestCase
{
    /** @test */
    public function update_basic_order(): void
    {
        $client  = new OrderUpdateClientMock();
        $service = new OrderService($client);

        $service->update(1, function (Order $order) {
            $order->setHidden(true);
        });

        static::assertEquals(['is_hidden' => true], $client->requestBody());
        static::assertEquals('/v2/orders/1', $client->path());
    }

    /** @test */
    public function update_order_relations(): void
    {
        $client  = (new OrderUpdateClientMock())->billing()->payment();
        $service = new OrderService($client);

        $service->update(1, function (Order $order) {
            $order->billing()->contact()->setEmail('updated@email.nl');
            $order->billing()->address()->setCountry('BE');
            $order->billing()->address()->setCountry('BE');
            $order->payment()->setStatus(PaymentStatus::PAID);
        });

        static::assertEquals(
            [
                'billing' => [
                    'address' => [
                        'country' => 'BE',
                    ],
                    'contact' => [
                        'email' => 'updated@email.nl',
                    ],
                ],
                'payment' => [
                    'status' => 'paid',
                ],
            ], $client->requestBody());
    }

    /** @test */
    public function update_order_payment_request(): void
    {
        $client    = new ClientMock(Response::HTTP_OK);
        $service   = new OrderService($client);
        $exception = null;

        try {
            $service->update(1, function (Order $order) {
                $order->paymentRequest()->setIban('bla');
            });
        } catch (BadFunctionCallException $exception) {
        }

        static::assertEquals('Payment request may only be used when making an order and cannot be modified or retrieved later.', $exception->getMessage());
    }
}
