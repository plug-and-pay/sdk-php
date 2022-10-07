<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director\BodyTo;

use DateTimeImmutable;
use Exception;
use PlugAndPay\Sdk\Entity\Order;
use PlugAndPay\Sdk\Entity\OrderInternal;
use PlugAndPay\Sdk\Enum\InvoiceStatus;
use PlugAndPay\Sdk\Enum\Mode;
use PlugAndPay\Sdk\Enum\Source;
use PlugAndPay\Sdk\Exception\DecodeResponseException;

class BodyToOrder
{
    /**
     * @throws DecodeResponseException
     * @throws Exception
     */
    public static function build(array $data): Order
    {
        $order = (new OrderInternal(false))
            ->setCreatedAt(self::date($data, 'created_at'))
            ->setDeletedAt($data['deleted_at'] ? self::date($data, 'deleted_at') : null)
            ->setFirst($data['is_first'])
            ->setHidden($data['is_hidden'])
            ->setId($data['id'])
            ->setInvoiceNumber($data['invoice_number'])
            ->setInvoiceStatus(InvoiceStatus::from($data['invoice_status']))
            ->setMode(Mode::from($data['mode']))
            ->setReference($data['reference'])
            ->setSource(Source::tryFrom($data['source']) ?? Source::UNKNOWN)
            ->setAmount((float)$data['amount'])
            ->setAmountWithTax((float)$data['amount_with_tax'])
            ->setUpdatedAt(self::date($data, 'updated_at'));

        if (isset($data['billing'])) {
            $order->setBilling(BodyToOrderBilling::build($data['billing']));
        }

        if (isset($data['comments'])) {
            $order->setComments(BodyToComment::buildMulti($data['comments']));
        }

        if (isset($data['items'])) {
            $order->setItems(BodyToItems::build($data['items']));
        }

        if (isset($data['total_discounts'])) {
            $order->setTotalDiscounts(BodyToDiscounts::buildMany($data['total_discounts']));
        }

        if (isset($data['taxes'])) {
            $order->setTaxes(BodyToTax::buildMulti($data['taxes']));
        }

        if (isset($data['payment'])) {
            $order->setPayment(BodyToOrderPayment::build($data['payment']));
        }

        if (isset($data['tags'])) {
            $order->setTags($data['tags']);
        }

        return $order;
    }

    /**
     * @return Order[]
     * @throws DecodeResponseException
     */
    public static function buildMulti(array $data): array
    {
        $result = [];
        foreach ($data as $order) {
            $result[] = self::build($order);
        }

        return $result;
    }

    /**
     * @throws DecodeResponseException
     */
    private static function date(array $data, string $field): DateTimeImmutable
    {
        try {
            return new DateTimeImmutable($data[$field]);
        } catch (Exception $e) {
            /** @noinspection JsonEncodingApiUsageInspection */
            $body = (string)json_encode($data, JSON_ERROR_NONE);
            throw new DecodeResponseException($body, $field, $e);
        }
    }
}
