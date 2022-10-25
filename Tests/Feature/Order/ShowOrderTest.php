<?php

/** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

namespace PlugAndPay\Sdk\Tests\Feature\Order;

use PHPUnit\Framework\TestCase;
use PlugAndPay\Sdk\Entity\Order;
use PlugAndPay\Sdk\Entity\Response;
use PlugAndPay\Sdk\Enum\CountryCode;
use PlugAndPay\Sdk\Enum\DiscountType;
use PlugAndPay\Sdk\Enum\InvoiceStatus;
use PlugAndPay\Sdk\Enum\ItemType;
use PlugAndPay\Sdk\Enum\Mode;
use PlugAndPay\Sdk\Enum\OrderIncludes;
use PlugAndPay\Sdk\Enum\PaymentMethod;
use PlugAndPay\Sdk\Enum\PaymentProvider;
use PlugAndPay\Sdk\Enum\PaymentStatus;
use PlugAndPay\Sdk\Enum\PaymentType;
use PlugAndPay\Sdk\Enum\Source;
use PlugAndPay\Sdk\Enum\TaxExempt;
use PlugAndPay\Sdk\Exception\NotFoundException;
use PlugAndPay\Sdk\Exception\RelationNotLoadedException;
use PlugAndPay\Sdk\Exception\UnauthenticatedException;
use PlugAndPay\Sdk\Service\OrderService;
use PlugAndPay\Sdk\Tests\Feature\ClientMock;
use PlugAndPay\Sdk\Tests\Feature\Order\Mock\OrderShowMockClient;

class ShowOrderTest extends TestCase
{
    /** @test */
    public function show_basic_order(): void
    {
        $client  = new OrderShowMockClient(['id' => 1]);
        $service = new OrderService($client);

        $order = $service->find(1);

        static::assertSame('2019-01-16 00:00:00', $order->createdAt()->format('Y-m-d H:i:s'));
        static::assertSame('2019-01-16 00:00:00', $order->deletedAt()->format('Y-m-d H:i:s'));
        static::assertSame(1, $order->id());
        static::assertSame('20214019-T', $order->invoiceNumber());
        static::assertSame(InvoiceStatus::CONCEPT, $order->invoiceStatus());
        static::assertTrue($order->isFirst());
        static::assertFalse($order->isHidden());
        static::assertSame(Mode::LIVE, $order->mode());
        static::assertSame('0b13e52d-b058-32fb-8507-10dec634a07c', $order->reference());
        static::assertSame(Source::API, $order->source());
        static::assertSame(75., $order->amount());
        static::assertSame(75., $order->amountWithTax());
        static::assertSame('2019-01-16 00:00:00', $order->updatedAt()->format('Y-m-d H:i:s'));
    }

    /**
     * @test
     * @dataProvider relationsProvider
     */
    public function show_none_loaded_relationships(string $relation): void
    {
        $exception = null;

        try {
            (new Order(false))->{$relation}();
        } catch (RelationNotLoadedException $exception) {
        }

        static::assertInstanceOf(RelationNotLoadedException::class, $exception);
    }

    /**
     * Data provider for show_none_loaded_relationships.
     */
    public function relationsProvider(): array
    {
        return [
            'billing'        => ['billing'],
            'comments'       => ['comments'],
            'totalDiscounts' => ['totalDiscounts'],
            'items'          => ['items'],
            'payment'        => ['payment'],
            'tags'           => ['tags'],
            'taxes'          => ['taxes'],
        ];
    }

    /** @test */
    public function show_not_existing_order(): void
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
    public function show_unauthorized_order(): void
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
    public function show_order_billing_basic(): void
    {
        $client  = (new OrderShowMockClient())->billingOnlyRequired();
        $service = new OrderService($client);

        $order = $service->find(1);

        $billing = $order->billing();
        $contact = $billing->contact();
        static::assertNull($contact->company());
        static::assertSame('rosalie39@example.net', $contact->email());
        static::assertSame('Bilal', $contact->firstName());
        static::assertSame('de Wit', $contact->lastName());
        static::assertNull($contact->telephone());
        static::assertNull($contact->website());
        static::assertNull($contact->vatIdNumber());
        static::assertSame(TaxExempt::NONE, $contact->taxExempt());

        $address = $billing->address();
        static::assertNull($address->city());
        static::assertNull($address->country());
        static::assertNull($address->street());
        static::assertNull($address->houseNumber());
        static::assertNull($address->zipcode());
    }

    /** @test */
    public function show_order_billing_address_and_contact(): void
    {
        $client  = (new OrderShowMockClient())->billing();
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
        static::assertSame(CountryCode::NL, $address->country());
        static::assertSame('Sanderslaan', $address->street());
        static::assertSame('42', $address->houseNumber());
        static::assertSame('1448VB', $address->zipcode());
    }

    /** @test */
    public function show_order_unknown_tax_exempt(): void
    {
        $client  = (new OrderShowMockClient())->billingOnlyRequired([
            'contact' => [
                'company'       => null,
                'email'         => 'rosalie39@example.net',
                'firstname'     => 'Bilal',
                'invoice_email' => null,
                'lastname'      => 'de Wit',
                'tax_exempt'    => 'unknown',
                'telephone'     => null,
                'website'       => null,
                'vat_id_number' => null,
            ], ]);
        $service = new OrderService($client);

        $order = $service->find(1);

        $contact = $order->billing()->contact();
        static::assertEquals(TaxExempt::UNKNOWN, $contact->taxExempt());
    }

    /** @test */
    public function show_order_comments(): void
    {
        $client  = (new OrderShowMockClient())->comments();
        $service = new OrderService($client);

        $order = $service->find(1);

        $comment = $order->comments()[0];
        static::assertSame('2019-01-16 12:00:00', $comment->createdAt()->format('Y-m-d H:i:s'));
        static::assertSame(1, $comment->id());
        static::assertSame('2019-01-17 12:10:00', $comment->updatedAt()->format('Y-m-d H:i:s'));
        static::assertSame('Nice products', $comment->value());
    }

    /** @test */
    public function show_order_items(): void
    {
        $client  = (new OrderShowMockClient())->items();
        $service = new OrderService($client);
        $order   = $service->find(1);

        $item = $order->items()[0];

        static::assertSame([], $item->discounts());
        static::assertSame(1, $item->id());
        static::assertSame(1, $item->productId());
        static::assertSame('culpa', $item->label());
        static::assertSame(1, $item->quantity());
        static::assertSame(75., $item->amount());
        static::assertSame(90.75, $item->amountWithTax());
        static::assertSame(ItemType::STANDARD, $item->type());
    }

    /** @test */
    public function show_order_payment_non_filled(): void
    {
        $client  = (new OrderShowMockClient())->paymentOnlyBasic();
        $service = new OrderService($client);

        $order = $service->include(OrderIncludes::PAYMENT)->find(1);

        $payment = $order->payment();
        static::assertSame('/v2/orders/1?include=payment', $client->path());
        static::assertNull($payment->customerId());
        static::assertNull($payment->mandateId());
        static::assertNull($payment->method());
        static::assertSame(PaymentType::MAIL, $payment->type());
        static::assertNull($payment->provider());
        static::assertNull($payment->transactionId());
        static::assertSame(1, $payment->orderId());
        static::assertNull($payment->paidAt());
        static::assertSame(PaymentStatus::OPEN, $payment->status());
        static::assertSame('https://consequatur-quisquam.testing.test/orders/payment-link/0b13e52d-b058-32fb-8507-10dec634a07c', $payment->url());
    }

    /** @test */
    public function show_order_payment(): void
    {
        $client  = (new OrderShowMockClient())->payment();
        $service = new OrderService($client);

        $order = $service->include(OrderIncludes::PAYMENT)->find(1);

        $payment = $order->payment();
        static::assertSame('/v2/orders/1?include=payment', $client->path());
        static::assertSame('qfeio43asdf1f11', $payment->customerId());
        static::assertSame('qwertyasdf', $payment->mandateId());
        static::assertSame(PaymentMethod::BANKTRANSFER, $payment->method());
        static::assertSame(PaymentType::MANDATE, $payment->type());
        static::assertSame(PaymentProvider::MOLLIE, $payment->provider());
        static::assertSame('tr_123456mock', $payment->transactionId());
        static::assertSame(1, $payment->orderId());
        static::assertSame('2019-01-19 00:00:00', $payment->paidAt()->format('Y-m-d H:i:s'));
        static::assertSame(PaymentStatus::PAID, $payment->status());
        static::assertSame('https://consequatur-quisquam.testing.test/orders/payment-link/0b13e52d-b058-32fb-8507-10dec634a07c', $payment->url());
    }

    /** @test */
    public function show_order_tags(): void
    {
        $client  = (new OrderShowMockClient())->tags(['first', 'second']);
        $service = new OrderService($client);

        $order = $service->find(1);

        static::assertSame(['first', 'second'], $order->tags());
    }

    /** @test */
    public function show_order_taxes(): void
    {
        $client  = (new OrderShowMockClient())->taxes();
        $service = new OrderService($client);

        $order = $service->find(1);

        static::assertSame(10., $order->taxes()[0]->amount());
        static::assertSame(CountryCode::NL, $order->taxes()[0]->rate()->country());
        static::assertSame(57, $order->taxes()[0]->rate()->id());
        static::assertSame(21., $order->taxes()[0]->rate()->percentage());

        $tax = $order->items()[0]->tax();
        static::assertSame(10., $tax->amount());
        static::assertSame(CountryCode::NL, $tax->rate()->country());
        static::assertSame(57, $tax->rate()->id());
        static::assertSame(21., $tax->rate()->percentage());
    }

    /** @test */
    public function show_order_discount(): void
    {
        $client  = (new OrderShowMockClient())->discounts();
        $service = new OrderService($client);

        $order = $service->find(1);

        static::assertSame(DiscountType::PROMOTION, $order->totalDiscounts()[0]->type());
        static::assertSame(DiscountType::PROMOTION, $order->items()[0]->discounts()[0]->type());
    }

    /** @test */
    public function show_order_with_empty_source(): void
    {
        $client  = (new OrderShowMockClient([
            'source' => null,
        ]));
        $service = new OrderService($client);

        $order = $service->find(1);

        static::assertSame(Source::UNKNOWN, $order->source());
    }
}
