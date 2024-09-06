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
    public const BASIC_PRODUCT = [
        'created_at'   => '2019-01-16T00:00:00.000000Z',
        'deleted_at'   => '2019-01-16T00:00:00.000000Z',
        'description'  => 'Quisquam recusandae asperiores accusamus',
        'id'           => 1,
        'is_physical'  => false,
        'ledger'       => null,
        'public_title' => 'culpa',
        'sku'          => '70291520',
        'slug'         => null,
        'stock'        => [
            'is_enabled' => false,
        ],
        'title'        => 'culpa',
        'type'         => 'one_off',
        'updated_at'   => '2019-01-16T00:00:00.000000Z',
    ];
    protected string $path;

    public function __construct(int $status = 200, array $data = [])
    {
        parent::__construct($status, $data);

        $this->responseBody = ['data' => $data + self::BASIC_CHECKOUT];
    }

    public function product(array $data = []): self
    {
        $this->responseBody['data']['product'] = $data + self::BASIC_PRODUCT;

        return $this;
    }

    public function productPricing(array $pricing = []): self
    {
        $productData = self::BASIC_PRODUCT;
        $productData['pricing'] = $pricing + [
                'is_tax_included' => false,
                'discount_type'   => 'sale',
                'prices'          => [
                    [
                        'id'           => 10,
                        'first'        => null,
                        'interval'     => null,
                        'is_suggested' => false,
                        'nr_of_cycles' => null,
                        'original'     => null,
                        'regular'      => [
                            'amount'          => '100.00',
                            'amount_with_tax' => '121.00',
                        ],
                        'tiers'        => [],
                    ],
                ],
                'shipping'        => null,
                'tax'             => [
                    'rate' => [
                        'id'         => 1234,
                        'country'    => 'NL',
                        'percentage' => '6.0',
                    ],
                ],
                'trial'           => null,
            ];

        // Assign the complete product data with pricing to the response body
        $this->responseBody['data']['product'] = $productData;

        return $this;
    }
}
