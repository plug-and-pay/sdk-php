<?php /** @noinspection PhpUnitTestsInspection */
/** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

namespace PlugAndPay\Sdk\Tests\Feature\Product;

use PHPUnit\Framework\TestCase;
use PlugAndPay\Sdk\Entity\Pricing;
use PlugAndPay\Sdk\Entity\Product;
use PlugAndPay\Sdk\Enum\ProductIncludes;
use PlugAndPay\Sdk\Exception\RelationNotLoadedException;
use PlugAndPay\Sdk\Service\ProductService;
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
        $product   = (new Product())->setPricing((new Pricing(false)));

        try {
            $product->pricing()->tax()->rate();
        } catch (RelationNotLoadedException $exception) {
        }

        static::assertInstanceOf(RelationNotLoadedException::class, $exception);
    }

    /** @test */
    public function show_product_pricing_basic(): void
    {
        $client  = (new ProductShowMockClient(['id' => 1]))->pricingBasic();
        $service = new ProductService($client);

        $product = $service->include(ProductIncludes::PRICING)->find(1);

        static::assertSame('/v2/products/1?include=pricing', $client->path());
        static::assertSame(false, $product->pricing()->isTaxIncluded());
        static::assertSame(null, $product->pricing()->shipping());
        static::assertSame(null, $product->pricing()->trial());
        static::assertSame(null, $product->pricing()->prices()[0]->first());
        static::assertSame(null, $product->pricing()->prices()[0]->interval());
        static::assertSame(false, $product->pricing()->prices()[0]->isSuggested());
        static::assertSame(1, $product->pricing()->prices()[0]->nrOfCycles());
        static::assertSame(null, $product->pricing()->prices()[0]->original());
    }

    /** @test */
    public function show_product_pricing_is_tax_included(): void
    {
        $client  = (new ProductShowMockClient(['id' => 1]))->pricingBasic([
            'is_tax_included' => true,
        ]);
        $service = new ProductService($client);

        $product = $service->include(ProductIncludes::PRICING)->find(1);

        static::assertSame(true, $product->pricing()->isTaxIncluded());
    }

    /** @test */
    public function show_product_pricing_with_tax_rate(): void
    {
        $client  = (new ProductShowMockClient(['id' => 1]))->pricingBasic();
        $service = new ProductService($client);

        $product = $service->include(ProductIncludes::PRICING)->find(1);

        static::assertSame(1234, $product->pricing()->tax()->rate()->id());
        static::assertSame('NL', $product->pricing()->tax()->rate()->country()->value);
        static::assertSame(6., $product->pricing()->tax()->rate()->percentage());
    }

    /** @test */
    public function show_product_pricing_with_tax_profile_one_rate(): void
    {
        $client  = (new ProductShowMockClient(['id' => 1]))
            ->pricingBasic()
            ->taxProfile();
        $service = new ProductService($client);

        $product = $service->include(ProductIncludes::PRICING)->find(1);

        static::assertSame(123, $product->pricing()->tax()->profile()->id());
        static::assertSame(false, $product->pricing()->tax()->profile()->isEditable());
        static::assertSame('High rate', $product->pricing()->tax()->profile()->label());
        static::assertSame(1234, $product->pricing()->tax()->profile()->rates()[0]->id());
    }

    /** @test */
    public function show_product_pricing_with_tax_profile_multiple_rates(): void
    {
        $client  = (new ProductShowMockClient(['id' => 1]))
            ->pricingBasic()
            ->taxProfile(multipleRates: true);
        $service = new ProductService($client);

        $product = $service->include(ProductIncludes::PRICING)->find(1);

        static::assertCount(2, $product->pricing()->tax()->profile()->rates());
    }

    /** @test */
    public function show_product_pricing_trial(): void
    {
        $client  = (new ProductShowMockClient(['id' => 1]))->pricingBasic([
            'trial' => [
                'amount'          => '10.00',
                'amount_with_tax' => '12.10',
                'duration'        => 15,
            ],
        ]);
        $service = new ProductService($client);

        $product = $service->include(ProductIncludes::PRICING)->find(1);

        static::assertSame(10., $product->pricing()->trial()->amount());
        static::assertSame(12.1, $product->pricing()->trial()->amountWithTax());
        static::assertSame(15, $product->pricing()->trial()->duration());
    }

    /** @test */
    public function show_product_pricing_with_basic_price(): void
    {
        $client  = (new ProductShowMockClient(['id' => 1]))->pricingBasic();
        $service = new ProductService($client);

        $product = $service->include(ProductIncludes::PRICING)->find(1);

        static::assertSame(10, $product->pricing()->prices()[0]->id());
        static::assertSame(null, $product->pricing()->prices()[0]->first());
        static::assertSame(null, $product->pricing()->prices()[0]->interval());
        static::assertSame(false, $product->pricing()->prices()[0]->isSuggested());
        static::assertSame(1, $product->pricing()->prices()[0]->nrOfCycles());
        static::assertSame(null, $product->pricing()->prices()[0]->original());
        static::assertSame(100., $product->pricing()->prices()[0]->regular()->amount());
        static::assertSame(121., $product->pricing()->prices()[0]->regular()->amountWithTax());
        static::assertSame([], $product->pricing()->prices()[0]->tiers());
    }

    /** @test */
    public function show_product_price_first(): void
    {
        $client  = (new ProductShowMockClient(['id' => 1]))->pricingBasic()->price('first', [
            'amount'          => '100.00',
            'amount_with_tax' => '121.00',
        ]);
        $service = new ProductService($client);

        $product = $service->include(ProductIncludes::PRICING)->find(1);

        static::assertSame(100., $product->pricing()->prices()[0]->first()->amount());
        static::assertSame(121., $product->pricing()->prices()[0]->first()->amountWithTax());
    }

    /** @test */
    public function show_product_price_interval(): void
    {
        $client  = (new ProductShowMockClient(['id' => 1]))->pricingBasic()->price('interval', 'monthly');
        $service = new ProductService($client);

        $product = $service->include(ProductIncludes::PRICING)->find(1);

        static::assertSame('monthly', $product->pricing()->prices()[0]->interval()->value);
    }

    /** @test */
    public function show_product_price_is_suggested(): void
    {
        $client  = (new ProductShowMockClient(['id' => 1]))->pricingBasic()->price('is_suggested', true);
        $service = new ProductService($client);

        $product = $service->include(ProductIncludes::PRICING)->find(1);

        static::assertSame(true, $product->pricing()->prices()[0]->isSuggested());
    }

    /** @test */
    public function show_product_price_nr_of_cycles(): void
    {
        $client  = (new ProductShowMockClient(['id' => 1]))->pricingBasic()->price('nr_of_cycles', 12);
        $service = new ProductService($client);

        $product = $service->include(ProductIncludes::PRICING)->find(1);

        static::assertSame(12, $product->pricing()->prices()[0]->nrOfCycles());
    }

    /** @test */
    public function show_product_price_original(): void
    {
        $client  = (new ProductShowMockClient(['id' => 1]))->pricingBasic()->price('original', [
            'amount'          => '100.00',
            'amount_with_tax' => '121.00',
        ]);
        $service = new ProductService($client);

        $product = $service->include(ProductIncludes::PRICING)->find(1);

        static::assertSame(100., $product->pricing()->prices()[0]->original()->amount());
        static::assertSame(121., $product->pricing()->prices()[0]->original()->amountWithTax());
    }

    /** @test */
    public function show_product_price_tiers(): void
    {
        $client  = (new ProductShowMockClient(['id' => 1]))->pricingBasic()->price('tiers', [
            [
                'amount'          => '100.00',
                'amount_with_tax' => '121.00',
                'quantity'        => 5,
            ],
        ]);
        $service = new ProductService($client);

        $product = $service->include(ProductIncludes::PRICING)->find(1);

        static::assertSame(100., $product->pricing()->prices()[0]->tiers()[0]->amount());
        static::assertSame(121., $product->pricing()->prices()[0]->tiers()[0]->amountWithTax());
        static::assertSame(5, $product->pricing()->prices()[0]->tiers()[0]->quantity());
    }
}
