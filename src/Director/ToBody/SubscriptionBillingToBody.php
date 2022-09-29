<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director\ToBody;

use PlugAndPay\Sdk\Entity\SubscriptionBilling;

class SubscriptionBillingToBody
{
    public static function build(SubscriptionBilling $billing): array
    {
        $result = [];

        if ($billing->isset('address')) {
            $result['address'] = AddressToBody::build($billing->address());
        }

        if ($billing->isset('contact')) {
            $result['contact'] = ContactToBody::build($billing->contact());
        }

        if ($billing->isset('schedule')) {
            $result['schedule'] = SubscriptionBillingScheduleToBody::build($billing->schedule());
        }

        if ($billing->isset('paymentOptions')) {
            $result['payment_options'] = SubscriptionPaymentOptionsToBody::build($billing->paymentOptions());
        }

        return $result;
    }
}
