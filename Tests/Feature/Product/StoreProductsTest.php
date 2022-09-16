<?php
/** @noinspection EfferentObjectCouplingInspection */
/** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

namespace PlugAndPay\Sdk\Tests\Feature\Product;

use PHPUnit\Framework\TestCase;
use PlugAndPay\Sdk\Director\ToBody\ProductToBody;
use PlugAndPay\Sdk\Entity\Price;
use PlugAndPay\Sdk\Entity\PriceFirst;
use PlugAndPay\Sdk\Entity\PriceOriginal;
use PlugAndPay\Sdk\Entity\PriceTier;
use PlugAndPay\Sdk\Entity\Pricing;
use PlugAndPay\Sdk\Entity\PricingTax;
use PlugAndPay\Sdk\Entity\PricingTrial;
use PlugAndPay\Sdk\Entity\Product;
use PlugAndPay\Sdk\Entity\Shipping;
use PlugAndPay\Sdk\Entity\Stock;
use PlugAndPay\Sdk\Entity\TaxProfile;
use PlugAndPay\Sdk\Entity\TaxRate;
use PlugAndPay\Sdk\Enum\Interval;
use PlugAndPay\Sdk\Enum\ProductIncludes;
use PlugAndPay\Sdk\Enum\ProductType;
use PlugAndPay\Sdk\Service\ProductService;
use PlugAndPay\Sdk\Tests\Feature\Product\Mock\ProductStoreMockClient;

class StoreProductsTest extends TestCase
{
    /** @test */
    public function convert_basic_product_to_body(): void
    {
        $body = ProductToBody::build($this->makeBaseProduct());

        static::assertSame([
            'title' => 'Pencil',
        ], $body);
    }

    /** @test */
    public function convert_product_description(): void
    {
        $product = $this->makeBaseProduct()->setDescription('Quisquam recusandae.');

        $body = ProductToBody::build($product);

        static::assertSame('Quisquam recusandae.', $body['description']);
    }

    /** @test */
    public function convert_product_is_physical(): void
    {
        $product = $this->makeBaseProduct()->setPhysical(true);

        $body = ProductToBody::build($product);

        static::assertSame(true, $body['is_physical']);
    }

    /** @test */
    public function convert_product_ledger(): void
    {
        $product = $this->makeBaseProduct()->setLedger(1234);

        $body = ProductToBody::build($product);

        static::assertSame(1234, $body['ledger']);
    }

    /** @test */
    public function convert_product_public_title(): void
    {
        $product = $this->makeBaseProduct()->setPublicTitle('Culpa');

        $body = ProductToBody::build($product);

        static::assertSame('Culpa', $body['public_title']);
    }

    /** @test */
    public function convert_product_sku(): void
    {
        $product = $this->makeBaseProduct()->setSku('UGG-BB-PUR-06');

        $body = ProductToBody::build($product);

        static::assertSame('UGG-BB-PUR-06', $body['sku']);
    }

    /** @test */
    public function convert_product_slug(): void
    {
        $product = $this->makeBaseProduct()->setSlug('pencil');

        $body = ProductToBody::build($product);

        static::assertSame('pencil', $body['slug']);
    }

    /** @test */
    public function convert_product_type(): void
    {
        $product = $this->makeBaseProduct()->setType(ProductType::ONE_OFF);

        $body = ProductToBody::build($product);

        static::assertSame('one_off', $body['type']);
    }

    /** @test */
    public function convert_product_stock_disabled(): void
    {
        $product = $this->makeBaseProduct()->setStock((new Stock())->setEnabled(false));

        $body = ProductToBody::build($product);

        static::assertSame(false, $body['stock']['is_enabled']);
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

        static::assertSame(true, $body['stock']['is_enabled']);
        static::assertSame(false, $body['stock']['is_hidden']);
        static::assertSame(10, $body['stock']['value']);
    }

    /** @test */
    public function convert_product_is_tax_included(): void
    {
        $product = $this->makeBaseProduct()->setPricing(
            (new Pricing())->setTaxIncluded(true)
        );

        $body = ProductToBody::build($product);

        static::assertSame(true, $body['pricing']['is_tax_included']);
    }

    /** @test */
    public function convert_product_pricing_prices(): void
    {
        $product = $this->makeBaseProduct()->setPricing(
            (new Pricing())->setPrices([
                (new Price())
                    ->setSuggested(true)
                    ->setInterval(Interval::MONTHLY)
                    ->setNrOfCycles(12),
            ])
        );

        $body = ProductToBody::build($product);

        static::assertSame(true, $body['pricing']['prices'][0]['is_suggested']);
        static::assertSame('monthly', $body['pricing']['prices'][0]['interval']);
        static::assertSame(12, $body['pricing']['prices'][0]['nr_of_cycles']);
    }

    /** @test */
    public function convert_product_pricing_prices_first(): void
    {
        $product = $this->makeBaseProduct()->setPricing(
            (new Pricing())->setPrices([
                (new Price())
                    ->setFirst((new PriceFirst())
                        ->setAmount(10)
                        ->setAmountWithTax(12.1)),
            ])
        );

        $body = ProductToBody::build($product);

        static::assertSame(10.0, $body['pricing']['prices'][0]['first']['amount']);
        static::assertSame(12.10, $body['pricing']['prices'][0]['first']['amount_with_tax']);
    }

    /** @test */
    public function convert_product_pricing_prices_original(): void
    {
        $product = $this->makeBaseProduct()->setPricing(
            (new Pricing())->setPrices([
                (new Price())
                    ->setOriginal((new PriceOriginal())
                        ->setAmount(10)
                        ->setAmountWithTax(12.1)),
            ])
        );

        $body = ProductToBody::build($product);

        static::assertSame(10.0, $body['pricing']['prices'][0]['original']['amount']);
        static::assertSame(12.10, $body['pricing']['prices'][0]['original']['amount_with_tax']);
    }

    /** @test */
    public function convert_product_pricing_prices_tiers(): void
    {
        $product = $this->makeBaseProduct()->setPricing(
            (new Pricing())->setPrices([
                (new Price())
                    ->setTiers([
                            (new PriceTier())
                                ->setAmount(10)
                                ->setAmountWithTax(12.1)
                                ->setQuantity(2),
                        ]
                    ),
            ])
        );

        $body = ProductToBody::build($product);

        static::assertSame(10.0, $body['pricing']['prices'][0]['tiers'][0]['amount']);
        static::assertSame(12.10, $body['pricing']['prices'][0]['tiers'][0]['amount_with_tax']);
        static::assertSame(2, $body['pricing']['prices'][0]['tiers'][0]['quantity']);
    }

    /** @test */
    public function convert_product_pricing_shipping(): void
    {
        $product = $this->makeBaseProduct()->setPricing(
            (new Pricing())->setShipping(
                (new Shipping())
                    ->setAmount(10)
                    ->setAmountWithTax(12.1)
            )
        );

        $body = ProductToBody::build($product);

        static::assertSame(10.0, $body['pricing']['shipping']['amount']);
        static::assertSame(12.10, $body['pricing']['shipping']['amount_with_tax']);
    }

    /** @test */
    public function convert_product_pricing_tax_rate(): void
    {
        $product = $this->makeBaseProduct()->setPricing(
            (new Pricing())->setTax(
                (new PricingTax())->setRate(
                    (new TaxRate())
                        ->setId(123)
                )
            )
        );

        $body = ProductToBody::build($product);

        static::assertSame(123, $body['pricing']['tax']['rate']['id']);
    }

    /** @test */
    public function convert_product_pricing_tax_profile(): void
    {
        $product = $this->makeBaseProduct()->setPricing(
            (new Pricing())->setTax(
                (new PricingTax())->setProfile(
                    (new TaxProfile())
                        ->setId(123)
                )
            )
        );

        $body = ProductToBody::build($product);

        static::assertSame(123, $body['pricing']['tax']['profile']['id']);
    }

    /** @test */
    public function convert_product_pricing_trial(): void
    {
        $product = $this->makeBaseProduct()->setPricing(
            (new Pricing())->setTrial(
                (new PricingTrial())
                    ->setAmount(10)
                    ->setAmountWithTax(12.1)
                    ->setDuration(14)
            )
        );

        $body = ProductToBody::build($product);

        static::assertSame(10.0, $body['pricing']['trial']['amount']);
        static::assertSame(12.10, $body['pricing']['trial']['amount_with_tax']);
        static::assertSame(14, $body['pricing']['trial']['duration']);
    }

    /** @test */
    public function store_basic_product(): void
    {
        $client  = new ProductStoreMockClient();
        $service = new ProductService($client);

        $product = $this->makeBaseProduct();
        $product->setType(ProductType::SUBSCRIPTION);
        $product = $service->create($product);

        static::assertEquals(1, $product->id());

        static::assertEquals('/v2/products', $client->path());
        static::assertEquals(1, $product->id());
        static::assertEquals('subscription', $client->requestBody()['type']);
    }

    /** @test */
    public function store_product_basic_pricing(): void
    {
        $client  = new ProductStoreMockClient();
        $service = new ProductService($client);

        $product = $this->makeBaseProduct();
        $product->pricing()->setTaxIncluded(true);
        $service->create($product);

        static::assertEquals(true, $client->requestBody()['pricing']['is_tax_included']);
    }

    /** @test */
    public function store_product_including_relation_pricing(): void
    {
        $client  = new ProductStoreMockClient();
        $service = (new ProductService($client))->include(ProductIncludes::PRICING);

        $product = $this->makeBaseProduct();
        $service->create($product);

        static::assertEquals('/v2/products?include=pricing', $client->path());
    }

    /** @test */
    public function store_product_including_relation_tax_rates(): void
    {
        $client  = (new ProductStoreMockClient());
        $service = (new ProductService($client))->include(ProductIncludes::TAX_RATES);

        $product = $this->makeBaseProduct();
        $service->create($product);

        static::assertEquals('/v2/products?include=tax_rates', $client->path());
    }

    private function makeBaseProduct(): Product
    {
        return (new Product())->setTitle('Pencil');
    }
}
