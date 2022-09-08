<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Tests\Feature\Product\Mock;

use PlugAndPay\Sdk\Entity\Response;
use PlugAndPay\Sdk\Exception\ExceptionFactory;
use PlugAndPay\Sdk\Tests\Feature\ClientMock;

class ProductShowMockClient extends ClientMock
{
    public const BASIC_PRODUCT = [
        'created_at'   => '2019-01-16T00:00:00.000000Z',
        'deleted_at'   => '2019-01-16T00:00:00.000000Z',
        'description'  => 'Quisquam recusandae asperiores accusamus',
        'id'           => 1,
        'is_physical'  => false,
        'public_title' => 'culpa',
        'sku'          => '70291520',
        'slug'         => 'culpa',
        'title'        => 'culpa',
        'type'         => 'one_off',
        'updated_at'   => '2019-01-16T00:00:00.000000Z',
    ];
    protected string $path;

    /** @noinspection PhpMissingParentConstructorInspection */
    public function __construct(array $data = [])
    {
        $this->responseBody = ['data' => $data + self::BASIC_PRODUCT];
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

    public function pricing(): self
    {
        $this->responseBody['data']['pricing'] = [
            'is_tax_included' => true,
            'prices'          => [],
            'shipping'        => null,
            'tax'             => [
                'rate' => [
                    'id' => 1234,
                    'country' => 'NL',
                    'percentage' => '6.0'
                ],
            ],
            'trial' => null,
        ];

        return $this;
    }
}
