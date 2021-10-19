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
        $client = new OrderGetClientMock(['id' => 1]);

        $service = new FetchOrderService($client);
        $order   = $service->find(1);

        static::assertEquals(1, $order->id());
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
