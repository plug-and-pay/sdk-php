<?php

/** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

namespace PlugAndPay\Sdk\Tests\Feature\Order;

use DateTime;
use PHPUnit\Framework\TestCase;
use PlugAndPay\Sdk\Enum\ContractType;
use PlugAndPay\Sdk\Enum\CountryCode;
use PlugAndPay\Sdk\Enum\Direction;
use PlugAndPay\Sdk\Enum\InvoiceStatus;
use PlugAndPay\Sdk\Enum\Mode;
use PlugAndPay\Sdk\Enum\OrderIncludes;
use PlugAndPay\Sdk\Enum\OrderSortType;
use PlugAndPay\Sdk\Enum\PaymentStatus;
use PlugAndPay\Sdk\Enum\Source;
use PlugAndPay\Sdk\Filters\OrderFilter;
use PlugAndPay\Sdk\Service\OrderService;
use PlugAndPay\Sdk\Tests\Feature\Order\Mock\OrderIndexMockClient;

class IndexOrdersTest extends TestCase
{
    /** @test */
    public function index_orders(): void
    {
        $client  = (new OrderIndexMockClient());
        $service = new OrderService($client);
        $orders  = $service->include(OrderIncludes::PAYMENT)->get();

        static::assertSame(1, $orders[0]->id());
        static::assertSame('/v2/orders?include=payment', $client->path());
    }

    /**
     * @dataProvider orderFilterDataProvider
     * @test
     */
    public function index_orders_with_filter(string $method, mixed $value, string $queryKey, string $queryValue): void
    {
        $client  = (new OrderIndexMockClient());
        $service = new OrderService($client);

        $filter = (new OrderFilter())->$method($value);
        $service->get($filter);

        static::assertSame("/v2/orders?$queryKey=$queryValue", $client->path());
    }

    /**
     * Data provider for index_orders_with_filter.
     */
    public static function orderFilterDataProvider(): array
    {
        return [
            [
                'method'     => 'affiliateId',
                'value'      => 123,
                'queryKey'   => 'affiliate_id',
                'queryValue' => '123',
            ],
            [
                'method'     => 'checkoutId',
                'value'      => 5,
                'queryKey'   => 'checkout_id',
                'queryValue' => '5',
            ],
            [
                'method'     => 'contractId',
                'value'      => 6,
                'queryKey'   => 'contract_id',
                'queryValue' => '6',
            ],
            [
                'method'     => 'contractType',
                'value'      => ContractType::INSTALLMENTS,
                'queryKey'   => 'contract_type',
                'queryValue' => 'installments',
            ],
            [
                'method'     => 'country',
                'value'      => CountryCode::NL,
                'queryKey'   => 'country',
                'queryValue' => 'NL',
            ],
            [
                'method'     => 'direction',
                'value'      => Direction::DESC,
                'queryKey'   => 'direction',
                'queryValue' => 'desc',
            ],
            [
                'method'     => 'discountCode',
                'value'      => 'sale432',
                'queryKey'   => 'discount_code',
                'queryValue' => 'sale432',
            ],
            [
                'method'     => 'email',
                'value'      => 'email@email.nl',
                'queryKey'   => 'email',
                'queryValue' => 'email%40email.nl',
            ],
            [
                'method'     => 'hasBump',
                'value'      => true,
                'queryKey'   => 'has_bump',
                'queryValue' => '1',
            ],
            [
                'method'     => 'hasTax',
                'value'      => true,
                'queryKey'   => 'has_tax',
                'queryValue' => '1',
            ],
            [
                'method'     => 'invoiceStatus',
                'value'      => InvoiceStatus::CONCEPT,
                'queryKey'   => 'invoice_status',
                'queryValue' => 'concept',
            ],
            [
                'method'     => 'isDeleted',
                'value'      => true,
                'queryKey'   => 'is_deleted',
                'queryValue' => '1',
            ],
            [
                'method'     => 'isFirst',
                'value'      => true,
                'queryKey'   => 'is_first',
                'queryValue' => '1',
            ],
            [
                'method'     => 'isHidden',
                'value'      => true,
                'queryKey'   => 'is_hidden',
                'queryValue' => '1',
            ],
            [
                'method'     => 'isUpsell',
                'value'      => true,
                'queryKey'   => 'is_upsell',
                'queryValue' => '1',
            ],
            [
                'method'     => 'limit',
                'value'      => 4,
                'queryKey'   => 'limit',
                'queryValue' => '4',
            ],
            [
                'method'     => 'mode',
                'value'      => Mode::LIVE,
                'queryKey'   => 'mode',
                'queryValue' => 'live',
            ],
            [
                'method'     => 'page',
                'value'      => 4,
                'queryKey'   => 'page',
                'queryValue' => '4',
            ],
            [
                'method'     => 'paymentStatus',
                'value'      => PaymentStatus::PAID,
                'queryKey'   => 'payment_status',
                'queryValue' => 'paid',
            ],
            [
                'method'     => 'productId',
                'value'      => 4,
                'queryKey'   => 'product_id',
                'queryValue' => '4',
            ],
            [
                'method'     => 'productTag',
                'value'      => 'tag1',
                'queryKey'   => 'product_tag',
                'queryValue' => 'tag1',
            ],
            [
                'method'     => 'query',
                'value'      => 'Piet',
                'queryKey'   => 'q',
                'queryValue' => 'Piet',
            ],
            [
                'method'     => 'sinceInvoiceDate',
                'value'      => new DateTime('2001-01-01'),
                'queryKey'   => 'since_invoice_date',
                'queryValue' => '2001-01-01',
            ],
            [
                'method'     => 'sincePaidAt',
                'value'      => new DateTime('2001-01-01'),
                'queryKey'   => 'since_paid_at',
                'queryValue' => '2001-01-01+00%3A00%3A00',
            ],
            [
                'method'     => 'sort',
                'value'      => OrderSortType::PAID_AT,
                'queryKey'   => 'sort',
                'queryValue' => 'paid_at',
            ],
            [
                'method'     => 'source',
                'value'      => Source::UPGRADE,
                'queryKey'   => 'source',
                'queryValue' => 'upgrade',
            ],
            [
                'method'     => 'untilInvoiceDate',
                'value'      => new DateTime('2001-01-01'),
                'queryKey'   => 'until_invoice_date',
                'queryValue' => '2001-01-01',
            ],
            [
                'method'     => 'untilPaidAt',
                'value'      => new DateTime('2001-01-01 23:59:59'),
                'queryKey'   => 'until_paid_at',
                'queryValue' => '2001-01-01+23%3A59%3A59',
            ],
            [
                'method'     => 'productGroup',
                'value'      => 'lorem',
                'queryKey'   => 'product_group',
                'queryValue' => 'lorem',
            ],
            [
                'method'     => 'productGroup',
                'value'      => 'lorem-ipsum',
                'queryKey'   => 'product_group',
                'queryValue' => 'lorem-ipsum',
            ],
            [
                'method'     => 'productGroup',
                'value'      => 'lorem ipsum test',
                'queryKey'   => 'product_group',
                'queryValue' => 'lorem-ipsum-test',
            ],
        ];
    }
}
