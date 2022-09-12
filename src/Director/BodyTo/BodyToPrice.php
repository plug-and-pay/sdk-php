<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director\BodyTo;

use PlugAndPay\Sdk\Entity\Price;

class BodyToPrice
{
    /**
     * @return Price[]
     */
    public static function build(array $data): array
    {
        $prices = [];
        foreach ($data as $price) {
            $prices[] = (new Price())
                ->setFirst(null)
                ->setInterval(null)
                ->setSuggested(false)
                ->setNrOfCycles(1)
                ->setOriginal(null)
                ->setRegular(100.)
                ->setRegularWithTax(121.)
                ->setTiers([]);
        }

        return $prices;
    }
}
