<?php /** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

namespace PlugAndPay\Sdk\Tests\Feature\Product;

use PHPUnit\Framework\TestCase;
use PlugAndPay\Sdk\Entity\Product;
use PlugAndPay\Sdk\Enum\CountryCode;
use PlugAndPay\Sdk\Enum\PaymentStatus;
use PlugAndPay\Sdk\Service\ProductService;
use PlugAndPay\Sdk\Tests\Feature\Product\Mock\ProductUpdateMockClient;

class UpdateProductTest extends TestCase
{
    /** @test */
    public function update_basic_product(): void
    {
        $client = new ProductUpdateMockClient();
        $service = new ProductService($client);

        $product = $service->update(1, function (Product $product) {
            $product->setDescription('Lorem Ipsum');
        });

        static::assertEquals('Lorem Ipsum', $product->description());
        static::assertEquals('/v2/products/1', $client->path());
    }
}
