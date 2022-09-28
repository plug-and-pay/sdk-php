<?php

namespace Feature\Subscription;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use PlugAndPay\Sdk\Director\ToBody\SubscriptionToBody;
use PlugAndPay\Sdk\Entity\Address;
use PlugAndPay\Sdk\Entity\Contact;
use PlugAndPay\Sdk\Entity\Product;
use PlugAndPay\Sdk\Entity\Subscription;
use PlugAndPay\Sdk\Entity\SubscriptionBilling;
use PlugAndPay\Sdk\Entity\SubscriptionBillingSchedule;
use PlugAndPay\Sdk\Entity\SubscriptionPaymentOptions;
use PlugAndPay\Sdk\Entity\SubscriptionPricing;
use PlugAndPay\Sdk\Entity\Tax;
use PlugAndPay\Sdk\Entity\TaxRate;
use PlugAndPay\Sdk\Enum\CountryCode;
use PlugAndPay\Sdk\Enum\Interval;
use PlugAndPay\Sdk\Enum\PaymentType;

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