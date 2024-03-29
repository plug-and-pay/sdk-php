<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director\ToBody;

use PlugAndPay\Sdk\Entity\Order;
use PlugAndPay\Sdk\Exception\RelationNotLoadedException;

class OrderToBody
{
    /**
     * @throws RelationNotLoadedException
     */
    public static function build(Order $order): array
    {
        $result = [];

        if ($order->isset('hidden')) {
            $result['is_hidden'] = $order->isHidden();
        }

        if ($order->isset('billing')) {
            $result['billing'] = OrderBillingToBody::build($order->billing());
        }

        if ($order->isset('comments')) {
            $result['comments'] = CommentToBody::buildMulti($order->comments());
        }

        if ($order->isset('items')) {
            $result['items'] = ItemToBody::buildMulti($order->items());
        }

        if ($order->isset('payment')) {
            $result['payment'] = OrderPaymentToBody::build($order->payment());
        }

        if ($order->isset('tags')) {
            $result['tags'] = $order->tags();
        }

        return $result;
    }
}
