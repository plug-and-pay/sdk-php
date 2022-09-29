<?php /** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

namespace PlugAndPay\Sdk\Tests\Feature\Subscription;

use PHPUnit\Framework\TestCase;
use PlugAndPay\Sdk\Entity\Response;
use PlugAndPay\Sdk\Exception\NotFoundException;
use PlugAndPay\Sdk\Exception\UnauthenticatedException;
use PlugAndPay\Sdk\Service\SubscriptionService;
use PlugAndPay\Sdk\Tests\Feature\Subscription\Mock\SubscriptionDestroyMockClient;

class DestroySubscriptionTest extends TestCase
{
    /** @test */
    public function delete_subscription_not_found(): void
    {
        $client  = new SubscriptionDestroyMockClient(Response::HTTP_NOT_FOUND, []);
        $service = new SubscriptionService($client);
        $exception = null;

        try {
            $service->delete(1);
        } catch (NotFoundException $exception) {
        }

        static::assertInstanceOf(NotFoundException::class, $exception);
    }

    /** @test */
    public function delete_subscription_unauthenticated(): void
    {
        $client  = new SubscriptionDestroyMockClient(Response::HTTP_UNAUTHORIZED, []);
        $service = new SubscriptionService($client);
        $exception = null;

        try {
            $service->delete(1);
        } catch (UnauthenticatedException $exception) {
        }

        static::assertInstanceOf(UnauthenticatedException::class, $exception);
    }

    /** @test */
    public function delete_basic_subscription(): void
    {
        $client  = new SubscriptionDestroyMockClient(Response::HTTP_NO_CONTENT, []);
        $service = new SubscriptionService($client);

        $service->delete(1);

        static::assertEquals('/v2/subscriptions/1', $client->path());
    }
}
