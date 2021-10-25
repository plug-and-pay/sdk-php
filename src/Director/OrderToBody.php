<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director;

use PlugAndPay\Sdk\Entity\Item;
use PlugAndPay\Sdk\Entity\Order;

class OrderToBody
{
    /**
     * @throws \PlugAndPay\Sdk\Exception\RelationNotLoadedException
     */
    public function build(Order $order): array
    {
        $data = [
            'billing'         => [
                'address'    => [
                    'country' => $order->billing()->address()->country(),
                ],
                'email'      => $order->billing()->email(),
                'first_name' => $order->billing()->firstName(),
                'last_name'  => $order->billing()->lastName(),
            ],
            'is_tax_included' => $order->isTaxIncluded(),
            'items'           => $this->getItems($order),
        ];

//        if (isset($data['billing'])) {
//            $order->setBilling((new ResponseToBilling())->build($data['billing']));
//        }
//
//        if (isset($data['comments'])) {
//            $order->setComments((new ResponseToBilling())->buildMulti($data['comments']));
//        }
//
//        if (isset($data['items'])) {
//            $order->setItems((new ResponseToItems())->build($data['items']));
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

    /**
     * @throws \PlugAndPay\Sdk\Exception\RelationNotLoadedException
     */
    protected function getItems(Order $order): array
    {
        return array_map(static function (Item $item) {
            return [
                'label' => $item->label(),
            ];
        }, $order->items());
    }
}
