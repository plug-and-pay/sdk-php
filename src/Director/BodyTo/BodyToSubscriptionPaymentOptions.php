<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director\BodyTo;

use PlugAndPay\Sdk\Entity\SubscriptionPaymentOptions;
use PlugAndPay\Sdk\Enum\PaymentProvider;
use PlugAndPay\Sdk\Enum\PaymentType;

class BodyToSubscriptionPaymentOptions
{
    public static function build(array $data): SubscriptionPaymentOptions
    {
        $paymentOptions = (new SubscriptionPaymentOptions())
            ->setCustomerId($data['customer_id'])
            ->setMandateId($data['mandate_id'])
            ->setTransactionId($data['transaction_id'])
            ->setType(PaymentType::from($data['type']));

        if(isset($data['provider'])) {
            $paymentOptions->setProvider(PaymentProvider::from($data['provider']));
        }

        return $paymentOptions;
    }
}
