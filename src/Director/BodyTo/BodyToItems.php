<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director\BodyTo;

use PlugAndPay\Sdk\Entity\Item;
use PlugAndPay\Sdk\Entity\Money;

class BodyToItems
{
    /**
     * @return Item[]
     */
    public static function build(array $data): array
    {
        $result = [];
        foreach ($data as $itemData) {
            $item = (new Item())
                ->setId($itemData['id'])
                ->setProductId($itemData['product_id'])
                ->setLabel($itemData['label'])
                ->setQuantity($itemData['quantity'])
                ->setAmount(new Money((float)$itemData['amount']['value']))
                ->setTotal(new Money((float)$itemData['amount_with_tax']['value']))
                ->setType($itemData['type']);

            if (isset($itemData['discounts'])) {
                $item->setDiscounts(BodyToDiscounts::buildMany($itemData['discounts']));
            }

            if (isset($itemData['tax'])) {
                $item->setTax(BodyToTax::build($itemData['tax']));
            }

            $result[] = $item;
        }
        return $result;
    }
}
