<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director;

use PlugAndPay\Sdk\Entity\Item;
use PlugAndPay\Sdk\Entity\Money;

class ResponseToItems
{
    /**
     * @return Item[]
     */
    public function build(array $data): array
    {
        $result = [];
        foreach ($data as $itemData) {
            $item = (new Item())
                ->setDiscounts((new ResponseToDiscounts())->build($itemData['discounts']))
                ->setId($itemData['id'])
                ->setProductId($itemData['product_id'])
                ->setLabel($itemData['label'])
                ->setQuantity($itemData['quantity'])
                ->setSubtotal(new Money((float)$itemData['subtotal']['value']))
                ->setTotal(new Money((float)$itemData['total']['value']))
                ->setType($itemData['type']);

            if (isset($itemData['tax'])) {
                $item->setTax((new ResponseToTax())->build($itemData['tax']));
            }

            $result[] = $item;
        }
        return $result;
    }
}
