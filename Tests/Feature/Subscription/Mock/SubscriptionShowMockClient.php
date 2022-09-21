<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Tests\Feature\Subscription\Mock;

use PlugAndPay\Sdk\Entity\Response;
use PlugAndPay\Sdk\Enum\Source;
use PlugAndPay\Sdk\Exception\ExceptionFactory;
use PlugAndPay\Sdk\Tests\Feature\ClientMock;

class SubscriptionShowMockClient extends ClientMock
{
    public const BASIC_SUBSCRIPTION = [
        "id" => 1,
        "cancelled_at"  => null,
        "created_at"    => "2022-09-20T08:15:24.000000Z",
        "deleted_at"    => null,
        "mode"          => 'live',
        'source'        => 'api',
        "status"        => 'active',
        "updated_at"    => "2022-09-20T08:15:24.000000Z",
    ];
    protected string $path;

    /** @noinspection PhpMissingParentConstructorInspection */
    public function __construct(array $data = [])
    {
        $this->responseBody = ['data' => $data + self::BASIC_SUBSCRIPTION];
    }

    public function get(string $path): Response
    {
        $this->path = $path;
        $response   = new Response(Response::HTTP_OK, $this->responseBody);

        $exception = ExceptionFactory::create($response->status(), json_encode($response->body(), JSON_THROW_ON_ERROR));
        if ($exception) {
            throw $exception;
        }

        return $response;
    }

    public function path(): string
    {
        return $this->path;
    }
}
