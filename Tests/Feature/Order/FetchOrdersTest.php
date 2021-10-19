<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Tests\Feature\Order;

use PHPUnit\Framework\TestCase;
use PlugAndPay\Sdk\Exception\NotFoundException;
use PlugAndPay\Sdk\Service\FetchOrderService;
use PlugAndPay\Sdk\Tests\Feature\GetNotFoundClientMock;

class FetchOrdersTest extends TestCase
{
    /** @test */
    public function fetch_basic_order(): void
    {
        $client  = new OrderGetClientMock(['id' => 1]);
        $service = new FetchOrderService($client);
        $order   = $service->find(1);

        static::assertEquals(1, $order->id());

        static::assertSame('2019-01-16 00:00:00', $order->createdAt()->format('Y-m-d H:i:s'));
        static::assertSame('2019-01-16 00:00:00', $order->deletedAt()->format('Y-m-d H:i:s'));
        static::assertSame(1, $order->id());
        static::assertSame('20214019-T', $order->invoiceNumber());
        static::assertSame('concept', $order->invoiceStatus());
        static::assertTrue($order->isFirst());
        static::assertFalse($order->isHidden());
        static::assertSame('live', $order->mode());
        static::assertSame('0b13e52d-b058-32fb-8507-10dec634a07c', $order->reference());
        static::assertSame('api', $order->source());
        static::assertSame(75., $order->subtotal()->value());
        static::assertSame(75., $order->total()->value());
        static::assertSame('2019-01-16 00:00:00', $order->updatedAt()->format('Y-m-d H:i:s'));
    }

    /** @test */
    public function fetch_not_existing_order(): void
    {
        $client    = new GetNotFoundClientMock();
        $exception = null;

        try {
            $service = new FetchOrderService($client);
            $service->find(999);
        } catch (NotFoundException $exception) {
        }

        static::assertEquals('Order not found with id 999', $exception->getMessage());
    }
}
