<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director\ToBody;

use PlugAndPay\Sdk\Entity\Item;

class ItemToBody
{
    public static function build(Item $item): array
    {
        $result = [];

        if ($item->isset('productId')) {
            $result['product_id'] = $item->productId();
        }

        if ($item->isset('amount')) {
            $result['amount'] = MoneyToBody::build($item->amount());
        }

        if ($item->isset('label')) {
            $result['label'] = $item->label();
        }

        if ($item->isset('quantity')) {
            $result['quantity'] = $item->quantity();
        }

        if ($item->isset('tax')) {
            $result['tax'] = TaxToBody::build($item->tax());
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
