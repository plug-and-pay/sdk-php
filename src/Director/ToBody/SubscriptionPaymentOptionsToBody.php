<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director\ToBody;

use PlugAndPay\Sdk\Entity\SubscriptionPaymentOptions;

class SubscriptionPaymentOptionsToBody
{
    public static function build(SubscriptionPaymentOptions $paymentOptions): array
    {
        $result = [];

        if ($paymentOptions->isset('customerId')) {
            $result['customer_id'] = $paymentOptions->customerId();
        }

        if ($paymentOptions->isset('mandateId')) {
            $result['mandate_id'] = $paymentOptions->mandateId();
        }

        if ($paymentOptions->isset('provider')) {
            $result['provider'] = $paymentOptions->provider()->value;
        }

        if ($paymentOptions->isset('transactionId')) {
            $result['transaction_id'] = $paymentOptions->transactionId();
        }

        if ($paymentOptions->isset('type')) {
            $result['type'] = $paymentOptions->type()->value;
        }

        return $result;
    }
}
