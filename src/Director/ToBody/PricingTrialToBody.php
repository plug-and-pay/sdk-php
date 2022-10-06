<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director\ToBody;

use PlugAndPay\Sdk\Entity\PricingTrial;

class PricingTrialToBody
{
    public static function build(PricingTrial $trial): array
    {
        $result = [];

        if ($trial->isset('amount')) {
            $result['amount'] = (string)$trial->amount();
        }

        if ($trial->isset('amountWithTax')) {
            $result['amount_with_tax'] = (string)$trial->amountWithTax();
        }

        if ($trial->isset('duration')) {
            $result['duration'] = $trial->duration();
        }

        return $result;
    }
}
