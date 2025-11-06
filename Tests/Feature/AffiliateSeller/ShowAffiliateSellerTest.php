<?php

/** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

namespace PlugAndPay\Sdk\Tests\Feature\AffiliateSeller;

use BadFunctionCallException;
use PHPUnit\Framework\TestCase;
use PlugAndPay\Sdk\Entity\AffiliateSeller;
use PlugAndPay\Sdk\Entity\Response;
use PlugAndPay\Sdk\Entity\SellerPayoutOptions;
use PlugAndPay\Sdk\Entity\SellerStatistics;
use PlugAndPay\Sdk\Enum\AffiliateSellerIncludes;
use PlugAndPay\Sdk\Enum\CountryCode;
use PlugAndPay\Sdk\Enum\SellerStatus;
use PlugAndPay\Sdk\Exception\NotFoundException;
use PlugAndPay\Sdk\Exception\RelationNotLoadedException;
use PlugAndPay\Sdk\Exception\UnauthenticatedException;
use PlugAndPay\Sdk\Service\AffiliateSellerService;
use PlugAndPay\Sdk\Tests\Feature\AffiliateSeller\Mock\AffiliateSellerShowMockClient;
use PlugAndPay\Sdk\Tests\Feature\ClientMock;

class ShowAffiliateSellerTest extends TestCase
{
    /** @test */
    public function show_basic_seller(): void
    {
        $client  = new AffiliateSellerShowMockClient(['id' => 1]);
        $service = new AffiliateSellerService($client);

        $seller = $service->find(1);

        static::assertSame(1, $seller->id());
        static::assertSame('John Doe', $seller->name());
        static::assertSame('john@example.com', $seller->email());
        static::assertSame('', $seller->declineReason());
        static::assertSame(1, $seller->profileId());
        static::assertSame(SellerStatus::ACCEPTED, $seller->status());
        static::assertSame('/v2/affiliates/sellers/1', $client->path());
    }

    /**
     * @test
     * @dataProvider relationsProvider
     */
    public function show_none_loaded_relationships(string $relation): void
    {
        $exception = null;

        try {
            (new AffiliateSeller(false))->{$relation}();
        } catch (RelationNotLoadedException $exception) {
        }

        static::assertInstanceOf(RelationNotLoadedException::class, $exception);
    }

    /**
     * Data provider for show_none_loaded_relationships.
     */
    public static function relationsProvider(): array
    {
        return [
            'address'        => ['address'],
            'contact'        => ['contact'],
            'profile'        => ['profile'],
            'statistics'     => ['statistics'],
            'payoutOptions'  => ['payoutOptions'],
            'payoutMethods'  => ['payoutMethods'],
        ];
    }

    /** @test */
    public function show_not_existing_seller(): void
    {
        $client    = new ClientMock(Response::HTTP_NOT_FOUND);
        $service   = new AffiliateSellerService($client);
        $exception = null;

        try {
            $service->find(999);
        } catch (NotFoundException $exception) {
        }

        static::assertEquals('Not found', $exception->getMessage());
    }

    /** @test */
    public function show_unauthorized_seller(): void
    {
        $client    = new ClientMock(Response::HTTP_UNAUTHORIZED);
        $service   = new AffiliateSellerService($client);
        $exception = null;

        try {
            $service->find(999);
        } catch (UnauthenticatedException $exception) {
        }

        static::assertEquals('Unable to connect with Plug&Pay. Request is unauthenticated.', $exception->getMessage());
    }

    /** @test */
    public function show_seller_with_address(): void
    {
        $client  = (new AffiliateSellerShowMockClient())->address();
        $service = new AffiliateSellerService($client);

        $seller = $service->include(AffiliateSellerIncludes::ADDRESS)->find(1);

        $address = $seller->address();
        static::assertSame('New York', $address->city());
        static::assertSame(CountryCode::US, $address->country());
        static::assertSame('Main St', $address->street());
        static::assertSame('123', $address->houseNumber());
        static::assertSame('10001', $address->zipcode());
        static::assertSame('/v2/affiliates/sellers/1?include=address', $client->path());
    }

    /** @test */
    public function show_seller_with_contact(): void
    {
        $client  = (new AffiliateSellerShowMockClient())->contact();
        $service = new AffiliateSellerService($client);

        $seller = $service->include(AffiliateSellerIncludes::CONTACT)->find(1);

        $contact = $seller->contact();
        static::assertSame('ACME Corp', $contact->company());
        static::assertSame('john@example.com', $contact->email());
        static::assertSame('John', $contact->firstName());
        static::assertSame('Doe', $contact->lastName());
        static::assertSame('+1234567890', $contact->telephone());
        static::assertSame('https://example.com', $contact->website());
        static::assertSame('/v2/affiliates/sellers/1?include=contact', $client->path());
    }

    /** @test */
    public function show_seller_with_profile(): void
    {
        $client  = (new AffiliateSellerShowMockClient())->profile();
        $service = new AffiliateSellerService($client);

        $seller = $service->include(AffiliateSellerIncludes::PROFILE)->find(1);

        $profile = $seller->profile();
        static::assertSame(1, $profile->id());
        static::assertSame('/v2/affiliates/sellers/1?include=profile', $client->path());
    }

    /** @test */
    public function show_seller_with_statistics(): void
    {
        $client  = (new AffiliateSellerShowMockClient())->statistics();
        $service = new AffiliateSellerService($client);

        $seller = $service->include(AffiliateSellerIncludes::STATISTICS)->find(1);

        $statistics = $seller->statistics();
        static::assertInstanceOf(SellerStatistics::class, $statistics);
        static::assertSame('/v2/affiliates/sellers/1?include=statistics', $client->path());
    }

    /** @test */
    public function show_seller_with_payout_options(): void
    {
        $client  = (new AffiliateSellerShowMockClient())->payoutOptions();
        $service = new AffiliateSellerService($client);

        $seller = $service->include(AffiliateSellerIncludes::PAYOUT_OPTIONS)->find(1);

        $payoutOptions = $seller->payoutOptions();
        static::assertInstanceOf(SellerPayoutOptions::class, $payoutOptions);
        static::assertSame('/v2/affiliates/sellers/1?include=payout_options', $client->path());
    }

    /** @test */
    public function show_seller_statistics_with_values(): void
    {
        $client  = (new AffiliateSellerShowMockClient())->statistics([
            'clicks'     => 150,
            'commission' => 2500,
            'locked'     => 750,
            'orders'     => 42,
            'paidout'    => 10000,
            'pending'    => 1250,
            'recurring'  => 3500,
            'sales'      => 55,
            'value'      => 15000,
        ]);
        $service = new AffiliateSellerService($client);

        $seller = $service->include(AffiliateSellerIncludes::STATISTICS)->find(1);

        $statistics = $seller->statistics();
        static::assertSame(150, $statistics->clicks());
        static::assertSame(2500, $statistics->commission());
        static::assertSame(750, $statistics->locked());
        static::assertSame(42, $statistics->orders());
        static::assertSame(10000, $statistics->paidout());
        static::assertSame(1250, $statistics->pending());
        static::assertSame(3500, $statistics->recurring());
        static::assertSame(55, $statistics->sales());
        static::assertSame(15000, $statistics->value());
    }

    /** @test */
    public function show_seller_statistics_with_null_clicks(): void
    {
        $client  = (new AffiliateSellerShowMockClient())->statistics([
            'clicks' => null,
        ]);
        $service = new AffiliateSellerService($client);

        $seller = $service->include(AffiliateSellerIncludes::STATISTICS)->find(1);

        $statistics = $seller->statistics();
        static::assertNull($statistics->clicks());
    }

    /** @test */
    public function show_seller_profile_with_custom_id(): void
    {
        $client  = (new AffiliateSellerShowMockClient())->profile([
            'id' => 42,
        ]);
        $service = new AffiliateSellerService($client);

        $seller = $service->include(AffiliateSellerIncludes::PROFILE)->find(1);

        $profile = $seller->profile();
        static::assertSame(42, $profile->id());
    }

    /** @test */
    public function test_seller_statistics_isset_for_existing_property(): void
    {
        $client  = (new AffiliateSellerShowMockClient())->statistics([
            'clicks'     => 100,
            'commission' => 500,
            'locked'     => 200,
            'orders'     => 10,
            'paidout'    => 1000,
            'pending'    => 300,
            'recurring'  => 400,
            'sales'      => 15,
            'value'      => 2000,
        ]);
        $service = new AffiliateSellerService($client);

        $seller = $service->include(AffiliateSellerIncludes::STATISTICS)->find(1);

        $statistics = $seller->statistics();
        static::assertTrue($statistics->isset('clicks'));
        static::assertTrue($statistics->isset('commission'));
        static::assertTrue($statistics->isset('locked'));
        static::assertTrue($statistics->isset('orders'));
        static::assertTrue($statistics->isset('paidout'));
        static::assertTrue($statistics->isset('pending'));
        static::assertTrue($statistics->isset('recurring'));
        static::assertTrue($statistics->isset('sales'));
        static::assertTrue($statistics->isset('value'));
    }

    /** @test */
    public function test_seller_payout_options_isset(): void
    {
        $client  = (new AffiliateSellerShowMockClient())->payoutOptions();
        $service = new AffiliateSellerService($client);

        $seller = $service->include(AffiliateSellerIncludes::PAYOUT_OPTIONS)->find(1);

        $payoutOptions = $seller->payoutOptions();
        static::assertInstanceOf(SellerPayoutOptions::class, $payoutOptions);
    }

    /** @test */
    public function show_seller_payout_options_with_default_data(): void
    {
        $client  = (new AffiliateSellerShowMockClient())->payoutOptions();
        $service = new AffiliateSellerService($client);

        $seller = $service->include(AffiliateSellerIncludes::PAYOUT_OPTIONS)->find(1);

        $payoutOptions = $seller->payoutOptions();
        static::assertSame('paypal', $payoutOptions->method());

        $settings = $payoutOptions->settings();
        static::assertIsArray($settings);
        static::assertSame('oramcharan@example.com', $settings['email']);
        static::assertSame('+3177 4223366', $settings['phone']);
        static::assertSame('https://paypal.me/lopes.jennifer', $settings['paypal_me_link']);
    }

    /** @test */
    public function show_seller_payout_options_with_custom_method(): void
    {
        $client  = (new AffiliateSellerShowMockClient())->payoutOptions([
            'method' => 'bank_transfer',
        ]);
        $service = new AffiliateSellerService($client);

        $seller = $service->include(AffiliateSellerIncludes::PAYOUT_OPTIONS)->find(1);

        $payoutOptions = $seller->payoutOptions();
        static::assertSame('bank_transfer', $payoutOptions->method());
    }

    /** @test */
    public function show_seller_payout_options_with_custom_settings(): void
    {
        $client  = (new AffiliateSellerShowMockClient())->payoutOptions([
            'method'   => 'paypal',
            'settings' => [
                'email'          => 'custom@example.com',
                'phone'          => '+31612345678',
                'paypal_me_link' => 'https://paypal.me/custom.user',
            ],
        ]);
        $service = new AffiliateSellerService($client);

        $seller = $service->include(AffiliateSellerIncludes::PAYOUT_OPTIONS)->find(1);

        $payoutOptions = $seller->payoutOptions();
        $settings      = $payoutOptions->settings();
        static::assertSame('custom@example.com', $settings['email']);
        static::assertSame('+31612345678', $settings['phone']);
        static::assertSame('https://paypal.me/custom.user', $settings['paypal_me_link']);
    }

    /** @test */
    public function show_seller_payout_options_settings_fields(): void
    {
        $client  = (new AffiliateSellerShowMockClient())->payoutOptions();
        $service = new AffiliateSellerService($client);

        $seller = $service->include(AffiliateSellerIncludes::PAYOUT_OPTIONS)->find(1);

        $payoutOptions = $seller->payoutOptions();
        static::assertTrue($payoutOptions->isset('method'));
        static::assertTrue($payoutOptions->isset('settings'));
    }

    /** @test */
    public function test_isset_with_non_existent_field_throws_exception(): void
    {
        $client  = (new AffiliateSellerShowMockClient())->statistics();
        $service = new AffiliateSellerService($client);

        $seller = $service->include(AffiliateSellerIncludes::STATISTICS)->find(1);

        $this->expectException(BadFunctionCallException::class);
        $this->expectExceptionMessage("Field 'nonExistentField' does not exists");
        $statistics = $seller->statistics();
        $statistics->isset('nonExistentField');
    }

    /** @test */
    public function show_seller_with_payout_methods(): void
    {
        $client  = (new AffiliateSellerShowMockClient())->payoutMethods();
        $service = new AffiliateSellerService($client);

        $seller = $service->include(AffiliateSellerIncludes::PAYOUT_METHODS)->find(1);

        $payoutMethods = $seller->payoutMethods();
        static::assertIsArray($payoutMethods);
        static::assertCount(1, $payoutMethods);
        static::assertSame(1, $payoutMethods[0]->id());
        static::assertSame('bank_transfer', $payoutMethods[0]->method());
        static::assertIsArray($payoutMethods[0]->settings());
        static::assertSame('NL91ABNA0417164300', $payoutMethods[0]->settings()['iban']);
        static::assertSame('ABNANL2A', $payoutMethods[0]->settings()['bic']);
        static::assertSame('/v2/affiliates/sellers/1?include=payout_methods', $client->path());
    }

    /** @test */
    public function show_seller_payout_methods_with_bank_transfer(): void
    {
        $client  = (new AffiliateSellerShowMockClient())->payoutMethods([
            [
                'id'       => 2,
                'method'   => 'bank_transfer',
                'settings' => [
                    'iban' => 'DE89370400440532013000',
                    'bic'  => 'COBADEFFXXX',
                ],
                'created_at' => '2024-01-01T00:00:00.000000Z',
                'updated_at' => '2024-01-01T00:00:00.000000Z',
            ],
        ]);
        $service = new AffiliateSellerService($client);

        $seller = $service->find(1);

        $payoutMethods = $seller->payoutMethods();
        static::assertCount(1, $payoutMethods);
        static::assertSame(2, $payoutMethods[0]->id());
        static::assertSame('bank_transfer', $payoutMethods[0]->method());
        static::assertSame('DE89370400440532013000', $payoutMethods[0]->settings()['iban']);
        static::assertSame('COBADEFFXXX', $payoutMethods[0]->settings()['bic']);
    }

    /** @test */
    public function show_seller_payout_methods_empty_array(): void
    {
        $client  = (new AffiliateSellerShowMockClient())->payoutMethods([]);
        $service = new AffiliateSellerService($client);

        $seller = $service->find(1);

        $payoutMethods = $seller->payoutMethods();
        static::assertIsArray($payoutMethods);
        static::assertCount(0, $payoutMethods);
    }

    /** @test */
    public function show_seller_payout_methods_multiple(): void
    {
        $client  = (new AffiliateSellerShowMockClient())->payoutMethods([
            [
                'id'       => 1,
                'method'   => 'bank_transfer',
                'settings' => [
                    'iban' => 'NL91ABNA0417164300',
                    'bic'  => 'ABNANL2A',
                ],
                'created_at' => '2024-01-01T00:00:00.000000Z',
                'updated_at' => '2024-01-01T00:00:00.000000Z',
            ],
            [
                'id'       => 2,
                'method'   => 'paypal',
                'settings' => [
                    'email' => 'seller@example.com',
                ],
                'created_at' => '2024-01-02T00:00:00.000000Z',
                'updated_at' => '2024-01-02T00:00:00.000000Z',
            ],
        ]);
        $service = new AffiliateSellerService($client);

        $seller = $service->find(1);

        $payoutMethods = $seller->payoutMethods();
        static::assertCount(2, $payoutMethods);

        static::assertSame(1, $payoutMethods[0]->id());
        static::assertSame(2, $payoutMethods[1]->id());
    }
}
