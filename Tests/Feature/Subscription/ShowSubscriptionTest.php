<?php /** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

namespace PlugAndPay\Sdk\Tests\Feature\Subscription;

use PHPUnit\Framework\TestCase;
use PlugAndPay\Sdk\Entity\Response;
use PlugAndPay\Sdk\Entity\Subscription;
use PlugAndPay\Sdk\Enum\Mode;
use PlugAndPay\Sdk\Enum\Source;
use PlugAndPay\Sdk\Enum\SubscriptionStatus;
use PlugAndPay\Sdk\Exception\NotFoundException;
use PlugAndPay\Sdk\Exception\RelationNotLoadedException;
use PlugAndPay\Sdk\Service\SubscriptionService;
use PlugAndPay\Sdk\Tests\Feature\Subscription\Mock\SubscriptionShowMockClient;

class ShowSubscriptionTest extends TestCase
{
    /** @test */
    public function show_basic_subscription(): void
    {
        $client = new SubscriptionShowMockClient(['id' => 1]);
        $service = new SubscriptionService($client);

        $subscription = $service->find(1);

        static::assertSame(1, $subscription->id());
        static::assertNull($subscription->cancelledAt());
        static::assertSame('2022-09-20 08:15:24', $subscription->createdAt()->format('Y-m-d H:i:s'));
        static::assertNull($subscription->deletedAt());
        static::assertSame(Mode::LIVE, $subscription->mode());
        static::assertSame(Source::API, $subscription->source());
        static::assertSame(SubscriptionStatus::ACTIVE, $subscription->status());
        static::assertSame('2022-09-20 08:15:24', $subscription->createdAt()->format('Y-m-d H:i:s'));
    }

    /**
     * @test
     * @dataProvider relationsProvider
     */
    public function show_none_loaded_relationships(string $relation): void
    {
        $exception = null;

        try {
            (new Subscription(false))->{$relation}();
        } catch (RelationNotLoadedException $exception) {
        }

        static::assertInstanceOf(RelationNotLoadedException::class, $exception);
    }

    /**
     * Data provider for show_none_loaded_relationships
     */
    public function relationsProvider(): array
    {
        return [
            'billing' => ['billing'],
            'meta'    => ['meta'],
            'pricing' => ['pricing'],
            'product' => ['product'],
            'tags'    => ['tags'],
            'trial'   => ['trial'],
        ];
    }
}
