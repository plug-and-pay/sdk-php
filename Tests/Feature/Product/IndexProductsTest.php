<?php /** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

namespace PlugAndPay\Sdk\Tests\Feature\Product;

use PHPUnit\Framework\TestCase;
use PlugAndPay\Sdk\Enum\Direction;
use PlugAndPay\Sdk\Enum\ProductIncludes;
use PlugAndPay\Sdk\Enum\ProductSortType;
use PlugAndPay\Sdk\Enum\ProductType;
use PlugAndPay\Sdk\Filters\ProductFilter;
use PlugAndPay\Sdk\Service\ProductService;
use PlugAndPay\Sdk\Tests\Feature\Product\Mock\ProductIndexMockClient;

class IndexProductsTest extends TestCase
{
    /** @test */
    public function index_products_include_payment(): void
    {
        $client   = (new ProductIndexMockClient());
        $service  = new ProductService($client);
        $products = $service->include(ProductIncludes::PRICING)->get();

        static::assertSame(1, $products[0]->id());
        static::assertSame('/v2/products?include=pricing', $client->path());
    }

    /**
     * @dataProvider productFilterDataProvider
     * @test
     */
    public function index_products_with_filter(string $method, mixed $value, string $queryKey, string $queryValue): void
    {
        $client  = (new ProductIndexMockClient());
        $service = new ProductService($client);

        $filter = (new ProductFilter())->$method($value);
        $service->get($filter);

        static::assertSame("/v2/products?$queryKey=$queryValue", $client->path());
    }

    public function productFilterDataProvider(): array
    {
        return [
            [
                'method'     => 'direction',
                'value'      => Direction::ASC,
                'queryKey'   => 'direction',
                'queryValue' => 'asc',
            ],
            [
                'method'     => 'hasLimitedStock',
                'value'      => true,
                'queryKey'   => 'has_limited_stock',
                'queryValue' => '1',
            ],
            [
                'method'     => 'isDeleted',
                'value'      => true,
                'queryKey'   => 'is_deleted',
                'queryValue' => '1',
            ],
            [
                'method'     => 'limit',
                'value'      => 3,
                'queryKey'   => 'limit',
                'queryValue' => '3',
            ],
            [
                'method'     => 'page',
                'value'      => 3,
                'queryKey'   => 'page',
                'queryValue' => '3',
            ],
            [
                'method'     => 'q',
                'value'      => 'Piet',
                'queryKey'   => 'q',
                'queryValue' => 'Piet',
            ],
            [
                'method'     => 'sort',
                'value'      => ProductSortType::TITLE,
                'queryKey'   => 'sort',
                'queryValue' => 'title',
            ],
            [
                'method'     => 'tag',
                'value'      => ['first-tag', 'second-tag'],
                'queryKey'   => 'tag',
                'queryValue' => 'first-tag%2Csecond-tag',
            ],
            [
                'method'     => 'type',
                'value'      => ProductType::ONE_OFF,
                'queryKey'   => 'type',
                'queryValue' => 'one_off',
            ],
        ];
    }
}

