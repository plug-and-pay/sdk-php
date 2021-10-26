<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director\ToBody;

use PlugAndPay\Sdk\Entity\Payment;

class PaymentToBody
{
    public static function build(Payment $payment): array
    {
        return [
            'status' => $payment->status(),
        ];
    }
}
