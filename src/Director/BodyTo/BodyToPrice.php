<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director\BodyTo;

use PlugAndPay\Sdk\Contract\BuildMultipleObjectsInterface;
use PlugAndPay\Sdk\Contract\BuildObjectInterface;
use PlugAndPay\Sdk\Entity\Price;
use PlugAndPay\Sdk\Entity\PriceInternal;
use PlugAndPay\Sdk\Enum\Interval;

class BodyToPrice implements BuildObjectInterface, BuildMultipleObjectsInterface
{
    public static function build(array $data): Price
    {
        return (new PriceInternal())
            ->setId($data['id'])
            ->setFirst($data['first'] ? BodyToPriceFirst::build($data['first']) : null)
            ->setInterval(Interval::tryFrom((string) $data['interval']))
            ->setSuggested($data['is_suggested'])
            ->setNrOfCycles($data['nr_of_cycles'] ?? 1)
            ->setOriginal($data['original'] ? BodyToPriceOriginal::build($data['original']) : null)
            ->setRegular(BodyToPriceRegular::build($data['regular']))
            ->setTiers(BodyToPriceTier::buildMulti($data['tiers']));
    }

    /**
     * @return Price[]
     */
    public static function buildMulti(array $data): array
    {
        $prices = [];
        foreach ($data as $price) {
            $prices[] = self::build($price);
        }

        return $prices;
    }
}
