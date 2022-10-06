<?php /** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

namespace PlugAndPay\Sdk\Tests\Feature\Subscription;

use PHPUnit\Framework\TestCase;
use PlugAndPay\Sdk\Entity\Subscription;
use PlugAndPay\Sdk\Enum\Mode;
use PlugAndPay\Sdk\Enum\PaymentType;
use PlugAndPay\Sdk\Service\SubscriptionService;
use PlugAndPay\Sdk\Tests\Feature\Subscription\Mock\SubscriptionUpdateMockClient;

class UpdateSubscriptionTest extends TestCase
{
    /** @test */
    public function update_basic_subscription(): void
    {
        $client  = new SubscriptionUpdateMockClient();
        $service = new SubscriptionService($client);

        $subscription = $service->update(1, function (Subscription $subscription) {
            $subscription->setMode(Mode::TEST);
        });

        static::assertEquals('test', $subscription->mode()->value);
        static::assertEquals('/v2/subscriptions/1', $client->path());
    }

    /** @test */
    public function update_subscription_billing(): void
    {
        $client  = (new SubscriptionUpdateMockClient())->billing()->pricing()->tax();
        $service = new SubscriptionService($client);

        $subscription = $service->update(1, function (Subscription $subscription) {
            $subscription->billing()->address()->setZipcode('2121DP');
            $subscription->billing()->contact()->setWebsite('plugandpay.nl');
            $subscription->billing()->schedule()->setNext(1);
            $subscription->billing()->paymentOptions()->setType(PaymentType::MANUAL);
            $subscription->pricing()->tax()->setAmount(10.);
        });

        static::assertEquals('2121DP', $subscription->billing()->address()->zipcode());
        static::assertEquals('plugandpay.nl', $subscription->billing()->contact()->website());
        static::assertEquals(1, $subscription->billing()->schedule()->next());
        static::assertEquals('manual', $subscription->billing()->paymentOptions()->type()->value);
        static::assertEquals(10., $subscription->pricing()->tax()->amount());
    }
}
