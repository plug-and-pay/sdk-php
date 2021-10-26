<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director\ToBody;

use PlugAndPay\Sdk\Entity\Item;

class ItemToBody
{
    public static function build(Item $item): array
    {
        return [
            'label' => $item->label(),
        ];
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
