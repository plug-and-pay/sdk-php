<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director;

use PlugAndPay\Sdk\Entity\Order;

class ResponseToOrder
{
    public function build(array $data): Order
    {
        $order = new Order();
        $order->setId($data['id']);

        return $order;
    }
}
