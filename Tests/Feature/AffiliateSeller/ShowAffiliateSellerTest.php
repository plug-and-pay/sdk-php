<?php

/** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

namespace PlugAndPay\Sdk\Tests\Feature\AffiliateSeller;

use PHPUnit\Framework\TestCase;
use PlugAndPay\Sdk\Entity\Response;
use PlugAndPay\Sdk\Enum\AffiliateSellerIncludes;
use PlugAndPay\Sdk\Enum\CountryCode;
use PlugAndPay\Sdk\Enum\SellerStatus;
use PlugAndPay\Sdk\Exception\NotFoundException;
use PlugAndPay\Sdk\Exception\UnauthenticatedException;
use PlugAndPay\Sdk\Service\AffiliateSellerService;
use PlugAndPay\Sdk\Tests\Feature\ClientMock;
use PlugAndPay\Sdk\Tests\Feature\AffiliateSeller\Mock\AffiliateSellerShowMockClient;

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
            (new \PlugAndPay\Sdk\Entity\AffiliateSeller(false))->{$relation}();
        } catch (\PlugAndPay\Sdk\Exception\RelationNotLoadedException $exception) {
        }

        static::assertInstanceOf(\PlugAndPay\Sdk\Exception\RelationNotLoadedException::class, $exception);
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
        static::assertInstanceOf(\PlugAndPay\Sdk\Entity\SellerStatistics::class, $statistics);
        static::assertSame('/v2/affiliates/sellers/1?include=statistics', $client->path());
    }

    /** @test */
    public function show_seller_with_payout_options(): void
    {
        $client  = (new AffiliateSellerShowMockClient())->payoutOptions();
        $service = new AffiliateSellerService($client);

        $seller = $service->include(AffiliateSellerIncludes::PAYOUT_OPTIONS)->find(1);

        $payoutOptions = $seller->payoutOptions();
        static::assertInstanceOf(\PlugAndPay\Sdk\Entity\SellerPayoutOptions::class, $payoutOptions);
        static::assertSame('/v2/affiliates/sellers/1?include=payout_options', $client->path());
    }
}