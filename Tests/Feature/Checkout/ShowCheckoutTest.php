<?php

namespace PlugAndPay\Sdk\Tests\Feature\Checkout;

use PHPUnit\Framework\TestCase;
use PlugAndPay\Sdk\Entity\Checkout;
use PlugAndPay\Sdk\Entity\Response;
use PlugAndPay\Sdk\Enum\CheckoutIncludes;
use PlugAndPay\Sdk\Exception\NotFoundException;
use PlugAndPay\Sdk\Exception\RelationNotLoadedException;
use PlugAndPay\Sdk\Exception\UnauthenticatedException;
use PlugAndPay\Sdk\Service\CheckoutService;
use PlugAndPay\Sdk\Tests\Feature\Checkout\Mock\CheckoutShowMockClient;

class ShowCheckoutTest extends TestCase
{
    /** @test */
    public function it_should_throw_unauthorized_exception(): void
    {
        $client    = new CheckoutShowMockClient(status: Response::HTTP_UNAUTHORIZED);
        $service   = new CheckoutService($client);
        $exception = null;

        try {
            $service->find(999);
        } catch (UnauthenticatedException $exception) {
        }

        static::assertEquals('Unable to connect with Plug&Pay. Request is unauthenticated.', $exception->getMessage());
    }

    /** @test */
    public function it_should_throw_not_found_when_checkout_not_found(): void
    {
        $client    = new CheckoutShowMockClient(status: Response::HTTP_NOT_FOUND);
        $service   = new CheckoutService($client);
        $exception = null;

        try {
            $service->find(999);
        } catch (NotFoundException $exception) {
        }

        static::assertEquals('Not found', $exception->getMessage());
    }

    /** @test */
    public function it_should_return_basic_order(): void
    {
        $client  = new CheckoutShowMockClient(status: 200, data: ['id' => 1]);
        $service = new CheckoutService($client);

        $checkout = $service->find(1);

        static::assertSame(1, $checkout->id());
        static::assertFalse($checkout->hasRedirects());
        static::assertTrue($checkout->isActive());
        static::assertFalse($checkout->isBlueprint());
        static::assertFalse($checkout->isExpired());
        static::assertSame('lorem-ipsum-test', $checkout->name());
        static::assertNull($checkout->pixel());
        static::assertSame('https://example.com/preview-url', $checkout->previewUrl());
        static::assertSame('#ff0000', $checkout->primaryColor());
        static::assertSame('https://example.com/return-url', $checkout->returnUrl());
        static::assertSame('#00ff00', $checkout->secondaryColor());
        static::assertSame('lorem-ipsum-test', $checkout->slug());
        static::assertNull($checkout->splitTestId());
        static::assertSame('https://example.com/url', $checkout->url());
        static::assertSame('2019-01-16 00:00:00', $checkout->createdAt()->format('Y-m-d H:i:s'));
        static::assertSame('2019-01-16 00:00:00', $checkout->updatedAt()->format('Y-m-d H:i:s'));
        static::assertSame('2019-01-16 00:00:00', $checkout->deletedAt()->format('Y-m-d H:i:s'));
    }

    /**
     * @test
     * @dataProvider relationsProvider
     */
    public function it_should_throw_exception_if_relation_not_found(string $relation): void
    {
        $exception = null;

        try {
            (new Checkout(false))->{$relation}();
        } catch (RelationNotLoadedException $exception) {
        }

        static::assertInstanceOf(RelationNotLoadedException::class, $exception);
    }

    /** @test */
    public function it_should_show_checkout_with_product_relation(): void
    {
        $client  = (new CheckoutShowMockClient(status: 200, data: ['id' => 1]))->product();
        $service = new CheckoutService($client);

        $checkout = $service->include(CheckoutIncludes::PRODUCT)->find(1);

        static::assertSame(1, $checkout->product()->id());
        static::assertSame('2019-01-16 00:00:00', $checkout->product()->createdAt()->format('Y-m-d H:i:s'));
        static::assertSame('2019-01-16 00:00:00', $checkout->product()->deletedAt()->format('Y-m-d H:i:s'));
        static::assertSame('Quisquam recusandae asperiores accusamus', $checkout->product()->description());
        static::assertFalse($checkout->product()->isPhysical());
        static::assertNull($checkout->product()->ledger());
        static::assertSame('culpa', $checkout->product()->publicTitle());
        static::assertSame('70291520', $checkout->product()->sku());
        static::assertNull($checkout->product()->slug());
        static::assertSame('culpa', $checkout->product()->title());
        static::assertSame('one_off', $checkout->product()->type()->value);
        static::assertSame('2019-01-16 00:00:00', $checkout->product()->updatedAt()->format('Y-m-d H:i:s'));
    }

    /** @test */
    public function it_should_show_checkout_with_pricing(): void
    {
        $client  = (new CheckoutShowMockClient(status: 200, data: ['id' => 1]))->productPricing();
        $service = new CheckoutService($client);

        $checkout = $service->include(CheckoutIncludes::PRODUCT_PRICING)->find(1);

        static::assertSame(false, $checkout->product()->pricing()->isTaxIncluded());
        static::assertSame(null, $checkout->product()->pricing()->shipping());
        static::assertSame(null, $checkout->product()->pricing()->trial());
    }

    public static function relationsProvider(): array
    {
        return [
            CheckoutIncludes::PRODUCT->value         => ['product'],
            CheckoutIncludes::PRODUCT_PRICING->value => ['productPricing'],
        ];
    }
}
