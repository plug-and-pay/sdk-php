<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director\BodyTo;

use DateTimeImmutable;
use PlugAndPay\Sdk\Entity\Payment;

class BodyToPayment
{
    public static function build(array $data): Payment
    {
        return (new Payment())
            ->setCustomerId($data['customer_id'])
            ->setMandateId($data['mandate_id'])
            ->setMethod($data['method'])
            ->setType($data['type'])
            ->setProvider($data['provider'])
            ->setTransactionId($data['transaction_id'])
            ->setOrderId($data['order_id'])
            ->setPaidAt(!empty($data['paid_at']) ? new DateTimeImmutable($data['paid_at']) : null)
            ->setStatus($data['status'])
            ->setUrl($data['url']);
    }
}
