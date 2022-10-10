<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director\BodyTo;

use PlugAndPay\Sdk\Entity\Tax;
use PlugAndPay\Sdk\Entity\TaxInternal;

class BodyToTax
{
    public static function build(array $data): Tax
    {
        return (new TaxInternal())
            ->setAmount((float) $data['amount'])
            ->setRate(BodyToRate::build($data['rate']));
    }

    /**
     * @return Tax[]
     */
    public static function buildMulti(array $data): array
    {
        $result = [];
        foreach ($data as $tax) {
            $result[] = self::build($tax);
        }

        return $result;
    }
}
