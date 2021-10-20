<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director;

use DateTimeImmutable;
use PlugAndPay\Sdk\Entity\Payment;

class ResponseToPayment
{
    public function build(array $data): Payment
    {
        return (new Payment())
            ->setOrderId($data['order_id'])
            ->setPaidAt(new DateTimeImmutable($data['paid_at']))
            ->setStatus($data['status'])
            ->setUrl($data['url']);
    }
}
