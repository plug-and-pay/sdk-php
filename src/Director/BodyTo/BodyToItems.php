<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director\BodyTo;

use PlugAndPay\Sdk\Contract\BuildObjectInterface;
use PlugAndPay\Sdk\Entity\Item;
use PlugAndPay\Sdk\Entity\ItemInternal;
use PlugAndPay\Sdk\Enum\ItemType;

class BodyToItems implements BuildObjectInterface
{
    /**
     * @return Item[]
     */
    public static function build(array $data): array
    {
        $result = [];
        foreach ($data as $itemData) {
            $item = (new ItemInternal())
                ->setId($itemData['id'])
                ->setProductId($itemData['product_id'])
                ->setLabel($itemData['label'])
                ->setQuantity($itemData['quantity'])
                ->setAmount((float) $itemData['amount'])
                ->setAmountWithTax((float) $itemData['amount_with_tax'])
                ->setType($itemData['type'] ? ItemType::from($itemData['type']) : ItemType::STANDARD);

            if (isset($itemData['discounts'])) {
                $item->setDiscounts(BodyToDiscounts::buildMulti($itemData['discounts']));
            }

            if (isset($itemData['tax'])) {
                $item->setTax(BodyToTax::build($itemData['tax']));
            }

            $result[] = $item;
        }

        return $result;
    }
}
