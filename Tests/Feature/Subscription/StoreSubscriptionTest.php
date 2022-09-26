<?php

namespace Feature\Subscription;

use PHPUnit\Framework\TestCase;
use PlugAndPay\Sdk\Director\ToBody\SubscriptionToBody;
use PlugAndPay\Sdk\Entity\Subscription;
use PlugAndPay\Sdk\Enum\Mode;

class StoreSubscriptionTest extends TestCase
{
    /** @test */
    public function convert_basic_subscription_to_body(): void
    {
        $body = SubscriptionToBody::build($this->generateSubscription());

        static::assertEquals([
            'mode' => 'test',
            'source' => 'api'
        ], $body);
    }

    private function generateSubscription(): Subscription
    {
        return (new Subscription())
            ->setMode(Mode::TEST);
    }
}