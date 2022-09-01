<?php /** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

namespace PlugAndPay\Sdk\Tests\Feature\Order;

use PHPUnit\Framework\TestCase;
use PlugAndPay\Sdk\Entity\Response;
use PlugAndPay\Sdk\Service\OrderService;
use PlugAndPay\Sdk\Tests\Feature\Order\Mock\OrderDestroyMockClient;

class DeleteOrdersTest extends TestCase
{
    /** @test */
    public function delete_basic_order(): void
    {
        $client  = new OrderDestroyMockClient(Response::HTTP_NO_CONTENT, []);
        $service = new OrderService($client);

        $service->delete(1);

        static::assertEquals('/v2/orders/1', $client->path());
    }
}
