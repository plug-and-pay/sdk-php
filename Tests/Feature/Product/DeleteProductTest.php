<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Tests\Feature\Product;

use PHPUnit\Framework\TestCase;
use PlugAndPay\Sdk\Entity\Response;
use PlugAndPay\Sdk\Exception\NotFoundException;
use PlugAndPay\Sdk\Exception\UnauthenticatedException;
use PlugAndPay\Sdk\Service\ProductService;
use PlugAndPay\Sdk\Tests\Feature\Product\Mock\ProductDestroyMockClient;

class DeleteProductTest extends TestCase
{
    /** @test */
    public function delete_product_not_fount_test(): void
    {
        $client  = new ProductDestroyMockClient(Response::HTTP_NOT_FOUND);
        $service = new ProductService($client);
        $exception = null;

        try {
            $service->delete(1);
        } catch (NotFoundException $exception) {
        }

        static::assertInstanceOf(NotFoundException::class, $exception);
    }

    /** @test */
    public function delete_product_unauthenticated(): void
    {
        $client  = new ProductDestroyMockClient(Response::HTTP_UNAUTHORIZED, []);
        $service = new ProductService($client);
        $exception = null;

        try {
            $service->delete(1);
        } catch (UnauthenticatedException $exception) {
        }

        static::assertInstanceOf(UnauthenticatedException::class, $exception);
    }

    /** @test */
    public function delete_existing_product(): void
    {
        $client  = new ProductDestroyMockClient(Response::HTTP_NO_CONTENT, []);
        $service = new ProductService($client);

        $service->delete(1);

        static::assertEquals('/v2/products/1', $client->path());
    }
}
