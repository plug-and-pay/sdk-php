<?php /** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

namespace PlugAndPay\Sdk\Tests\Feature\Order;

use PHPUnit\Framework\TestCase;
use PlugAndPay\Sdk\Entity\Order;
use PlugAndPay\Sdk\Entity\Response;
use PlugAndPay\Sdk\Enum\DiscountType;
use PlugAndPay\Sdk\Enum\OrderIncludes;
use PlugAndPay\Sdk\Enum\PaymentStatus;
use PlugAndPay\Sdk\Exception\NotFoundException;
use PlugAndPay\Sdk\Exception\RelationNotLoadedException;
use PlugAndPay\Sdk\Exception\UnauthenticatedException;
use PlugAndPay\Sdk\Filters\OrderFilter;
use PlugAndPay\Sdk\Service\OrderService;
use PlugAndPay\Sdk\Tests\Feature\ClientMock;
use PlugAndPay\Sdk\Tests\Feature\Order\Mock\OrderShowClientMock;
use PlugAndPay\Sdk\Tests\Feature\Order\Mock\OrdersIndexClientMock;

class FetchOrdersTest extends TestCase
{
    /** @test */
    public function fetch_basic_order(): void
    {
        $client  = new OrderShowClientMock(['id' => 1]);
        $service = new OrderService($client);

        $order = $service->find(1);

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
        static::assertSame(75., $order->amount()->value());
        static::assertSame(75., $order->amountWithTax()->value());
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
            (new Order(false))->{$relation}();
        } catch (RelationNotLoadedException $exception) {
        }

        static::assertInstanceOf(RelationNotLoadedException::class, $exception);
    }

    /** @test */
    public function fetch_not_existing_order(): void
    {
        $client    = new ClientMock(Response::HTTP_NOT_FOUND);
        $service   = new OrderService($client);
        $exception = null;

        try {
            $service->find(999);
        } catch (NotFoundException $exception) {
        }

        static::assertEquals('Not found', $exception->getMessage());
    }

    /** @test */
    public function fetch_unauthorized_order(): void
    {
        $client    = new ClientMock(Response::HTTP_UNAUTHORIZED);
        $service   = new OrderService($client);
        $exception = null;

        try {
            $service->find(999);
        } catch (UnauthenticatedException $exception) {
        }

        static::assertEquals('Unable to connect with Plug&Pay. Request is unauthenticated.', $exception->getMessage());
    }

    /** @test */
    public function fetch_order_billing_address_and_contact(): void
    {
        $client  = (new OrderShowClientMock(['id' => 1]))->billing();
        $service = new OrderService($client);

        $order = $service->find(1);

        $billing = $order->billing();
        $contact = $billing->contact();
        static::assertSame('Café Timmermans & Zn', $contact->company());
        static::assertSame('rosalie39@example.net', $contact->email());
        static::assertSame('Bilal', $contact->firstName());
        static::assertSame('de Wit', $contact->lastName());
        static::assertSame('(044) 4362837', $contact->telephone());
        static::assertSame('https://www.vandewater.nl/velit-porro-ut-velit-soluta.html', $contact->website());
        static::assertSame('NL000099998B57', $contact->vatIdNumber());

        $address = $billing->address();
        static::assertSame('\'t Veld', $address->city());
        static::assertSame('NL', $address->country());
        static::assertSame('Sanderslaan', $address->street());
        static::assertSame('42', $address->houseNumber());
        static::assertSame('1448VB', $address->zipcode());
    }

    /** @test */
    public function fetch_order_comments(): void
    {
        $client  = (new OrderShowClientMock(['id' => 1]))->comments();
        $service = new OrderService($client);

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
        $service = new OrderService($client);
        $order   = $service->find(1);

        $item = $order->items()[0];

        static::assertSame([], $item->discounts());
        static::assertSame(1, $item->id());
        static::assertSame(1, $item->productId());
        static::assertSame('culpa', $item->label());
        static::assertSame(1, $item->quantity());
        static::assertSame(75., $item->amount()->value());
        static::assertSame(90.75, $item->amountWithTax()->value());
        static::assertNull($item->type());
    }

    /** @test */
    public function fetch_order_payment(): void
    {
        $client  = (new OrderShowClientMock(['id' => 1]))->payment();
        $service = new OrderService($client);

        $order = $service->include(OrderIncludes::PAYMENT)->find(1);

        $payment = $order->payment();
        static::assertSame('/v2/orders/1?include=payment', $client->path());
        static::assertSame(1, $payment->orderId());
        static::assertSame('2019-01-19 00:00:00', $payment->paidAt()->format('Y-m-d H:i:s'));
        static::assertSame(PaymentStatus::PAID, $payment->status());
        static::assertSame('https://consequatur-quisquam.testing.test/orders/payment-link/0b13e52d-b058-32fb-8507-10dec634a07c', $payment->url());
    }

    /** @test */
    public function fetch_order_tags(): void
    {
        $client  = (new OrderShowClientMock(['id' => 1]))->tags(['first', 'second']);
        $service = new OrderService($client);

        $order = $service->find(1);

        static::assertSame(['first', 'second'], $order->tags());
    }

    /** @test */
    public function fetch_order_taxes(): void
    {
        $client  = (new OrderShowClientMock(['id' => 1]))->taxes();
        $service = new OrderService($client);

        $order = $service->find(1);

        static::assertSame(15.75, $order->taxes()[0]->amount()->value());
        static::assertSame('EUR', $order->taxes()[0]->amount()->currency());
        static::assertSame('NL', $order->taxes()[0]->rate()->country());
        static::assertSame(57, $order->taxes()[0]->rate()->id());
        static::assertSame(21., $order->taxes()[0]->rate()->percentage());

        $tax = $order->items()[0]->tax();
        static::assertSame(15.75, $tax->amount()->value());
        static::assertSame('EUR', $tax->amount()->currency());
        static::assertSame('NL', $tax->rate()->country());
        static::assertSame(57, $tax->rate()->id());
        static::assertSame(21., $tax->rate()->percentage());
    }

    /** @test */
    public function fetch_order_discount(): void
    {
        $client  = (new OrderShowClientMock(['id' => 1]))->discounts();
        $service = new OrderService($client);

        $order = $service->find(1);

        static::assertSame(DiscountType::SALE, $order->discounts()[0]->type());
        static::assertSame(DiscountType::SALE, $order->items()[0]->discounts()[0]->type());
    }

    /** @test */
    public function fetch_orders(): void
    {
        $client  = (new OrdersIndexClientMock());
        $service = new OrderService($client);
        $orders  = $service->include(OrderIncludes::PAYMENT)->get();

        static::assertSame(1, $orders[0]->id());
        static::assertSame('/v2/orders?include=payment', $client->path());
    }

    /** @test */
    public function fetch_orders_with_filter(): void
    {
        $client  = (new OrdersIndexClientMock());
        $service = new OrderService($client);

        $filter = (new OrderFilter())->country('NL');
        $service->get($filter);

        static::assertSame('/v2/orders?country=NL', $client->path());
    }

    /**
     * Data provider for fetch_none_loaded_relationships
     */
    public function relationsProvider(): array
    {
        return [
            'billing'      => ['billing'],
            'comments'     => ['comments'],
            'discounts'    => ['discounts'],
            'items'        => ['items'],
            'payment'      => ['payment'],
            'tags'         => ['tags'],
            'taxes'        => ['taxes'],
        ];
    }
}
