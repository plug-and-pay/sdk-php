<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director\BodyTo;

use PlugAndPay\Sdk\Entity\SubscriptionBilling;
use PlugAndPay\Sdk\Exception\DecodeResponseException;

class BodyToSubscriptionBilling
{
    /**
     * @throws DecodeResponseException
     */
    public static function build(array $data): SubscriptionBilling
    {
        return (new SubscriptionBilling(false))
            ->setAddress(BodyToAddress::build($data['address']))
            ->setContact(BodyToContact::build($data['contact']))
            ->setSchedule(BodyToSubscriptionBillingSchedule::build($data['schedule']))
            ->setPaymentOptions(BodyToSubscriptionPaymentOptions::build($data['payment_options']));
    }
}
