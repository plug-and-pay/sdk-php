<?php /** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

namespace PlugAndPay\Sdk\Tests\Feature\Order;

use PHPUnit\Framework\TestCase;
use PlugAndPay\Sdk\Service\DeleteOrderService;
use PlugAndPay\Sdk\Tests\Feature\Order\Mock\OrderDestroyClientMock;

class DeleteOrdersTest extends TestCase
{
    /** @test */
    public function delete_basic_order(): void
    {
        $client  = new OrderDestroyClientMock();
        $service = new DeleteOrderService($client);

        $service->delete(1);

        static::assertEquals('/v2/orders/1', $client->path());
    }
}
