<?php
/** @noinspection EfferentObjectCouplingInspection */
/** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

namespace PlugAndPay\Sdk\Tests\Feature\Order;

use PHPUnit\Framework\TestCase;
use PlugAndPay\Sdk\Director\ToBody\OrderToBody;
use PlugAndPay\Sdk\Entity\Address;
use PlugAndPay\Sdk\Entity\OrderBilling;
use PlugAndPay\Sdk\Entity\Comment;
use PlugAndPay\Sdk\Entity\Contact;
use PlugAndPay\Sdk\Entity\Item;
use PlugAndPay\Sdk\Entity\Order;
use PlugAndPay\Sdk\Entity\Payment;
use PlugAndPay\Sdk\Entity\Response;
use PlugAndPay\Sdk\Enum\CountryCode;
use PlugAndPay\Sdk\Enum\OrderIncludes;
use PlugAndPay\Sdk\Enum\PaymentStatus;
use PlugAndPay\Sdk\Enum\TaxExempt;
use PlugAndPay\Sdk\Exception\ValidationException;
use PlugAndPay\Sdk\Service\OrderService;
use PlugAndPay\Sdk\Tests\Feature\ClientMock;
use PlugAndPay\Sdk\Tests\Feature\Order\Mock\OrderStoreMockClient;

class StoreOrderTest extends TestCase
{
    /** @test */
    public function convert_basic_order_to_body(): void
    {
        $body = OrderToBody::build($this->generateOrder());

        static::assertEquals([
            'billing'         => [
                'address' => [
                    'country' => 'NL',
                ],
                'contact' => [
                    'email'     => 'rosalie39@example.net',
                    'firstname' => 'Bilal',
                    'lastname'  => 'de Wit',
                ],
            ],
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
            ->setAmount(10.)
            ->setLabel('the-label')
            ->setQuantity(1)
            ->setTaxByRateId(1);

        $order = (new Order())
            ->setItems([$item]);

        $body = OrderToBody::build($order);
        static::assertEquals([
            'items' => [
                [
                    'amount'   => '10.',
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
            'isHidden'  => [
                'setHidden',
                'is_hidden',
                true,
            ],
            'taxExempt' => [
                'setTaxExempt',
                'tax_exempt',
                TaxExempt::REVERSE,
            ],
        ];
    }

    /** @test */
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
                'status' => PaymentStatus::PROCESSING->value,
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
        $client  = new OrderStoreMockClient();
        $service = new OrderService($client);

        $order = $this->generateOrder();
        $order->setHidden(true);
        $order = $service->create($order);

        static::assertEquals(1, $order->id());

        static::assertEquals(true, $client->requestBody()['is_hidden']);
        static::assertEquals('/v2/orders', $client->path());
        static::assertEquals(1, $order->id());
    }

    /** @test */
    public function store_order_billing_contact(): void
    {
        $client  = new OrderStoreMockClient();
        $service = new OrderService($client);

        $order = new Order();
        $order->billing()
            ->setContact(
                (new Contact())
                    ->setCompany('new company')
                    ->setEmail('new email')
                    ->setFirstName('new first name')
                    ->setLastName('new last name')
                    ->setTelephone('new telephone')
                    ->setWebsite('new website')
                    ->setVatIdNumber('NL000099998B57')
            );
        $order = $service->create($order);

        static::assertEquals(1, $order->id());

        static::assertEquals([
            'company'       => 'new company',
            'email'         => 'new email',
            'firstname'     => 'new first name',
            'lastname'      => 'new last name',
            'telephone'     => 'new telephone',
            'website'       => 'new website',
            'vat_id_number' => 'NL000099998B57',
        ], $client->requestBody()['billing']['contact']);
    }

    /** @test */
    public function store_order_billing_address(): void
    {
        $client  = new OrderStoreMockClient();
        $service = new OrderService($client);
        $service->include(OrderIncludes::BILLING);

        $order = $this->generateOrder();
        $order->billing()->setAddress((new Address())
            ->setCity('WooCity')
            ->setCountry(CountryCode::BE)
            ->setStreet('WooStreet')
            ->setHouseNumber('12')
            ->setZipcode('2233LL')
        );
        $order = $service->create($order);

        static::assertEquals('/v2/orders?include=billing', $client->path());
        static::assertEquals(1, $order->id());
        static::assertEquals([
            'city'        => 'WooCity',
            'country'     => 'BE',
            'housenumber' => '12',
            'street'      => 'WooStreet',
            'zipcode'     => '2233LL',
        ], $client->requestBody()['billing']['address']);
    }

    /** @test */
    public function create_order_with_validation_error(): void
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
        $service   = new OrderService($client);
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
    public function create_order_with_multiple_validation_errors(): void
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
        $service   = new OrderService($client);
        $exception = null;

        try {
            $service->find(1);
        } catch (ValidationException $exception) {
        }

        static::assertEquals('First error. Second error. Last error.', $exception->getMessage());
        static::assertEquals('First error.', $exception->errors()[0]->message());
        static::assertEquals('firstname', $exception->errors()[0]->field());
    }

    private function generateBilling(): OrderBilling
    {
        return (new OrderBilling())
            ->setAddress((new Address())->setCountry(CountryCode::NL))
            ->setContact((new Contact())
                ->setEmail('rosalie39@example.net')
                ->setFirstName('Bilal')
                ->setLastName('de Wit'));
    }

    private function generateOrder(): Order
    {
        $item = (new Item())->setLabel('the-label');

        return (new Order())
            ->setBilling($this->generateBilling())
            ->setItems([$item]);
    }
}
