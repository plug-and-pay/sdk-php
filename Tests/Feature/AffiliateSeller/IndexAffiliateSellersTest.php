<?php

/** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

namespace PlugAndPay\Sdk\Tests\Feature\AffiliateSeller;

use DateTime;
use PHPUnit\Framework\TestCase;
use PlugAndPay\Sdk\Enum\AffiliateSellerIncludes;
use PlugAndPay\Sdk\Enum\Direction;
use PlugAndPay\Sdk\Enum\SellerSortType;
use PlugAndPay\Sdk\Enum\SellerStatus;
use PlugAndPay\Sdk\Filters\AffiliateSellerFilter;
use PlugAndPay\Sdk\Service\AffiliateSellerService;
use PlugAndPay\Sdk\Tests\Feature\AffiliateSeller\Mock\AffiliateSellerIndexMockClient;

class IndexAffiliateSellersTest extends TestCase
{
    /**
     * @test
     * @dataProvider relationsProvider
     */
    public function index_sellers_with_relations(AffiliateSellerIncludes $include, string $includeValue): void
    {
        $client  = (new AffiliateSellerIndexMockClient());
        $service = new AffiliateSellerService($client);

        $sellers = $service->include($include)->get();

        static::assertSame(1, $sellers[0]->id());
        static::assertSame("/v2/affiliates/sellers?include=$includeValue", $client->path());
    }

    /**
     * Data provider for index_sellers_with_relations.
     */
    public static function relationsProvider(): array
    {
        return [
            'address'        => [AffiliateSellerIncludes::ADDRESS, 'address'],
            'contact'        => [AffiliateSellerIncludes::CONTACT, 'contact'],
            'profile'        => [AffiliateSellerIncludes::PROFILE, 'profile'],
            'statistics'     => [AffiliateSellerIncludes::STATISTICS, 'statistics'],
            'payoutOptions'  => [AffiliateSellerIncludes::PAYOUT_OPTIONS, 'payout_options'],
            'payoutMethods'  => [AffiliateSellerIncludes::PAYOUT_METHODS, 'payout_methods'],
        ];
    }

    /**
     * @dataProvider sellerFilterDataProvider
     * @test
     */
    public function index_sellers_with_filter(string $method, mixed $value, string $queryKey, string $queryValue): void
    {
        $client  = (new AffiliateSellerIndexMockClient());
        $service = new AffiliateSellerService($client);

        $filter = (new AffiliateSellerFilter())->$method($value);
        $service->get($filter);

        static::assertSame("/v2/affiliates/sellers?$queryKey=$queryValue", $client->path());
    }

    /**
     * @test
     */
    public function index_sellers_with_null_decline_reason(): void
    {
        $client = (new AffiliateSellerIndexMockClient([
            [
                'id'              => 1,
                'name'            => 'John Doe',
                'email'           => 'john@example.com',
                'decline_reason'  => null,
                'profile_id'      => 1,
                'status'          => 'accepted',
                'payout_methods'  => null,
            ],
        ]));
        $service = new AffiliateSellerService($client);
        $sellers = $service->get();

        static::assertSame(1, $sellers[0]->id());
        static::assertNull($sellers[0]->declineReason());
    }

    /**
     * Data provider for index_sellers_with_filter.
     */
    public static function sellerFilterDataProvider(): array
    {
        return [
            [
                'method'     => 'limit',
                'value'      => 10,
                'queryKey'   => 'limit',
                'queryValue' => '10',
            ],
            [
                'method'     => 'sort',
                'value'      => SellerSortType::NAME,
                'queryKey'   => 'sort',
                'queryValue' => 'name',
            ],
            [
                'method'     => 'direction',
                'value'      => Direction::DESC,
                'queryKey'   => 'direction',
                'queryValue' => 'desc',
            ],
            [
                'method'     => 'query',
                'value'      => 'John',
                'queryKey'   => 'q',
                'queryValue' => 'John',
            ],
            [
                'method'     => 'status',
                'value'      => SellerStatus::ACCEPTED,
                'queryKey'   => 'status',
                'queryValue' => 'accepted',
            ],
            [
                'method'     => 'eligibleForPayout',
                'value'      => true,
                'queryKey'   => 'eligible_for_payout',
                'queryValue' => '1',
            ],
            [
                'method'     => 'since',
                'value'      => new DateTime('2023-01-01'),
                'queryKey'   => 'since',
                'queryValue' => '2023-01-01',
            ],
            [
                'method'     => 'until',
                'value'      => new DateTime('2023-12-31'),
                'queryKey'   => 'until',
                'queryValue' => '2023-12-31',
            ],
        ];
    }
}
