<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Tests\Feature\Order;

use PlugAndPay\Sdk\Contract\ClientGetInterface;
use PlugAndPay\Sdk\Entity\Response;

class OrderShowClientMock implements ClientGetInterface
{
    public const ORDER_BASIC = [
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

    private array $data;

    public function __construct(array $data = [])
    {
        $this->data = $data + self::ORDER_BASIC;
    }

    public function billing(array $data = []): self
    {
        $this->data['billing'] = $data + [
                'address'       => [
                    'city'          => '\'t Veld',
                    'country'       => 'NL',
                    'street'        => 'Sanderslaan',
                    'street_suffix' => '42',
                    'zipcode'       => '1448VB',
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
        $this->data['comments'] = $data + [
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
        return new Response(Response::HTTP_OK, $this->data);
    }

    public function payment(array $data = []): self
    {
        $this->data['payment'] = $data + [
                'order_id' => 1,
                'paid_at'  => '2019-01-19T00:00:00.000000Z',
                'status'   => 'paid',
                'url'      => 'https://consequatur-quisquam.testing.test/orders/payment-link/0b13e52d-b058-32fb-8507-10dec634a07c',
            ];

        return $this;
    }

    public function tags(array $data): self
    {
        $this->data['tags'] = $data;

        return $this;
    }

    public function taxes(array $data = []): self
    {
        $this->items();

        $this->data['items'][0]['tax'] = [
            'amount' => [
                'currency' => 'EUR',
                'value'    => '15.75',
            ],
            'rate'   => [
                'country'    => 'NL',
                'percentage' => 21,
            ],
        ];

        $this->data['taxes'] = [
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

    public function items(array $data = []): self
    {
        $this->data['items'] = [
            $data + [
                'id'           => 1,
                'discounts'    => [],
                'product_id'   => 1,
                'public_title' => 'culpa',
                'quantity'     => 1,
                'type'         => null,
                'subtotal'     => ['currency' => 'EUR', 'value' => '75.00'],
                'total'        => ['currency' => 'EUR', 'value' => '90.75'],
            ],
        ];

        return $this;
    }
}
