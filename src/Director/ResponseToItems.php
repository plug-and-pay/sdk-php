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
        foreach ($data as $item) {
            $result[] = (new Item())
                ->setDiscounts((new ResponseToDiscounts())->build($item['discounts']))
                ->setId($item['id'])
                ->setProductId($item['product_id'])
                ->setPublicTitle($item['public_title'])
                ->setQuantity($item['quantity'])
                ->setSubtotal(new Money((float)$item['subtotal']['value']))
                ->setTotal(new Money((float)$item['total']['value']))
                ->setType($item['type']);
        }
        return $result;
    }
}
