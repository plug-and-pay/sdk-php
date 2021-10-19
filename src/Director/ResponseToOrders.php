<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director;

use PlugAndPay\Sdk\Entity\Order;

class ResponseToOrders
{
    /**
     * @return Order[]
     */
    public function build(array $data): array
    {
        $result = [];
        foreach ($data as $order) {
            $result[] = (new ResponseToOrder())->build($order);
        }

        return $result;
    }
}
