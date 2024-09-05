<?php

namespace PlugAndPay\Sdk\Tests\Feature\Checkout\Mock;

use PlugAndPay\Sdk\Tests\Feature\ClientMock;

class CheckoutShowMockClient extends ClientMock
{
    public const BASIC_CHECKOUT = [
        'id'              => 1,
        'is_active'       => true,
        'is_expired'      => false,
        'name'            => 'lorem-ipsum-test',
        'preview_url'     => 'https://example.com/preview-url',
        'primary_color'   => '#ff0000',
        'return_url'      => 'https://example.com/return-url',
        'secondary_color' => '#00ff00',
        'slug'            => 'lorem-ipsum-test',
        'url'             => 'https://example.com/url',
        'created_at'      => '2019-01-16T00:00:00.000000Z',
        'updated_at'      => '2019-01-16T00:00:00.000000Z',
        'deleted_at'      => '2019-01-16T00:00:00.000000Z',
    ];
    protected string $path;

    public function __construct(int $status = 200, array $data = [])
    {
        parent::__construct($status, $data);

        $this->responseBody = ['data' => $data + self::BASIC_CHECKOUT];
    }
}
