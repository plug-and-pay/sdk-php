<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director\BodyTo;

use PlugAndPay\Sdk\Entity\Money;
use PlugAndPay\Sdk\Entity\Rate;
use PlugAndPay\Sdk\Entity\Tax;

class BodyToTax
{
    public static function build(array $data): Tax
    {
        return (new Tax())
            ->setAmount(new Money((float)$data['amount']['value'], $data['amount']['currency']))
            ->setRate(new Rate($data['rate']['percentage'], $data['rate']['country']));
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
