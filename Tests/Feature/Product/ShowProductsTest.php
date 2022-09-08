<?php /** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

namespace PlugAndPay\Sdk\Tests\Feature\Product;

use PHPUnit\Framework\TestCase;
use PlugAndPay\Sdk\Entity\Pricing;
use PlugAndPay\Sdk\Entity\Product;
use PlugAndPay\Sdk\Enum\OrderIncludes;
use PlugAndPay\Sdk\Exception\RelationNotLoadedException;
use PlugAndPay\Sdk\Service\OrderService;
use PlugAndPay\Sdk\Service\ProductService;
use PlugAndPay\Sdk\Tests\Feature\Order\Mock\OrderShowMockClient;
use PlugAndPay\Sdk\Tests\Feature\Product\Mock\ProductShowMockClient;

class ShowProductsTest extends TestCase
{
    /** @test */
    public function show_basic_product(): void
    {
        $client  = new ProductShowMockClient(['id' => 1]);
        $service = new ProductService($client);

        $product = $service->find(1);

        static::assertSame(1, $product->id());
        static::assertSame('2019-01-16 00:00:00', $product->createdAt()->format('Y-m-d H:i:s'));
        static::assertSame('2019-01-16 00:00:00', $product->deletedAt()->format('Y-m-d H:i:s'));
        static::assertSame('Quisquam recusandae asperiores accusamus', $product->description());
        static::assertSame(false, $product->isPhysical());
        static::assertSame('culpa', $product->publicTitle());
        static::assertSame('70291520', $product->sku());
        static::assertSame('culpa', $product->slug());
        static::assertSame('culpa', $product->title());
        static::assertSame('one_off', $product->type()->value);
        static::assertSame('2019-01-16 00:00:00', $product->updatedAt()->format('Y-m-d H:i:s'));
    }

    /**
     * @test
     * @dataProvider relationsProvider
     */
    public function fetch_none_loaded_relationships(string $relation): void
    {
        $exception = null;

        try {
            (new Product(false))->{$relation}();
        } catch (RelationNotLoadedException $exception) {
        }

        static::assertInstanceOf(RelationNotLoadedException::class, $exception);
    }

    /**
     * Data provider for fetch_none_loaded_relationships
     */
    public function relationsProvider(): array
    {
        return [
            'pricing'      => ['pricing'],
            'statistics'   => ['statistics'],
            'customFields' => ['customFields'],
        ];
    }

    /** @test */
    public function fetch_none_loaded_rax_rate(): void
    {
        $exception = null;
        $product = (new Product())->setPricing((new Pricing(false)));

        try {
            $product->pricing()->tax()->rate();
        } catch (RelationNotLoadedException $exception) {
        }

        static::assertInstanceOf(RelationNotLoadedException::class, $exception);
    }

    /** @test */
    public function show_product_pricing(): void
    {
        $client  = (new ProductShowMockClient(['id' => 1]))->pricing();
        $service = new ProductService($client);

        $order = $service->include(OrderIncludes::PAYMENT)->find(1);

        $pricing = $order->pricing();
        static::assertSame('/v2/products/1?include=pricing', $client->path());
        static::assertSame(5, $pricing->id());
    }
}
