<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director\ToBody;

use PlugAndPay\Sdk\Entity\Order;

class OrderToBody
{
    /**
     * @throws \PlugAndPay\Sdk\Exception\RelationNotLoadedException
     */
    public static function build(Order $order): array
    {
        $data = [];

        if ($order->isset('taxIncludes')) {
            $data['is_tax_included'] = $order->isTaxIncluded();
        }

        if ($order->isset('billing')) {
            $data['billing'] = BillingToBody::build($order->billing());
        }

        if ($order->isset('items')) {
            $data['items'] = ItemToBody::buildMulti($order->items());
        }

//        if (isset($data['comments'])) {
//            $order->setComments((new ResponseToBilling())->buildMulti($data['comments']));
//        }
//
//        if (isset($data['taxes'])) {
//            $order->setTaxes((new ResponseToTax())->buildMulti($data['taxes']));
//        }
//
//        if (isset($data['payment'])) {
//            $order->setPayment((new ResponseToPayment())->build($data['payment']));
//        }
//
//        if (isset($data['tags'])) {
//            $order->setTags($data['tags']);
//        }

        return $data;
    }
}
