<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director\ToBody;

use PlugAndPay\Sdk\Entity\Price;

class PriceToBody
{
    public static function build(Price $price): array
    {
        $result = [];

        if ($price->isset('suggested')) {
            $result['is_suggested'] = $price->isSuggested();
        }

        if ($price->isset('interval')) {
            $result['interval'] = $price->interval()->value;
        }

        if ($price->isset('nr_of_cycles')) {
            $result['nr_of_cycles'] = $price->nrOfCycles();
        }

        if ($price->isset('first')) {
            $result['first'] = $price->first() ? PriceFirstToBody::build($price->first()) : null;
        }

        if ($price->isset('original')) {
            $result['original'] = $price->original() ? PriceOriginalToBody::build($price->original()) : null;
        }

        if ($price->isset('tiers')) {
            $result['tiers'] = PriceTierToBody::buildMulti($price->tiers());
        }

        return $result;
    }

    public static function buildMulti(array $items): array
    {
        $result = [];
        foreach ($items as $item) {
            $result[] = self::build($item);
        }

        return $result;
    }
}
