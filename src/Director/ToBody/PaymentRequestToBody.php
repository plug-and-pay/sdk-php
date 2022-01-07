<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director\ToBody;

use PlugAndPay\Sdk\Entity\PaymentRequest;

class PaymentRequestToBody
{
    public static function build(PaymentRequest $paymentRequest): array
    {
        return [
            'iban' => $paymentRequest->iban(),
            'name' => $paymentRequest->name(),
            'type' => $paymentRequest->type(),
        ];
    }
}
