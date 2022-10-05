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

class BodyToOrderPayment
{
    /**
     * @throws Exception
     */
    public static function build(array $data): Payment
    {
        return (new Payment())
            ->setCustomerId($data['customer_id'])
            ->setMandateId($data['mandate_id'])
            ->setMethod($data['method'] ? PaymentMethod::from($data['method']) : null)
            ->setType(PaymentType::from($data['type']))
            ->setProvider($data['provider'] ? PaymentProvider::from($data['provider']) : null)
            ->setTransactionId($data['transaction_id'])
            ->setOrderId($data['order_id'])
            ->setPaidAt(!empty($data['paid_at']) ? new DateTimeImmutable($data['paid_at']) : null)
            ->setStatus(PaymentStatus::from($data['status']))
            ->setUrl($data['url']);
    }
}
