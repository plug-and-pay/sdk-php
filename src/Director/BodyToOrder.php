<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director;

use DateTimeImmutable;
use PlugAndPay\Sdk\Entity\Money;
use PlugAndPay\Sdk\Entity\Order;

class BodyToOrder
{
    public static function build(array $data): Order
    {
        $order = (new Order())
            ->setCreatedAt(new DateTimeImmutable($data['created_at']))
            ->setDeletedAt($data['deleted_at'] ? new DateTimeImmutable($data['deleted_at']) : null)
            ->setFirst($data['is_first'])
            ->setHidden($data['is_hidden'])
            ->setId($data['id'])
            ->setTaxIncluded($data['is_tax_included'])
            ->setInvoiceNumber($data['invoice_number'])
            ->setInvoiceStatus($data['invoice_status'])
            ->setMode($data['mode'])
            ->setReference($data['reference'])
            ->setSource($data['source'])
            ->setSubtotal(new Money((float)$data['subtotal']['value']))
            ->setTotal(new Money((float)$data['total']['value']))
            ->setUpdatedAt(new DateTimeImmutable($data['updated_at']));

        if (isset($data['billing'])) {
            $order->setBilling(BodyToBilling::build($data['billing']));
        }

        if (isset($data['comments'])) {
            $order->setComments(BodyToBilling::buildMulti($data['comments']));
        }

        if (isset($data['items'])) {
            $order->setItems(BodyToItems::build($data['items']));
        }

        if (isset($data['taxes'])) {
            $order->setTaxes(BodyToTax::buildMulti($data['taxes']));
        }

        if (isset($data['payment'])) {
            $order->setPayment(BodyToPayment::build($data['payment']));
        }

        if (isset($data['tags'])) {
            $order->setTags($data['tags']);
        }

        return $order;
    }

    /**
     * @return Order[]
     */
    public static function buildMulti(array $data): array
    {
        $result = [];
        foreach ($data as $order) {
            $result[] = self::build($order);
        }

        return $result;
    }
}
