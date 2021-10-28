<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Tests\Unit;

use DateTime;
use PHPUnit\Framework\TestCase;
use PlugAndPay\Sdk\Enum\ContractType;
use PlugAndPay\Sdk\Enum\Direction;
use PlugAndPay\Sdk\Enum\InvoiceStatus;
use PlugAndPay\Sdk\Enum\OrderMode;
use PlugAndPay\Sdk\Enum\OrderSortType;
use PlugAndPay\Sdk\Enum\OrderSource;
use PlugAndPay\Sdk\Enum\PaymentStatus;
use PlugAndPay\Sdk\Filters\OrderFilter;

class OrderFilterTest extends TestCase
{
    /**
     * @test
     * @dataProvider filterOptionsOneValue
     */
    public function parameters_by_filter_one_value($method, $key, $value): void
    {
        /** @var OrderFilter $filter */
        $filter = (new OrderFilter())->{$method}($value);
        static::assertSame([$key => $value], $filter->parameters());
    }

    public function filterOptionsOneValue(): array
    {
        return [
            'affiliate_id'       => ['affiliateId', 'affiliate_id', 123],
            'checkout_id'        => ['checkoutId', 'checkout_id', 123],
            'country'            => ['country', 'country', 'NL'],
            'direction'          => ['direction', 'direction', Direction::ASC],
            'discount_code'      => ['discountCode', 'discount_code', '123'],
            'email'              => ['email', 'email', 'fake@test.nl'],
            'has_bump'           => ['hasBump', 'has_bump', true],
            'has_tax'            => ['hasTax', 'has_tax', true],
            'invoice_status'     => ['invoiceStatus', 'invoice_status', InvoiceStatus::FINAL],
            'is_deleted'         => ['isDeleted', 'is_deleted', true],
            'is_first'           => ['isFirst', 'is_first', true],
            'is_hidden'          => ['isHidden', 'is_hidden', true],
            'is_upsell'          => ['isUpsell', 'is_upsell', true],
            'limit'              => ['limit', 'limit', 10],
            'mode'               => ['mode', 'mode', OrderMode::TEST],
            'page'               => ['page', 'page', 2],
            'product_id'         => ['productId', 'product_id', 123],
            'product_tag'        => ['productTag', 'product_tag', 'test-tag'],
            'query'              => ['query', 'q', 'Piet Niet'],
            'since_invoice_date' => ['sinceInvoiceDate', 'since_invoice_date', new DateTime()],
            'since_paid_at'      => ['sincePaidAt', 'since_paid_at', new DateTime()],
            'sort'               => ['sort', 'sort', OrderSortType::INVOICE_DATE],
            'source'             => ['source', 'source', OrderSource::API],
            'until_invoice_date' => ['untilInvoiceDate', 'until_invoice_date', new DateTime()],
            'until_paid_at'      => ['untilPaidAt', 'until_paid_at', new DateTime()],
        ];
    }

    /**
     * @test
     * @dataProvider filterOptionsMultipleValues
     */
    public function parameters_by_filter_multiple_values($method, $key, $value): void
    {
        /** @var OrderFilter $filter */
        $filter = (new OrderFilter())->{$method}(...$value);
        static::assertSame([$key => $value], $filter->parameters());
    }

    public function filterOptionsMultipleValues(): array
    {
        return [
            'contract_id'    => ['contractId', 'contract_id', [123]],
            'contract_type'  => ['contractType', 'contract_type', [ContractType::INSTALLMENTS]],
            'payment_status' => ['paymentStatus', 'payment_status', [PaymentStatus::PAID]],
        ];
    }
}
