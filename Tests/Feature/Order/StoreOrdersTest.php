<?php /** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

namespace PlugAndPay\Sdk\Tests\Feature\Order;

use PHPUnit\Framework\TestCase;
use PlugAndPay\Sdk\Director\ToBody\OrderToBody;
use PlugAndPay\Sdk\Entity\Address;
use PlugAndPay\Sdk\Entity\Billing;
use PlugAndPay\Sdk\Entity\Comment;
use PlugAndPay\Sdk\Entity\Item;
use PlugAndPay\Sdk\Entity\Money;
use PlugAndPay\Sdk\Entity\Order;
use PlugAndPay\Sdk\Entity\Payment;
use PlugAndPay\Sdk\Entity\Response;
use PlugAndPay\Sdk\Enum\CurrencyCodeIso;
use PlugAndPay\Sdk\Enum\PaymentStatus;
use PlugAndPay\Sdk\Enum\TaxExempt;
use PlugAndPay\Sdk\Exception\ValidationException;
use PlugAndPay\Sdk\Service\FetchOrderService;
use PlugAndPay\Sdk\Service\StoreOrderService;
use PlugAndPay\Sdk\Tests\Feature\ClientMock;
use PlugAndPay\Sdk\Tests\Feature\Order\Mock\OrderStoreClientMock;

class StoreOrdersTest extends TestCase
{
    /** @test */
    public function convert_basic_order_to_body(): void
    {
        $body = OrderToBody::build($this->generateOrder());

        static::assertEquals([
            'billing'         => [
                'address'    => [
                    'country' => 'NL',
                ],
                'email'      => 'rosalie39@example.net',
                'first_name' => 'Bilal',
                'last_name'  => 'de Wit',
            ],
            'is_tax_included' => true,
            'items'           => [
                [
                    'label' => 'the-label',
                ],
            ],
        ], $body);
    }

    /** @test */
    public function convert_comments_to_body(): void
    {
        $order = (new Order())
            ->setComments([(new Comment())->setValue('the comment')]);

        $body = OrderToBody::build($order);
        static::assertEquals([
            'comments' => [
                ['value' => 'the comment'],
            ],
        ], $body);
    }

    /** @test */
    public function convert_item_product_id_to_body(): void
    {
        $item = (new Item())
            ->setProductId(1);

        $order = (new Order())
            ->setItems([$item]);

        $body = OrderToBody::build($order);
        static::assertEquals([
            'items' => [
                [
                    'product_id' => 1,
                ],
            ],
        ], $body);
    }

    /** @test */
    public function convert_item_to_body(): void
    {
        $item = (new Item())
            ->setAmount(new Money(10))
            ->setLabel('the-label')
            ->setQuantity(1)
            ->setTaxByRateId(1);

        $order = (new Order())
            ->setItems([$item]);

        $body = OrderToBody::build($order);
        static::assertEquals([
            'items' => [
                [
                    'amount'   => ['value' => 10., 'currency' => CurrencyCodeIso::EUR],
                    'label'    => 'the-label',
                    'quantity' => 1,
                    'tax'      => ['rate' => ['id' => 1]],
                ],
            ],
        ], $body);
    }

    /**
     * @test
     * @dataProvider convert_order_fields_data_provider
     */
    public function convert_order_fields(string $method, string $bodyField, $value): void
    {
        $order = (new Order())->{$method}($value);

        $body = OrderToBody::build($order);

        static::assertEquals($value, $body[$bodyField]);
    }

    public function convert_order_fields_data_provider(): array
    {
        return [
            'isHidden'    => [
                'setHidden',
                'is_hidden',
                true,
            ],
            'taxExempt'   => [
                'setTaxExempt',
                'tax_exempt',
                TaxExempt::REVERSE,
            ],
            'taxIncluded' => [
                'setTaxIncluded',
                'is_tax_included',
                true,
            ],
        ];
    }

    /**
     * @test
     */
    public function convert_order_without_filled_order(): void
    {
        $body = OrderToBody::build(new Order());

        static::assertEquals([], $body);
    }

    /** @test */
    public function convert_payment_status_to_body(): void
    {
        $order = (new Order())
            ->setPayment((new Payment())->setStatus(PaymentStatus::PROCESSING));

        $body = OrderToBody::build($order);

        static::assertEquals([
            'payment' => [
                'status' => PaymentStatus::PROCESSING,
            ],
        ], $body);
    }

    /** @test */
    public function convert_tags_to_body(): void
    {
        $order = (new Order())
            ->setTags(['first_tag', 'second_tag']);

        $body = OrderToBody::build($order);

        static::assertEquals([
            'tags' => ['first_tag', 'second_tag'],
        ], $body);
    }

    /** @test */
    public function store_basic_order(): void
    {
        $client  = new OrderStoreClientMock();
        $service = new StoreOrderService($client);

        $order = $this->generateOrder();
        $order->setHidden(true);
        $order = $service->create($order);

        static::assertEquals(1, $order->id());

        static::assertEquals(true, $client->requestBody()['is_hidden']);
        static::assertEquals('/orders', $client->path());
        static::assertEquals(1, $order->id());
    }

    private function generateBilling(): Billing
    {
        return (new Billing())
            ->setAddress((new Address())->setCountry('NL'))
            ->setEmail('rosalie39@example.net')
            ->setFirstName('Bilal')
            ->setLastName('de Wit');
    }

    private function generateOrder(): Order
    {
        $item = (new Item())->setLabel('the-label');

        return (new Order())
            ->setBilling($this->generateBilling())
            ->setTaxIncluded(true)
            ->setItems([$item]);
    }

    /** @test */
    public function fetch_order_with_validation_error(): void
    {
        $client    = new ClientMock(
            Response::HTTP_UNPROCESSABLE_ENTITY,
            [
                'message' => 'The given data was invalid.',
                'errors'  => [
                    'firstname' => [
                        'Voornaam is verplicht.',
                    ],
                ],
            ],
        );
        $service   = new FetchOrderService($client);
        $exception = null;

        try {
            $service->find(1);
        } catch (ValidationException $exception) {
        }

        static::assertEquals('Voornaam is verplicht.', $exception->getMessage());
        static::assertEquals('Voornaam is verplicht.', $exception->errors()[0]->message());
        static::assertEquals('firstname', $exception->errors()[0]->field());
    }

    /** @test */
    public function fetch_order_with_multiple_validation_errors(): void
    {
        $client    = new ClientMock(
            Response::HTTP_UNPROCESSABLE_ENTITY,
            [
                'message' => 'The given data was invalid.',
                'errors'  => [
                    'firstname' => [
                        'First error.',
                        'Second error.',
                    ],
                    'lastname'  => [
                        'Last error.',
                    ],
                ],
            ],
        );
        $service   = new FetchOrderService($client);
        $exception = null;

        try {
            $service->find(1);
        } catch (ValidationException $exception) {
        }

        static::assertEquals('First error. Second error. Last error.', $exception->getMessage());
        static::assertEquals('First error.', $exception->errors()[0]->message());
        static::assertEquals('firstname', $exception->errors()[0]->field());
    }
}
