<?php
/** @noinspection EfferentObjectCouplingInspection */
/** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

namespace PlugAndPay\Sdk\Tests\Feature\Product;

use PHPUnit\Framework\TestCase;
use PlugAndPay\Sdk\Director\ToBody\ProductToBody;
use PlugAndPay\Sdk\Entity\Product;
use PlugAndPay\Sdk\Entity\Stock;
use PlugAndPay\Sdk\Enum\ProductType;

class StoreProductsTest extends TestCase
{
    /** @test */
    public function convert_basic_product_to_body(): void
    {
        $body = ProductToBody::build($this->makeBaseProduct());

        static::assertEquals([
            'title' => 'Pencil',
        ], $body);
    }

    /** @test */
    public function convert_product_description(): void
    {
        $product = $this->makeBaseProduct()->setDescription('Quisquam recusandae.');

        $body = ProductToBody::build($product);

        static::assertEquals('Quisquam recusandae.', $body['description']);
    }

    /** @test */
    public function convert_product_is_physical(): void
    {
        $product = $this->makeBaseProduct()->setPhysical(true);

        $body = ProductToBody::build($product);

        static::assertEquals(true, $body['is_physical']);
    }

    /** @test */
    public function convert_product_ledger(): void
    {
        $product = $this->makeBaseProduct()->setLedger(1234);

        $body = ProductToBody::build($product);

        static::assertEquals(true, $body['ledger']);
    }

    /** @test */
    public function convert_product_public_title(): void
    {
        $product = $this->makeBaseProduct()->setPublicTitle('Culpa');

        $body = ProductToBody::build($product);

        static::assertEquals('Culpa', $body['public_title']);
    }

    /** @test */
    public function convert_product_sku(): void
    {
        $product = $this->makeBaseProduct()->setSku('UGG-BB-PUR-06');

        $body = ProductToBody::build($product);

        static::assertEquals('UGG-BB-PUR-06', $body['sku']);
    }

    /** @test */
    public function convert_product_slug(): void
    {
        $product = $this->makeBaseProduct()->setSlug('pencil');

        $body = ProductToBody::build($product);

        static::assertEquals('pencil', $body['slug']);
    }

    /** @test */
    public function convert_product_type(): void
    {
        $product = $this->makeBaseProduct()->setType(ProductType::ONE_OFF);

        $body = ProductToBody::build($product);

        static::assertEquals('one_off', $body['type']);
    }

    /** @test */
    public function convert_product_stock_disabled(): void
    {
        $product = $this->makeBaseProduct()->setStock((new Stock())->setEnabled(false));

        $body = ProductToBody::build($product);

        static::assertEquals(false, $body['stock']['is_enabled']);
        static::assertArrayNotHasKey('is_hidden', $body['stock']);
        static::assertArrayNotHasKey('value', $body['stock']);
    }

    /** @test */
    public function convert_product_stock_enabled(): void
    {
        $product = $this->makeBaseProduct()->setStock(
            (new Stock())
                ->setEnabled(true)
                ->setHidden(false)
                ->setValue(10)
        );

        $body = ProductToBody::build($product);

        static::assertEquals(true, $body['stock']['is_enabled']);
        static::assertEquals(false, $body['stock']['is_hidden']);
        static::assertEquals(10, $body['stock']['value']);
    }

    private function makeBaseProduct(): Product
    {
        return (new Product())->setTitle('Pencil');
    }
}
