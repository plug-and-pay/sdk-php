<?php /** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director;

use DateTimeImmutable;
use PlugAndPay\Sdk\Entity\Money;
use PlugAndPay\Sdk\Entity\Order;

class ResponseToOrder
{
    /**
     * @return Order[]
     */
    public function buildMulti(array $data): array
    {
        $result = [];
        foreach ($data as $order) {
            $result[] = (new ResponseToOrder())->build($order);
        }

        return $result;
    }

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

        if (isset($data['comments'])) {
            $order->setComments((new ResponseToBilling())->buildMulti($data['comments']));
        }

        if (isset($data['items'])) {
            $order->setItems((new ResponseToItems())->build($data['items']));
        }

        if (isset($data['taxes'])) {
            $order->setTaxes((new ResponseToTax())->buildMulti($data['taxes']));
        }

        if (isset($data['payment'])) {
            $order->setPayment((new ResponseToPayment())->build($data['payment']));
        }

        if (isset($data['tags'])) {
            $order->setTags($data['tags']);
        }

        return $order;
    }
}
