<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director\ToBody;

use PlugAndPay\Sdk\Entity\Tax;

class TaxToBody
{
    public static function build(Tax $tax): array
    {
        $result = [];

        if ($tax->isset('rate')) {
            $result['rate'] = TaxRateToBody::build($tax->rate());
        }

        return $result;
    }
}
