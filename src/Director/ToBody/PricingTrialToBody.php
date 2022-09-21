<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director\ToBody;

use PlugAndPay\Sdk\Entity\PricingTrial;

class PricingTrialToBody
{
    public static function build(PricingTrial $trial): array
    {
        return [
            'amount'          => $trial->amount(),
            'amount_with_tax' => $trial->amountWithTax(),
            'duration'        => $trial->duration(),
        ];
    }
}
