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
            ->setOrderId($data['order_id'])
            ->setPaidAt(!empty($data['paid_at']) ? new DateTimeImmutable($data['paid_at']) : null)
            ->setStatus($data['status'])
            ->setUrl($data['url']);
    }
}
