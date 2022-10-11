<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director\ToBody;

use PlugAndPay\Sdk\Entity\Subscription;
use PlugAndPay\Sdk\Enum\Source;
use PlugAndPay\Sdk\Exception\RelationNotLoadedException;

class SubscriptionToBody
{
    /**
     * @throws RelationNotLoadedException
     */
    public static function build(Subscription $subscription): array
    {
        $result = [];

        if ($subscription->isset('mode')) {
            $result['mode'] = $subscription->mode()->value;
        }

        if ($subscription->isset('pricing')) {
            $result['pricing'] = SubscriptionPricingToBody::build($subscription->pricing());
        }

        if ($subscription->isset('product')) {
            $result['product'] = ProductToBody::build($subscription->product());
        }

        if ($subscription->isset('billing')) {
            $result['billing'] = SubscriptionBillingToBody::build($subscription->billing());
        }

        if ($subscription->isset('tags')) {
            $result['tags'] = $subscription->tags();
        }

        return $result;
    }
}
