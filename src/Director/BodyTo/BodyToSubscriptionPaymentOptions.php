<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director\BodyTo;

use PlugAndPay\Sdk\Entity\SubscriptionPaymentOptions;
use PlugAndPay\Sdk\Entity\SubscriptionPaymentOptionsInternal;
use PlugAndPay\Sdk\Enum\PaymentProvider;
use PlugAndPay\Sdk\Enum\PaymentType;

class BodyToSubscriptionPaymentOptions
{
    public static function build(array $data): SubscriptionPaymentOptions
    {
        $paymentOptions = (new SubscriptionPaymentOptionsInternal())
            ->setCustomerId($data['customer_id'])
            ->setMandateId($data['mandate_id'])
            ->setTransactionId($data['transaction_id'])
            ->setType(($data['type']) ? PaymentType::from($data['type']) : PaymentType::UNKNOWN);

        if (isset($data['provider'])) {
            $paymentOptions->setProvider(PaymentProvider::from($data['provider']));
        }

        if (isset($data['iban'])) {
            $paymentOptions->setIban($data['iban']);
        }

        if (isset($data['name'])) {
            $paymentOptions->setName($data['name']);
        }

        return $paymentOptions;
    }
}
