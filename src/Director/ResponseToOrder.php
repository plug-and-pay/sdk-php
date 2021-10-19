<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director;

use DateTimeImmutable;
use PlugAndPay\Sdk\Entity\Money;
use PlugAndPay\Sdk\Entity\Order;

class ResponseToOrder
{
    /** @noinspection PhpUnhandledExceptionInspection */
    public function build(array $data): Order
    {
        $order = (new Order())
            ->setCreatedAt(new DateTimeImmutable($data['created_at']))
            ->setDeletedAt($data['deleted_at'] ? new DateTimeImmutable($data['deleted_at']) : null)
            ->setFirst($data['is_first'])
            ->setHidden($data['is_hidden'])
            ->setId($data['id'])
            ->setInvoiceNumber($data['invoice_number'])
            ->setInvoiceStatus($data['invoice_status'])
            ->setMode($data['mode'])
            ->setReference($data['reference'])
            ->setSource($data['source'])
            ->setSubtotal(new Money((float)$data['subtotal']['value']))
            ->setTotal(new Money((float)$data['total']['value']))
            ->setUpdatedAt(new DateTimeImmutable($data['updated_at']));

        if (isset($data['billing'])) {
            $order->setBilling((new ResponseToBilling())->build($data['billing']));
        }

        if (isset($data['items'])) {
            $order->setItems((new ResponseToItems())->build($data['items']));
        }

        return $order;
    }
}
