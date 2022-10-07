<?php

namespace Feature\Subscription;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use PlugAndPay\Sdk\Director\ToBody\SubscriptionToBody;
use PlugAndPay\Sdk\Entity\Address;
use PlugAndPay\Sdk\Entity\Contact;
use PlugAndPay\Sdk\Entity\Discount;
use PlugAndPay\Sdk\Entity\Subscription;
use PlugAndPay\Sdk\Entity\SubscriptionBilling;
use PlugAndPay\Sdk\Entity\SubscriptionBillingSchedule;
use PlugAndPay\Sdk\Entity\SubscriptionPaymentOptions;
use PlugAndPay\Sdk\Entity\SubscriptionPricing;
use PlugAndPay\Sdk\Entity\Tax;
use PlugAndPay\Sdk\Enum\CountryCode;
use PlugAndPay\Sdk\Enum\Interval;
use PlugAndPay\Sdk\Enum\PaymentProvider;
use PlugAndPay\Sdk\Enum\PaymentType;
use PlugAndPay\Sdk\Enum\SubscriptionIncludes;
use PlugAndPay\Sdk\Exception\RelationNotLoadedException;
use PlugAndPay\Sdk\Service\SubscriptionService;
use PlugAndPay\Sdk\Tests\Feature\Subscription\Mock\SubscriptionStoreMockClient;

class StoreSubscriptionTest extends TestCase
{
    /**
     * @test
     * @throws RelationNotLoadedException
     */
    public function convert_basic_subscription_to_body(): void
    {
        $body = SubscriptionToBody::build($this->generateSubscription());

        static::assertEquals([
            'billing' => [
                'address'         => [
                    'country' => 'AL',
                ],
                'contact'         => [
                    'email'     => 'rosalie39@example.net',
                    'firstname' => 'Bilal',
                    'lastname'  => 'de Wit',
                ],
                'payment_options' => [
                    'type' => 'manual',
                ],
                'schedule'        => [
                    'next_at'  => '2022-01-01',
                    'interval' => 'monthly',
                ],
            ],
            'product' => [
                'id' => 8,
            ],
            'pricing' => [
                'tax' => [
                    'rate' => [
                        'id' => 1,
                    ],
                ],
            ],
        ], $body);
    }

    /**
     * @test
     * @throws RelationNotLoadedException
     */
    public function convert_subscription_pricing_to_body(): void
    {
        $tax = (new Tax())
            ->setAmount(21.00)
            ->setRateId(12);

        $pricing = (new SubscriptionPricing())
            ->setAmount(100.00)
            ->setAmountWithTax(120.00)
            ->setDiscounts([(new Discount())->setAmount(100.00)])
            ->setQuantity(10)
            ->setTax($tax)
            ->setIsTaxIncluded(false);

        $subscription = (new Subscription())
            ->setPricing($pricing);

        $body = SubscriptionToBody::build($subscription);

        static::assertEquals([
            'pricing' => [
                'amount'          => '100',
                'amount_with_tax' => '120',
                'discounts'       => [
                    [
                        'amount' => '100',
                    ],
                ],
                'quantity'        => 10,
                'tax'             => [
                    'amount' => 21,
                    'rate'   => [
                        'id' => 12,
                    ],
                ],
                'is_tax_included' => false,
            ],
        ], $body);
    }

    /**
     * @test
     * @throws RelationNotLoadedException
     */
    public function convert_subscription_product_to_body(): void
    {
        $subscription = (new Subscription())
            ->setProductId(1);

        $body = SubscriptionToBody::build($subscription);
        static::assertEquals([
            'product' => [
                'id' => 1,
            ],
        ], $body);
    }

    /**
     * @test
     * @throws RelationNotLoadedException
     */
    public function convert_subscription_billing_to_body(): void
    {
        $paymentOptions = (new SubscriptionPaymentOptions)
            ->setMandateId(1)
            ->setProvider(PaymentProvider::MOLLIE)
            ->setType(PaymentType::MANUAL);

        $schedule = (new SubscriptionBillingSchedule)
            ->setInterval(Interval::MONTHLY)
            ->setNext(1)
            ->setNextAt(new DateTimeImmutable('2022-05-01'))
            ->setRemaining(6)
            ->setTerminationAt(new DateTimeImmutable('2022-10-01'));

        $contact = (new Contact)
            ->setCompany('PP')
            ->setEmail('developer@pp.com')
            ->setFirstName('Lorem')
            ->setLastName('Ipsum')
            ->setTelephone('06-81475236')
            ->setVatIdNumber('123456789')
            ->setWebsite('https://www.plugandpay.nl');

        $address = (new Address)
            ->setCity('Lorem')
            ->setCountry(CountryCode::NL)
            ->setStreet('loremipsum')
            ->setHouseNumber('21')
            ->setZipcode('2121PP');

        $billing = (new SubscriptionBilling)
            ->setAddress($address)
            ->setContact($contact)
            ->setSchedule($schedule)
            ->setPaymentOptions($paymentOptions);

        $subscription = (new Subscription())
            ->setBilling($billing);

        $body = SubscriptionToBody::build($subscription);
        static::assertEquals([
            'billing' => [
                'address'         => [
                    'city'        => 'Lorem',
                    'country'     => 'NL',
                    'housenumber' => '21',
                    'street'      => 'loremipsum',
                    'zipcode'     => '2121PP',
                ],
                'contact'         => [
                    'company'       => 'PP',
                    'email'         => 'developer@pp.com',
                    'firstname'     => 'Lorem',
                    'lastname'      => 'Ipsum',
                    'telephone'     => '06-81475236',
                    'website'       => 'https://www.plugandpay.nl',
                    'vat_id_number' => '123456789',
                ],
                'schedule'        => [
                    'interval'       => 'monthly',
                    'next'           => 1,
                    'next_at'        => '2022-05-01',
                    'remaining'      => 6,
                    'termination_at' => '2022-10-01',
                ],
                'payment_options' => [
                    'mandate_id' => '1',
                    'provider'   => 'mollie',
                    'type'       => 'manual',
                ],
            ],
        ], $body);
    }

    /**
     * @test
     * @throws RelationNotLoadedException
     */
    public function convert_subscription_without_filled_subscription(): void
    {
        $body = SubscriptionToBody::build(new Subscription());

        static::assertEquals([], $body);
    }

    /** @test */
    public function store_basic_order(): void
    {
        $client  = new SubscriptionStoreMockClient();
        $service = new SubscriptionService($client);

        $subscription = $this->generateSubscription();
        $subscription = $service->create($subscription);

        static::assertEquals(1, $subscription->id());

        static::assertEquals('/v2/subscriptions', $client->path());
        static::assertEquals(1, $subscription->id());
    }

    /** @test */
    public function store_subscription_pricing(): void
    {
        $client  = new SubscriptionStoreMockClient();
        $service = new SubscriptionService($client);

        $tax = (new Tax())
            ->setAmount(21.00)
            ->setRateId(12);

        $pricing = (new SubscriptionPricing())
            ->setAmount(100.00)
            ->setAmountWithTax(120.00)
            ->setDiscounts([(new Discount())->setAmount(10.00)])
            ->setQuantity(10)
            ->setTax($tax)
            ->setIsTaxIncluded(false);

        $subscription = new Subscription();
        $subscription->setPricing($pricing);

        $subscription = $service->include(
            SubscriptionIncludes::PRICING
        )->create($subscription);
        static::assertEquals(1, $subscription->id());
        static::assertEquals([
            'amount'          => '100',
            'amount_with_tax' => '120',
            'discounts'       => [
                [
                    'amount' => '10',
                ],
            ],
            'quantity'        => 10,
            'tax'             => [
                'amount' => 21,
                'rate'   => [
                    'id' => 12,
                ],
            ],
            'is_tax_included' => false,
        ], $client->requestBody()['pricing']);
    }

    /** @test */
    public function store_subscription_product_pricing(): void
    {
        $client  = new SubscriptionStoreMockClient();
        $service = new SubscriptionService($client);

        $subscription = (new Subscription())
            ->setProductId(1);

        $subscription = $service->include(
            SubscriptionIncludes::PRODUCT,
        )->create($subscription);
        static::assertEquals(1, $subscription->id());
        static::assertEquals([
            'id' => 1,
        ], $client->requestBody()['product']);
    }

    /** @test */
    public function store_subscription_billing(): void
    {
        $client  = new SubscriptionStoreMockClient();
        $service = new SubscriptionService($client);

        $paymentOptions = (new SubscriptionPaymentOptions)
            ->setMandateId(1)
            ->setProvider(PaymentProvider::MOLLIE)
            ->setType(PaymentType::MANUAL);

        $schedule = (new SubscriptionBillingSchedule)
            ->setInterval(Interval::MONTHLY)
            ->setNext(1)
            ->setNextAt(new DateTimeImmutable('2022-05-01'))
            ->setRemaining(6)
            ->setTerminationAt(new DateTimeImmutable('2022-10-01'));

        $contact = (new Contact)
            ->setCompany('PP')
            ->setEmail('developer@pp.com')
            ->setFirstName('Lorem')
            ->setLastName('Ipsum')
            ->setTelephone('06-81475236')
            ->setVatIdNumber('123456789')
            ->setWebsite('https://www.plugandpay.nl');

        $address = (new Address)
            ->setCity('Lorem')
            ->setCountry(CountryCode::NL)
            ->setStreet('loremipsum')
            ->setHouseNumber('21')
            ->setZipcode('2121PP');

        $billing = (new SubscriptionBilling)
            ->setAddress($address)
            ->setContact($contact)
            ->setSchedule($schedule)
            ->setPaymentOptions($paymentOptions);

        $subscription = (new Subscription())
            ->setBilling($billing);

        $subscription = $service->include(
            SubscriptionIncludes::BILLING,
        )->create($subscription);

        static::assertEquals(1, $subscription->id());
        static::assertEquals([
            'address'         => [
                'city'        => 'Lorem',
                'country'     => 'NL',
                'housenumber' => '21',
                'street'      => 'loremipsum',
                'zipcode'     => '2121PP',
            ],
            'contact'         => [
                'company'       => 'PP',
                'email'         => 'developer@pp.com',
                'firstname'     => 'Lorem',
                'lastname'      => 'Ipsum',
                'telephone'     => '06-81475236',
                'website'       => 'https://www.plugandpay.nl',
                'vat_id_number' => '123456789',
            ],
            'schedule'        => [
                'next'           => 1,
                'next_at'        => '2022-05-01',
                'remaining'      => 6,
                'termination_at' => '2022-10-01',
                'interval'       => 'monthly',
            ],
            'payment_options' => [
                'mandate_id' => '1',
                'type'       => 'manual',
                'provider'   => 'mollie',
            ],
        ], $client->requestBody()['billing']);
    }

    /** @test */
    public function store_subscription_tags(): void
    {
        $client  = new SubscriptionStoreMockClient();
        $service = new SubscriptionService($client);

        $tags = ['first', 'second', 'third'];

        $subscription = (new Subscription())
            ->setTags($tags);

        $subscription = $service->include(
            SubscriptionIncludes::TAGS,
        )->create($subscription);
        static::assertEquals(1, $subscription->id());
        static::assertEquals([
            0 => 'first',
            1 => 'second',
            2 => 'third',
        ], $client->requestBody()['tags']);
    }

    private function generateSubscription(): Subscription
    {
        return (new Subscription())
            ->setProductId(8)
            ->setPricing(
                (new SubscriptionPricing)
                    ->setTax(
                        (new Tax)->setRateId(1)
                    )
            )
            ->setBilling(
                (new SubscriptionBilling())
                    ->setAddress(
                        (new Address)
                            ->setCountry(CountryCode::AL)
                    )
                    ->setContact(
                        (new Contact)
                            ->setFirstName('Bilal')
                            ->setLastName('de Wit')
                            ->setEmail('rosalie39@example.net')
                    )
                    ->setPaymentOptions(
                        (new SubscriptionPaymentOptions())
                            ->setType(PaymentType::MANUAL)
                    )
                    ->setSchedule(
                        (new SubscriptionBillingSchedule())
                            ->setNextAt(new DateTimeImmutable('2022-01-01'))
                            ->setInterval(Interval::MONTHLY)
                    )
            );
    }
}
