<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director\ToBody;

use PlugAndPay\Sdk\Entity\Payment;

class OrderPaymentToBody
{
    public static function build(Payment $payment): array
    {
        $result = [];

        if ($payment->isset('type')) {
            $result['type'] =  $payment->type()->value;
        }

        if ($payment->isset('status')) {
            $result['status'] = $payment->status()->value;
        }

        return $result;
    }
}
