<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director\BodyTo;

use PlugAndPay\Sdk\Entity\Item;
use PlugAndPay\Sdk\Enum\ItemType;

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
                ->setProductId($itemData['product_id'])
                ->setLabel($itemData['label'])
                ->setQuantity($itemData['quantity'])
                ->setAmount((float) $itemData['amount'])
                ->setTotal((float) $itemData['amount_with_tax'])
                ->setType($itemData['type'] ? ItemType::from($itemData['type']) : ItemType::STANDARD);

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
