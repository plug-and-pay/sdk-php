<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director\BodyTo;

use DateTimeImmutable;
use Exception;
use PlugAndPay\Sdk\Entity\Payment;
use PlugAndPay\Sdk\Enum\PaymentMethod;
use PlugAndPay\Sdk\Enum\PaymentProvider;
use PlugAndPay\Sdk\Enum\PaymentStatus;
use PlugAndPay\Sdk\Enum\PaymentType;

class BodyToPayment
{
    /**
     * @throws Exception
     */
    public static function build(array $data): Payment
    {
        $payment = (new Payment())
            ->setType(PaymentType::from($data['type']))
            ->setOrderId($data['order_id'])
            ->setPaidAt(!empty($data['paid_at']) ? new DateTimeImmutable($data['paid_at']) : null)
            ->setStatus(PaymentStatus::from($data['status']))
            ->setUrl($data['url']);

        if (isset($itemData['customer_id'])) {
            $payment->setCustomerId($data['customer_id']);
        }

        if (isset($itemData['mandate_id'])) {
            $payment->setMandateId($data['mandate_id']);
        }

        if (isset($itemData['mandate_id'])) {
            $payment->setProvider($data['provider'] ? PaymentProvider::from($data['provider']) : null);
        }

        if (isset($itemData['transaction_id'])) {
            $payment->setTransactionId($data['transaction_id']);
        }

        if (isset($itemData['method'])) {
            $payment->setMethod($data['method'] ? PaymentMethod::from($data['method']) : null);
        }

        return $payment;
    }
}
