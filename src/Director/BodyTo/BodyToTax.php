<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director\BodyTo;

use PlugAndPay\Sdk\Contract\BuildMultipleObjectsInterface;
use PlugAndPay\Sdk\Contract\BuildObjectInterface;
use PlugAndPay\Sdk\Entity\Tax;
use PlugAndPay\Sdk\Entity\TaxInternal;
use PlugAndPay\Sdk\Traits\BuildMultipleObjects;

class BodyToTax implements BuildObjectInterface, BuildMultipleObjectsInterface
{
    use BuildMultipleObjects;

    public static function build(array $data): Tax
    {
        return (new TaxInternal())
            ->setAmount((float) $data['amount'])
            ->setRate(BodyToRate::build($data['rate']));
    }
}
