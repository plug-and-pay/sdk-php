<?php

/** @noinspection ThrowRawExceptionInspection */

declare(strict_types=1);

namespace PlugAndPay\Sdk\Tests\Feature\Product\Mock;

use Exception;
use JsonException;
use PlugAndPay\Sdk\Entity\Response;
use PlugAndPay\Sdk\Exception\ExceptionFactory;
use PlugAndPay\Sdk\Exception\NotFoundException;
use PlugAndPay\Sdk\Exception\ValidationException;
use PlugAndPay\Sdk\Tests\Feature\ClientMock;

class ProductShowMockClient extends ClientMock
{
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

    /** @noinspection PhpMissingParentConstructorInspection */
    public function __construct(array $data = [])
    {
        $this->responseBody = ['data' => $data + self::BASIC_PRODUCT];
    }

    /**
     * @throws NotFoundException
     * @throws ValidationException
     * @throws JsonException
     */
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

    public function pricingBasic(array $pricing = []): self
    {
        $this->responseBody['data']['pricing'] = $pricing + [
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

        return $this;
    }

    public function price(string $key, mixed $data): self
    {
        $this->responseBody['data']['pricing']['prices'][0][$key] = $data;

        return $this;
    }

    /**
     * @throws Exception
     */
    public function shipping(): self
    {
        if (!isset($this->responseBody['data']['pricing'])) {
            throw new Exception('Method pricingBasic is required to receive shipping');
        }

        $this->responseBody['data']['pricing']['shipping'] = [
            'amount'          => '10.00',
            'amount_with_tax' => '12.10',
        ];

        return $this;
    }

    public function taxProfile(bool $multipleRates = false, bool $emptyRates = false): self
    {
        $rates = [[
                      'id'         => 1234,
                      'country'    => 'NL',
                      'percentage' => '6.0',
                  ]];

        if ($multipleRates) {
            $rates[] = [
                'id'         => 5678,
                'country'    => 'BE',
                'percentage' => '3.0',
            ];
        }

        $this->responseBody['data']['pricing']['tax'] = [
            'profile' => [
                'id'          => 123,
                'is_editable' => false,
                'label'       => 'High rate',
                'rates'       => !$emptyRates ? $rates : [],
            ],
        ];

        return $this;
    }
}
