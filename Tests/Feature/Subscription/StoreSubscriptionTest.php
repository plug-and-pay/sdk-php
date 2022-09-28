<?php

namespace Feature\Subscription;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use PlugAndPay\Sdk\Director\ToBody\SubscriptionToBody;
use PlugAndPay\Sdk\Entity\Address;
use PlugAndPay\Sdk\Entity\Contact;
use PlugAndPay\Sdk\Entity\Price;
use PlugAndPay\Sdk\Entity\PriceFirst;
use PlugAndPay\Sdk\Entity\PriceOriginal;
use PlugAndPay\Sdk\Entity\PriceRegular;
use PlugAndPay\Sdk\Entity\PriceTier;
use PlugAndPay\Sdk\Entity\Product;
use PlugAndPay\Sdk\Entity\ProductPricing;
use PlugAndPay\Sdk\Entity\Subscription;
use PlugAndPay\Sdk\Entity\SubscriptionBilling;
use PlugAndPay\Sdk\Entity\SubscriptionBillingSchedule;
use PlugAndPay\Sdk\Entity\SubscriptionPaymentOptions;
use PlugAndPay\Sdk\Entity\SubscriptionPricing;
use PlugAndPay\Sdk\Entity\SubscriptionTrial;
use PlugAndPay\Sdk\Entity\Tax;
use PlugAndPay\Sdk\Entity\TaxRate;
use PlugAndPay\Sdk\Enum\CountryCode;
use PlugAndPay\Sdk\Enum\Interval;
use PlugAndPay\Sdk\Enum\PaymentProvider;
use PlugAndPay\Sdk\Enum\PaymentType;
use PlugAndPay\Sdk\Enum\SubscriptionIncludes;
use PlugAndPay\Sdk\Enum\Type;
use PlugAndPay\Sdk\Service\SubscriptionService;
use PlugAndPay\Sdk\Tests\Feature\Subscription\Mock\SubscriptionStoreMockClient;

class StoreSubscriptionTest extends TestCase
{
    /** @test */
    public function convert_basic_subscription_to_body(): void
    {
        $body = SubscriptionToBody::build($this->generateSubscription());

        static::assertEquals([
            'source'  => 'api',
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
                    'type' => 'manual'
                ],
                'schedule'        => [
                    'next_at'  => '2022-01-01',
                    'interval' => 'monthly',
                ]
            ],
            'product' => [
                'id' => 8
            ],
            'pricing' => [
                'tax' => [
                    'rate' => [
                        'id' => 1
                    ]
                ]
            ]
        ], $body);
    }

    /** @test */
    public function convert_subscription_pricing_to_body(): void
    {
        $taxRate = (new TaxRate)
            ->setCountry(CountryCode::AL)
            ->setPercentage(21.00);

        $tax = (new Tax())
            ->setAmount(21.00)
            ->setRate($taxRate);

        $pricing = (new SubscriptionPricing())
            ->setAmount('100.00')
            ->setAmountWithTax('120.00')
            ->setDiscounts(['10.00'])
            ->setQuantity(10)
            ->setTax($tax)
            ->setIsTaxIncluded(false);

        $subscription = (new Subscription())
            ->setPricing($pricing);

        $body = SubscriptionToBody::build($subscription);

        static::assertEquals([
            'pricing' => [
                'amount'          => '100.00',
                'amount_with_tax' => '120.00',
                'discounts'       => [
                    0 => '10.00',
                ],
                'quantity'        => 10,
                'tax'             => [
                    'rate' => [],
                ],
                'is_tax_included' => false,
            ],
            'source'  => 'api',
        ], $body);
    }

    /** @test */
    public function convert_subscription_product_to_body(): void
    {
        $priceTiers = (new PriceTier)
            ->setAmount(10.00)
            ->setAmountWithTax(12.10)
            ->setQuantity(10);

        $priceRegular = (new PriceRegular)
            ->setAmount(100)
            ->setAmountWithTax(121.00);

        $priceOriginal = (new PriceOriginal)
            ->setAmount(200.00)
            ->setAmountWithTax(242.00);

        $priceFirst = (new PriceFirst)
            ->setAmount(100.00)
            ->setAmountWithTax(121.00);

        $price = (new Price)
            ->setId(1)
            ->setFirst($priceFirst)
            ->setInterval(Interval::MONTHLY)
            ->setSuggested(false)
            ->setNrOfCycles(10)
            ->setOriginal($priceOriginal)
            ->setRegular($priceRegular)
            ->setTiers([$priceTiers]);

        $pricing = (new ProductPricing)
            ->setTaxIncluded(true)
            ->setPrices([$price]);

        $product = (new Product())
            ->setId(1)
            ->setTitle('Lorem')
            ->setDescription('Lorem Ipsum')
            ->setPhysical(false)
            ->setLedger(123)
            ->setPublicTitle('lorem')
            ->setSku('123456-GE')
            ->setSlug('lorem')
            ->setType(Type::SUBSCRIPTION)
            ->setPricing($pricing);

        $subscription = (new Subscription())
            ->setProduct($product);

        $body = SubscriptionToBody::build($subscription);
        static::assertEquals([
            'product' => [
                'id'           => 1,
                'title'        => 'Lorem',
                "description"  => "Lorem Ipsum",
                'is_physical'  => false,
                'ledger'       => 123,
                'public_title' => "lorem",
                'sku'          => "123456-GE",
                'slug'         => "lorem",
                'type'         => "subscription",
                'pricing'      => [
                    'is_tax_included' => true,
                    'prices'          => [
                        0 => [
                            'is_suggested' => false,
                            'interval'     => 'monthly',
                            'nr_of_cycles' => 10,
                            'first'        => [
                                'amount'          => 100.0,
                                'amount_with_tax' => 121.0,
                            ],
                            'original'     => [
                                'amount'          => 200.0,
                                'amount_with_tax' => 242.0,
                            ],
                            "tiers"        => [
                                0 => [
                                    "amount"          => 10.0,
                                    "amount_with_tax" => 12.1,
                                    "quantity"        => 10
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            'source'  => 'api'
        ], $body);
    }

    /** @test */
    public function convert_subscription_billing_to_body(): void
    {
        $paymentOptions = (new SubscriptionPaymentOptions)
            ->setCustomerId(1)
            ->setMandateId(1)
            ->setProvider(PaymentProvider::MOLLIE)
            ->setTransactionId(10)
            ->setType(PaymentType::MANUAL);

        $schedule = (new SubscriptionBillingSchedule)
            ->setInterval(Interval::MONTHLY)
            ->setLast(1)
            ->setLastAt(new DateTimeImmutable('2022-01-01'))
            ->setLatest(1)
            ->setLatestAt(new DateTimeImmutable('2022-04-01'))
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
                    'last'           => 1,
                    'last_at'        => '2022-01-01',
                    'latest'         => 1,
                    'latest_at'      => '2022-04-01',
                    'next'           => 1,
                    'next_at'        => '2022-05-01',
                    'remaining'      => 6,
                    'termination_at' => '2022-10-01',
                ],
                'payment_options' => [
                    'customer_id'    => 1,
                    'mandate_id'     => 1,
                    'provider'       => 'mollie',
                    'transaction_id' => 10,
                    'type'           => 'manual',
                ],
            ],
            'source'  => 'api'
        ], $body);
    }

    /** @test */
    public function convert_subscription_trial_to_body(): void
    {
        $trial = (new SubscriptionTrial)
            ->setEndDate(new DateTimeImmutable('2022-12-01'))
            ->setIsActive(1)
            ->setStartDate(new DateTimeImmutable('2022-01-01'));

        $subscription = (new Subscription())
            ->setTrial($trial);

        $body = SubscriptionToBody::build($subscription);
        static::assertEquals([
            'trial'  => [
                'end'       => '2022-12-01',
                'is_active' => true,
                'start'     => '2022-01-01',
            ],
            'source' => 'api',
        ], $body);
    }

    /** @test */
    public function convert_subscription_without_filled_subscription(): void
    {
        $body = SubscriptionToBody::build(new Subscription());

        static::assertEquals(['source' => 'api'], $body);
    }

    /** @test */
    public function store_basic_order(): void
    {
        $client = new SubscriptionStoreMockClient();
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
        $client = new SubscriptionStoreMockClient();
        $service = new SubscriptionService($client);

        $taxRate = (new TaxRate)
            ->setCountry(CountryCode::AL)
            ->setPercentage(21.00);

        $tax = (new Tax())
            ->setAmount(21.00)
            ->setRate($taxRate);

        $pricing = (new SubscriptionPricing())
            ->setAmount('100.00')
            ->setAmountWithTax('120.00')
            ->setDiscounts(['10.00'])
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
            'amount'          => '100.00',
            'amount_with_tax' => '120.00',
            'discounts'       => [
                0 => '10.00'
            ],
            'quantity'        => 10,
            'tax'             => [
                'rate' => []
            ],
            'is_tax_included' => false,
        ], $client->requestBody()['pricing']);
    }

    /** @test */
    public function store_subscription_product_pricing(): void
    {
        $client = new SubscriptionStoreMockClient();
        $service = new SubscriptionService($client);

        $priceTiers = (new PriceTier)
            ->setAmount(10.00)
            ->setAmountWithTax(12.10)
            ->setQuantity(10);

        $priceRegular = (new PriceRegular)
            ->setAmount(100)
            ->setAmountWithTax(121.00);

        $priceOriginal = (new PriceOriginal)
            ->setAmount(200.00)
            ->setAmountWithTax(242.00);

        $priceFirst = (new PriceFirst)
            ->setAmount(100.00)
            ->setAmountWithTax(121.00);

        $price = (new Price)
            ->setId(1)
            ->setFirst($priceFirst)
            ->setInterval(Interval::MONTHLY)
            ->setSuggested(false)
            ->setNrOfCycles(10)
            ->setOriginal($priceOriginal)
            ->setRegular($priceRegular)
            ->setTiers([$priceTiers]);

        $pricing = (new ProductPricing)
            ->setTaxIncluded(true)
            ->setPrices([$price]);

        $product = (new Product())
            ->setId(1)
            ->setTitle('Lorem')
            ->setDescription('Lorem Ipsum')
            ->setPhysical(false)
            ->setLedger(123)
            ->setPublicTitle('lorem')
            ->setSku('123456-GE')
            ->setSlug('lorem')
            ->setType(Type::SUBSCRIPTION)
            ->setPricing($pricing);

        $subscription = (new Subscription())
            ->setProduct($product);

        $subscription = $service->include(
            SubscriptionIncludes::PRODUCT,
        )->create($subscription);
        static::assertEquals(1, $subscription->id());
        static::assertEquals([
            'id'           => 1,
            'title'        => 'Lorem',
            'description'  => 'Lorem Ipsum',
            'is_physical'  => false,
            'ledger'       => 123,
            'public_title' => 'lorem',
            'sku'          => '123456-GE',
            'slug'         => 'lorem',
            'type'         => 'subscription',
            'pricing'      => [
                'is_tax_included' => true,
                'prices'          => [
                    0 => [
                        'is_suggested' => false,
                        'interval'     => 'monthly',
                        'nr_of_cycles' => 10,
                        'first'        => [
                            'amount'          => 100.0,
                            'amount_with_tax' => 121.0,
                        ],
                        'original'     => [
                            'amount'          => 200.0,
                            'amount_with_tax' => 242.0,
                        ],
                        'tiers'        => [
                            0 => [
                                'amount'          => 10.0,
                                'amount_with_tax' => 12.1,
                                'quantity'        => 10,
                            ],
                        ],
                    ],
                ],
            ]
        ], $client->requestBody()['product']);
    }

    /** @test */
    public function store_subscription_billing(): void
    {
        $client = new SubscriptionStoreMockClient();
        $service = new SubscriptionService($client);

        $paymentOptions = (new SubscriptionPaymentOptions)
            ->setCustomerId(1)
            ->setMandateId(1)
            ->setProvider(PaymentProvider::MOLLIE)
            ->setTransactionId(10)
            ->setType(PaymentType::MANUAL);

        $schedule = (new SubscriptionBillingSchedule)
            ->setInterval(Interval::MONTHLY)
            ->setLast(1)
            ->setLastAt(new DateTimeImmutable('2022-01-01'))
            ->setLatest(1)
            ->setLatestAt(new DateTimeImmutable('2022-04-01'))
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
                'interval'       => 'monthly',
                'last'           => 1,
                'last_at'        => '2022-01-01',
                'latest'         => 1,
                'latest_at'      => '2022-04-01',
                'next'           => 1,
                'next_at'        => '2022-05-01',
                'remaining'      => 6,
                'termination_at' => '2022-10-01',
            ],
            'payment_options' => [
                'customer_id'    => 1,
                'mandate_id'     => 1,
                'provider'       => 'mollie',
                'transaction_id' => 10,
                'type'           => 'manual',
            ],
        ], $client->requestBody()['billing']);
    }

    /** @test */
    public function store_subscription_tags(): void
    {
        $client = new SubscriptionStoreMockClient();
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

    /** @test */
    public function store_subscription_trial(): void
    {
        $client = new SubscriptionStoreMockClient();
        $service = new SubscriptionService($client);

        $trial = (new SubscriptionTrial)
            ->setEndDate(new DateTimeImmutable('2022-12-01'))
            ->setIsActive(1)
            ->setStartDate(new DateTimeImmutable('2022-01-01'));

        $subscription = (new Subscription())
            ->setTrial($trial);

        $subscription = $service->include(
            SubscriptionIncludes::TRIAL,
        )->create($subscription);
        static::assertEquals(1, $subscription->id());
        static::assertEquals([
            'end'       => '2022-12-01',
            'is_active' => true,
            'start'     => '2022-01-01',
        ], $client->requestBody()['trial']);
    }

    private function generateSubscription(): Subscription
    {
        return (new Subscription())
            ->setProduct(
                (new Product)
                    ->setId(8)
            )
            ->setPricing(
                (new SubscriptionPricing)
                    ->setTax(
                        (new Tax)
                            ->setRate(
                                (new TaxRate)
                                    ->setId(1)
                            )
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