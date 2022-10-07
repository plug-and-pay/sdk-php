<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Tests\Feature\Order\Mock;

use JsonException;
use PlugAndPay\Sdk\Entity\Response;
use PlugAndPay\Sdk\Exception\ExceptionFactory;
use PlugAndPay\Sdk\Exception\NotFoundException;
use PlugAndPay\Sdk\Exception\ValidationException;
use PlugAndPay\Sdk\Tests\Feature\ClientMock;

class OrderShowMockClient extends ClientMock
{
    public const BASIC_ORDER = [
        'id'              => 1,
        'amount'          => '75.00',
        'amount_with_tax' => '75.00',
        'created_at'      => '2019-01-16T00:00:00.000000Z',
        'customer_id'     => 'qfeio43asdf1f11',
        'deleted_at'      => '2019-01-16T00:00:00.000000Z',
        'invoice_number'  => '20214019-T',
        'invoice_status'  => 'concept',
        'is_first'        => true,
        'is_hidden'       => false,
        'mode'            => 'live',
        'reference'       => '0b13e52d-b058-32fb-8507-10dec634a07c',
        'source'          => 'api',
        'updated_at'      => '2019-01-16T00:00:00.000000Z',
    ];
    protected string $path;

    /** @noinspection PhpMissingParentConstructorInspection */
    public function __construct(array $data = [])
    {
        $this->responseBody = ['data' => $data + self::BASIC_ORDER];
    }

    public function billing(array $data = []): self
    {
        $this->responseBody['data']['billing'] = $data + [
                'address' => [
                    'city'        => '\'t Veld',
                    'country'     => 'NL',
                    'street'      => 'Sanderslaan',
                    'housenumber' => '42',
                    'zipcode'     => '1448VB',
                ],
                'contact' => [
                    'company'       => 'Café Timmermans & Zn',
                    'email'         => 'rosalie39@example.net',
                    'firstname'     => 'Bilal',
                    'invoice_email' => 'maarten.veenstra@example.net',
                    'lastname'      => 'de Wit',
                    'tax_exempt'    => 'none',
                    'telephone'     => '(044) 4362837',
                    'website'       => 'https://www.vandewater.nl/velit-porro-ut-velit-soluta.html',
                    'vat_id_number' => 'NL000099998B57',
                ],
            ];

        return $this;
    }

    public function billingOnlyRequired(array $data = []): self
    {
        $this->responseBody['data']['billing'] = $data + [
                'address' => [
                    'city'        => null,
                    'country'     => null,
                    'street'      => null,
                    'housenumber' => null,
                    'zipcode'     => null,
                ],
                'contact' => [
                    'company'       => null,
                    'email'         => 'rosalie39@example.net',
                    'firstname'     => 'Bilal',
                    'invoice_email' => null,
                    'lastname'      => 'de Wit',
                    'tax_exempt'    => 'none',
                    'telephone'     => null,
                    'website'       => null,
                    'vat_id_number' => null,
                ],
            ];

        return $this;
    }

    public function comments(array $data = []): self
    {
        $this->responseBody['data']['comments'] = $data + [
                [
                    'created_at' => '2019-01-16T12:00:00.000000Z',
                    'id'         => 1,
                    'updated_at' => '2019-01-17T12:10:00.000000Z',
                    'value'      => 'Nice products',
                ],
            ];

        return $this;
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

    public function items(array $data = []): self
    {
        $this->responseBody['data']['items'] = [
            $data + [
                'id'              => 1,
                'discounts'       => [],
                'product_id'      => 1,
                'label'           => 'culpa',
                'quantity'        => 1,
                'type'            => null,
                'amount'          => '75.00',
                'amount_with_tax' => '90.75',
            ],
        ];

        return $this;
    }

    public function path(): string
    {
        return $this->path;
    }

    public function paymentOnlyBasic(array $data = []): self
    {
        $this->responseBody['data']['payment'] = $data + [
                'customer_id'    => null,
                'mandate_id'     => null,
                'method'         => null,
                'order_id'       => 1,
                'paid_at'        => null,
                'provider'       => null,
                'status'         => 'open',
                'transaction_id' => null,
                'type'           => 'mail',
                'url'            => 'https://consequatur-quisquam.testing.test/orders/payment-link/0b13e52d-b058-32fb-8507-10dec634a07c',
            ];

        return $this;
    }

    public function payment(array $data = []): self
    {
        $this->responseBody['data']['payment'] = $data + [
                'customer_id'    => 'qfeio43asdf1f11',
                'mandate_id'     => 'qwertyasdf',
                'method'         => 'banktransfer',
                'order_id'       => 1,
                'paid_at'        => '2019-01-19T00:00:00.000000Z',
                'provider'       => 'mollie',
                'status'         => 'paid',
                'transaction_id' => 'tr_123456mock',
                'type'           => 'mandate',
                'url'            => 'https://consequatur-quisquam.testing.test/orders/payment-link/0b13e52d-b058-32fb-8507-10dec634a07c',
            ];

        return $this;
    }

    public function discounts(array $data = []): self
    {
        $this->responseBody['data']['total_discounts'] = $data + [
                [
                    'amount'          => '100.00',
                    'amount_with_tax' => '121.00',
                    'code'            => 'u4lbf3',
                    'type'            => 'promotion',
                ],
            ];

        return $this->items(['discounts' => [
            [
                'amount'          => '10.00',
                'amount_with_tax' => '12.10',
                'code'            => 'u4lbf3',
                'type'            => 'promotion',
            ],
        ]]);
    }

    public function tags(array $data): self
    {
        $this->responseBody['data']['tags'] = $data;

        return $this;
    }

    public function taxes(): self
    {
        $this->items();

        $this->responseBody['data']['items'][0]['tax'] = [
            'amount'          => '10.00',
            'amount_with_tax' => '12.10',
            'rate'            => [
                'country'    => 'NL',
                'id'         => 57,
                'percentage' => '21.0',
            ],
        ];

        $this->responseBody['data']['taxes'] = [
            [
                'amount'          => '10.00',
                'amount_with_tax' => '12.10',
                'rate'            => [
                    'country'    => 'NL',
                    'id'         => 57,
                    'percentage' => '21.0',
                ],
            ],
        ];

        return $this;
    }
}
