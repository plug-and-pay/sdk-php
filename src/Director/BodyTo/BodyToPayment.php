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
        $payment = (new Payment());

        if (isset($data['type'])) {
            $payment->setType(PaymentType::from($data['type']));
        }

        if (isset($data['order_id'])) {
            $payment->setOrderId($data['order_id']);
        }

        if (isset($data['paid_at'])) {
            $payment->setPaidAt(!empty($data['paid_at']) ? new DateTimeImmutable($data['paid_at']) : null);
        }

        if (isset($data['status'])) {
            $payment->setStatus(PaymentStatus::from($data['status']));
        }

        if (isset($data['url'])) {
            $payment->setUrl($data['url']);
        }

        if (isset($data['customer_id'])) {
            $payment->setCustomerId($data['customer_id']);
        }

        if (isset($data['mandate_id'])) {
            $payment->setMandateId($data['mandate_id']);
        }

        if (isset($data['mandate_id'])) {
            $payment->setProvider($data['provider'] ? PaymentProvider::from($data['provider']) : null);
        }

        if (isset($data['transaction_id'])) {
            $payment->setTransactionId($data['transaction_id']);
        }

        if (isset($data['method'])) {
            $payment->setMethod($data['method'] ? PaymentMethod::from($data['method']) : null);
        }

        return $payment;
    }
}
