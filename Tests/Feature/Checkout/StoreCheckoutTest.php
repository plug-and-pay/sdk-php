<?php

/** @noinspection EfferentObjectCouplingInspection */
/* @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

namespace PlugAndPay\Sdk\Tests\Feature\Checkout;

use BadFunctionCallException;
use PHPUnit\Framework\TestCase;
use PlugAndPay\Sdk\Director\ToBody\CheckoutToBody;
use PlugAndPay\Sdk\Entity\Checkout;
use PlugAndPay\Sdk\Entity\Response;
use PlugAndPay\Sdk\Exception\ValidationException;
use PlugAndPay\Sdk\Service\CheckoutService;
use PlugAndPay\Sdk\Tests\Feature\Checkout\Mock\CheckoutStoreMockClient;
use PlugAndPay\Sdk\Tests\Feature\ClientMock;

class StoreCheckoutTest extends TestCase
{
    /** @test */
    public function it_should_throw_exception_when_calling_non_existing_method(): void
    {
        $exception = null;

        try {
            $checkout = new Checkout();
            $checkout->isset('bad_function');
        } catch (BadFunctionCallException $exception) {
        }

        static::assertInstanceOf(BadFunctionCallException::class, $exception);
    }

    /** @test */
    public function it_should_convert_basic_checkout_to_body(): void
    {
        $body = CheckoutToBody::build($this->generateCheckout());

        static::assertEquals([
            'is_active'       => true,
            'is_expired'      => false,
            'name'            => 'the-name',
            'preview_url'     => 'the-url',
            'primary_color'   => 'the-primary-color',
            'return_url'      => 'the-return-url',
            'secondary_color' => 'the-secondary-color',
            'slug'            => 'the-slug',
            'url'             => 'the-url',
            'product'         => [
                'id' => 1,
            ],
        ], $body);
    }

    /** @test */
    public function it_should_store_basic_checkout(): void
    {
        $client  = new CheckoutStoreMockClient();
        $service = new CheckoutService($client);

        $checkout = $this->generateCheckout();
        $checkout = $service->create($checkout);

        static::assertEquals('/v2/checkouts', $client->path());
        static::assertEquals(1, $checkout->id());
    }

    /** @test */
    public function create_order_with_validation_error(): void
    {
        $client    = new ClientMock(
            Response::HTTP_UNPROCESSABLE_ENTITY,
            [
                'message' => 'The given data was invalid.',
                'errors'  => [
                    'name' => [
                        'Naam is verplicht.',
                    ],
                ],
            ],
        );
        $service   = new CheckoutService($client);
        $exception = null;

        try {
            $service->find(1);
        } catch (ValidationException $exception) {
        }

        static::assertEquals('Naam is verplicht.', $exception->getMessage());
        static::assertEquals('Naam is verplicht.', $exception->errors()[0]->message());
        static::assertEquals('name', $exception->errors()[0]->field());
    }

    /** @test */
    public function create_order_with_multiple_validation_errors(): void
    {
        $client    = new ClientMock(
            Response::HTTP_UNPROCESSABLE_ENTITY,
            [
                'message' => 'The given data was invalid.',
                'errors'  => [
                    'name'      => [
                        'First error.',
                        'Second error.',
                    ],
                    'productId' => [
                        'Last error.',
                    ],
                ],
            ],
        );
        $service   = new CheckoutService($client);
        $exception = null;

        try {
            $service->find(1);
        } catch (ValidationException $exception) {
        }

        static::assertEquals('First error. Second error. Last error.', $exception->getMessage());
        static::assertEquals('First error.', $exception->errors()[0]->message());
        static::assertEquals('name', $exception->errors()[0]->field());
    }

    private function generateCheckout(): Checkout
    {
        return (new Checkout())
            ->setIsActive(true)
            ->setIsExpired(false)
            ->setName('the-name')
            ->setPreviewUrl('the-url')
            ->setPrimaryColor('the-primary-color')
            ->setProductId(1)
            ->setReturnUrl('the-return-url')
            ->setSecondaryColor('the-secondary-color')
            ->setSlug('the-slug')
            ->setUrl('the-url');
    }
}
