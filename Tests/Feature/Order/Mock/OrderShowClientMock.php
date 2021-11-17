<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Tests\Feature\Order\Mock;

use PlugAndPay\Sdk\Contract\ClientGetInterface;
use PlugAndPay\Sdk\Entity\Response;
use PlugAndPay\Sdk\Exception\ExceptionFactory;

class OrderShowClientMock implements ClientGetInterface
{
    public const RESPONSE_BASIC = [
        'created_at'     => '2019-01-16T00:00:00.000000Z',
        'deleted_at'     => '2019-01-16T00:00:00.000000Z',
        'id'             => 1,
        'invoice_number' => '20214019-T',
        'invoice_status' => 'concept',
        'is_first'       => true,
        'is_hidden'      => false,
        'mode'           => 'live',
        'reference'      => '0b13e52d-b058-32fb-8507-10dec634a07c',
        'source'         => 'api',
        'subtotal'       =>
            [
                'currency' => 'EUR',
                'value'    => '75.00',
            ],
        'total'          =>
            [
                'currency' => 'EUR',
                'value'    => '75.00',
            ],
        'updated_at'     => '2019-01-16T00:00:00.000000Z',
    ];
    protected string $path;
    protected array $response;

    public function __construct(array $data = [])
    {
        $this->response = $data + self::RESPONSE_BASIC;
    }

    public function billing(array $data = []): self
    {
        $this->response['billing'] = $data + [
                'address'       => [
                    'city'        => '\'t Veld',
                    'country'     => 'NL',
                    'street'      => 'Sanderslaan',
                    'housenumber' => '42',
                    'zipcode'     => '1448VB',
                ],
                'company'       => 'Café Timmermans & Zn',
                'email'         => 'rosalie39@example.net',
                'first_name'    => 'Bilal',
                'invoice_email' => 'maarten.veenstra@example.net',
                'last_name'     => 'de Wit',
                'telephone'     => '(044) 4362837',
                'website'       => 'https://www.vandewater.nl/velit-porro-ut-velit-soluta.html',
            ];

        return $this;
    }

    public function comments(array $data = []): self
    {
        $this->response['comments'] = $data + [
                [
                    'created_at' => '2019-01-16T12:00:00.000000Z',
                    'id'         => 1,
                    'updated_at' => '2019-01-17T12:10:00.000000Z',
                    'value'      => 'Nice products',
                ],
            ];
        return $this;
    }

    public function get(string $path): Response
    {
        $this->path = $path;
        $response   = new Response(Response::HTTP_OK, $this->response);

        $exception = ExceptionFactory::create($response->status(), json_encode($response->body(), JSON_THROW_ON_ERROR));
        if ($exception) {
            throw $exception;
        }
        return $response;
    }

    public function items(array $data = []): self
    {
        $this->response['items'] = [
            $data + [
                'id'         => 1,
                'discounts'  => [],
                'product_id' => 1,
                'label'      => 'culpa',
                'quantity'   => 1,
                'type'       => null,
                'subtotal'   => ['currency' => 'EUR', 'value' => '75.00'],
                'total'      => ['currency' => 'EUR', 'value' => '90.75'],
            ],
        ];

        return $this;
    }

    public function path(): string
    {
        return $this->path;
    }

    public function payment(array $data = []): self
    {
        $this->response['payment'] = $data + [
                'order_id' => 1,
                'paid_at'  => '2019-01-19T00:00:00.000000Z',
                'status'   => 'paid',
                'url'      => 'https://consequatur-quisquam.testing.test/orders/payment-link/0b13e52d-b058-32fb-8507-10dec634a07c',
            ];

        return $this;
    }

    public function discounts(array $data = []): self
    {
        $this->response['discounts'] = $data + [
                [
                    'amount' => ['currency' => 'EUR', 'value' => '11.05'],
                    'code'   => null,
                    'type'   => 'sale',
                ],
            ];

        return $this->items(['discounts' => [
            [
                'amount' => ['currency' => 'EUR', 'value' => '2.10'],
                'code'   => null,
                'type'   => 'sale',
            ],
        ]]);
    }

    public function tags(array $data): self
    {
        $this->response['tags'] = $data;

        return $this;
    }

    public function taxes(array $data = []): self
    {
        $this->items();

        $this->response['items'][0]['tax'] = [
            'amount' => [
                'currency' => 'EUR',
                'value'    => '15.75',
            ],
            'rate'   => [
                'country'    => 'NL',
                'percentage' => 21,
            ],
        ];

        $this->response['taxes'] = [
            [
                'amount' => [
                    'currency' => 'EUR',
                    'value'    => '15.75',
                ],
                'rate'   => [
                    'country'    => 'NL',
                    'percentage' => 21,
                ],
            ],
        ];

        return $this;
    }
}
