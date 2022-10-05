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
        return (new Payment())
            ->setCustomerId($data['customer_id'] ?? null)
            ->setMandateId($data['mandate_id'] ?? null)
            ->setMethod(PaymentMethod::tryFrom($data['method'] ?? ''))
            ->setType(PaymentType::tryFrom($data['type'] ?? ''))
            ->setProvider(PaymentProvider::tryFrom($data['provider'] ?? ''))
            ->setTransactionId($data['transaction_id'] ?? null)
            ->setOrderId($data['order_id'] ?? null)
            ->setPaidAt(!empty($data['paid_at']) ? new DateTimeImmutable($data['paid_at']) : null)
            ->setStatus(PaymentStatus::from($data['status']))
            ->setUrl($data['url'] ?? null);
    }
}
