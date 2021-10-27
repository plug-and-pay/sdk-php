<?php /** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

namespace PlugAndPay\Sdk\Tests\Feature\Order;

use PHPUnit\Framework\TestCase;
use PlugAndPay\Sdk\Entity\Order;
use PlugAndPay\Sdk\Enum\PaymentStatus;
use PlugAndPay\Sdk\Exception\NotFoundException;
use PlugAndPay\Sdk\Exception\RelationNotLoadedException;
use PlugAndPay\Sdk\Service\FetchOrderService;
use PlugAndPay\Sdk\Tests\Feature\GetNotFoundClientMock;
use PlugAndPay\Sdk\Tests\Feature\Order\Mock\OrderShowClientMock;
use PlugAndPay\Sdk\Tests\Feature\Order\Mock\OrdersIndexClientMock;

class FetchOrdersTest extends TestCase
{
    /** @test */
    public function fetch_basic_order(): void
    {
        $client  = new OrderShowClientMock(['id' => 1]);
        $service = new FetchOrderService($client);

        $order = $service->find(1);

        static::assertEquals(1, $order->id());
        static::assertSame('2019-01-16 00:00:00', $order->createdAt()->format('Y-m-d H:i:s'));
        static::assertSame('2019-01-16 00:00:00', $order->deletedAt()->format('Y-m-d H:i:s'));
        static::assertSame(1, $order->id());
        static::assertSame('20214019-T', $order->invoiceNumber());
        static::assertSame('concept', $order->invoiceStatus());
        static::assertTrue($order->isFirst());
        static::assertFalse($order->isHidden());
        static::assertTrue($order->isTaxIncluded());
        static::assertSame('live', $order->mode());
        static::assertSame('0b13e52d-b058-32fb-8507-10dec634a07c', $order->reference());
        static::assertSame('api', $order->source());
        static::assertSame(75., $order->subtotal()->value());
        static::assertSame(75., $order->total()->value());
        static::assertSame('2019-01-16 00:00:00', $order->updatedAt()->format('Y-m-d H:i:s'));
    }

    /**
     * @test
     * @dataProvider relationsProvider
     */
    public function fetch_none_loaded_relationships(string $relation): void
    {
        $exception = null;

        try {
            (new Order())->{$relation}();
        } catch (RelationNotLoadedException $exception) {
        }

        static::assertInstanceOf(RelationNotLoadedException::class, $exception);
    }

    /** @test */
    public function fetch_not_existing_order(): void
    {
        $client    = new GetNotFoundClientMock();
        $service   = new FetchOrderService($client);
        $exception = null;

        try {
            $service->find(999);
        } catch (NotFoundException $exception) {
        }

        static::assertEquals('Order not found with id 999', $exception->getMessage());
    }

    /** @test */
    public function fetch_order_billing_and_address(): void
    {
        $client  = (new OrderShowClientMock(['id' => 1]))->billing();
        $service = new FetchOrderService($client);

        $order = $service->find(1);

        $billing = $order->billing();
        static::assertSame('Café Timmermans & Zn', $billing->company());
        static::assertSame('rosalie39@example.net', $billing->email());
        static::assertSame('Bilal', $billing->firstName());
        static::assertSame('maarten.veenstra@example.net', $billing->invoiceEmail());
        static::assertSame('de Wit', $billing->lastName());
        static::assertSame('(044) 4362837', $billing->telephone());
        static::assertSame('https://www.vandewater.nl/velit-porro-ut-velit-soluta.html', $billing->website());

        $address = $billing->address();
        static::assertSame('\'t Veld', $address->city());
        static::assertSame('NL', $address->country());
        static::assertSame('Sanderslaan', $address->street());
        static::assertSame('42', $address->streetSuffix());
        static::assertSame('1448VB', $address->zipcode());
    }

    /** @test */
    public function fetch_order_comments(): void
    {
        $client  = (new OrderShowClientMock(['id' => 1]))->comments();
        $service = new FetchOrderService($client);

        $order = $service->find(1);

        $comment = $order->comments()[0];
        static::assertSame('2019-01-16 12:00:00', $comment->createdAt()->format('Y-m-d H:i:s'));
        static::assertSame(1, $comment->id());
        static::assertSame('2019-01-17 12:10:00', $comment->updatedAt()->format('Y-m-d H:i:s'));
        static::assertSame('Nice products', $comment->value());
    }

    /** @test */
    public function fetch_order_items(): void
    {
        $client  = (new OrderShowClientMock(['id' => 1]))->items();
        $service = new FetchOrderService($client);
        $order   = $service->find(1);

        $item = $order->items()[0];

        static::assertSame([], $item->discounts());
        static::assertSame(1, $item->id());
        static::assertSame(1, $item->productId());
        static::assertSame('culpa', $item->label());
        static::assertSame(1, $item->quantity());
        static::assertSame(75., $item->subtotal()->value());
        static::assertSame(90.75, $item->total()->value());
        static::assertNull($item->type());
    }

    /** @test */
    public function fetch_order_payment(): void
    {
        $client  = (new OrderShowClientMock(['id' => 1]))->payment();
        $service = new FetchOrderService($client);

        $order = $service->find(1);

        $payment = $order->payment();
        static::assertSame(1, $payment->orderId());
        static::assertSame('2019-01-19 00:00:00', $payment->paidAt()->format('Y-m-d H:i:s'));
        static::assertSame(PaymentStatus::PAID, $payment->status());
        static::assertSame('https://consequatur-quisquam.testing.test/orders/payment-link/0b13e52d-b058-32fb-8507-10dec634a07c', $payment->url());
    }

    /** @test */
    public function fetch_order_tags(): void
    {
        $client  = (new OrderShowClientMock(['id' => 1]))->tags(['first', 'second']);
        $service = new FetchOrderService($client);

        $order = $service->find(1);

        static::assertSame(['first', 'second'], $order->tags());
    }

    /** @test */
    public function fetch_order_taxes(): void
    {
        $client  = (new OrderShowClientMock(['id' => 1]))->taxes();
        $service = new FetchOrderService($client);

        $order = $service->find(1);

        static::assertSame(15.75, $order->taxes()[0]->amount()->value());
        static::assertSame('EUR', $order->taxes()[0]->amount()->currency());
        static::assertSame('NL', $order->taxes()[0]->rate()->country());
        static::assertSame(21., $order->taxes()[0]->rate()->percentage());

        $tax = $order->items()[0]->tax();
        static::assertSame(15.75, $tax->amount()->value());
        static::assertSame('EUR', $tax->amount()->currency());
        static::assertSame('NL', $tax->rate()->country());
        static::assertSame(21., $tax->rate()->percentage());
    }

    /** @test */
    public function fetch_orders(): void
    {
        $client  = (new OrdersIndexClientMock());
        $service = new FetchOrderService($client);
        $orders  = $service->get();

        static::assertSame(1, $orders[0]->id());
    }

    /**
     * Data provider for fetch_none_loaded_relationships
     */
    public function relationsProvider(): array
    {
        return [
            'billing'  => ['billing'],
            'comments' => ['comments'],
            'items'    => ['items'],
            'payment'  => ['payment'],
            'tags'     => ['tags'],
            'taxes'    => ['taxes'],
        ];
    }
}
