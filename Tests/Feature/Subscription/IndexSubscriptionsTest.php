<?php

namespace Feature\Subscription;

use DateTime;
use PHPUnit\Framework\TestCase;
use PlugAndPay\Sdk\Enum\CountryCode;
use PlugAndPay\Sdk\Enum\Interval;
use PlugAndPay\Sdk\Enum\Mode;
use PlugAndPay\Sdk\Enum\SubscriptionIncludes;
use PlugAndPay\Sdk\Enum\SubscriptionStatus;
use PlugAndPay\Sdk\Enum\ContractType;
use PlugAndPay\Sdk\Exception\DecodeResponseException;
use PlugAndPay\Sdk\Filters\SubscriptionFilter;
use PlugAndPay\Sdk\Service\SubscriptionService;
use PlugAndPay\Sdk\Tests\Feature\Subscription\Mock\SubscriptionIndexMockClient;

class IndexSubscriptionsTest extends TestCase
{
    /** @test */
    public function index_subscriptions(): void
    {
        $client = (new SubscriptionIndexMockClient());
        $service = new SubscriptionService($client);
        $subscriptions = $service->include(SubscriptionIncludes::PRICING)->get();

        static::assertSame(1, $subscriptions[0]->id());
        static::assertSame('/v2/subscriptions?include=pricing', $client->path());
    }

    /**
     * @test
     * @dataProvider subscriptionFilterDataProvider
     * @throws DecodeResponseException
     */
    public function index_subscriptions_with_filter(string $method, mixed $value, string $queryKey, string $queryValue): void
    {
        $client = (new SubscriptionIndexMockClient());
        $service = new SubscriptionService($client);

        $filter = (new SubscriptionFilter())->$method($value);
        $service->get($filter);

        static::assertSame("/v2/subscriptions?$queryKey=$queryValue", $client->path());
    }

    /**
     * Data provider for index_subscriptions_with_filter
     */
    public function subscriptionFilterDataProvider(): array
    {
        return [
            [
                'method'     => 'affiliateId',
                'value'      => 123,
                'queryKey'   => 'affiliate_id',
                'queryValue' => '123',
            ],
            [
                'method'     => 'billingScheduleInterval',
                'value'      => Interval::MONTHLY,
                'queryKey'   => 'billing_schedule_interval',
                'queryValue' => 'monthly',
            ],
            [
                'method'     => 'billingScheduleLatestAt',
                'value'      => new DateTime('2022-01-01'),
                'queryKey'   => 'billing_schedule_latest_at',
                'queryValue' => '2022-01-01',
            ],
            [
                'method'     => 'billingScheduleNextAt',
                'value'      => new DateTime('2022-01-01'),
                'queryKey'   => 'billing_schedule_next_at',
                'queryValue' => '2022-01-01',
            ],
            [
                'method'     => 'country',
                'value'      => CountryCode::NL,
                'queryKey'   => 'country',
                'queryValue' => 'NL',
            ],
            [
                'method'     => 'hasOrders',
                'value'      => true,
                'queryKey'   => 'has_orders',
                'queryValue' => '1',
            ],
            [
                'method'     => 'isTrial',
                'value'      => true,
                'queryKey'   => 'is_trial',
                'queryValue' => '1',
            ],
            [
                'method'     => 'limit',
                'value'      => 15,
                'queryKey'   => 'limit',
                'queryValue' => '15',
            ],
            [
                'method'     => 'mode',
                'value'      => Mode::TEST,
                'queryKey'   => 'mode',
                'queryValue' => 'test',
            ],
            [
                'method'     => 'page',
                'value'      => 5,
                'queryKey'   => 'page',
                'queryValue' => '5',
            ],
            [
                'method'     => 'productId',
                'value'      => 10,
                'queryKey'   => 'product_id',
                'queryValue' => '10',
            ],
            [
                'method'     => 'isFirst',
                'value'      => true,
                'queryKey'   => 'is_first',
                'queryValue' => '1',
            ],
            [
                'method'     => 'query',
                'value'      => 'Lorem',
                'queryKey'   => 'q',
                'queryValue' => 'Lorem',
            ],
            [
                'method'     => 'sinceCreatedAt',
                'value'      => new DateTime('2022-01-01'),
                'queryKey'   => 'since_created_at',
                'queryValue' => '2022-01-01',
            ],
            [
                'method'     => 'status',
                'value'      => SubscriptionStatus::ACTIVE,
                'queryKey'   => 'status',
                'queryValue' => 'active',
            ],
            [
                'method'     => 'tag',
                'value'      => ['first-tag', 'second-tag'],
                'queryKey'   => 'tag',
                'queryValue' => 'first-tag%2Csecond-tag',
            ],
            [
                'method'     => 'type',
                'value'      => ContractType::SUBSCRIPTION,
                'queryKey'   => 'type',
                'queryValue' => 'subscription',
            ],
            [
                'method'     => 'untilCreatedAt',
                'value'      => new DateTime('2022-01-01'),
                'queryKey'   => 'until_created_at',
                'queryValue' => '2022-01-01',
            ],
        ];
    }
}