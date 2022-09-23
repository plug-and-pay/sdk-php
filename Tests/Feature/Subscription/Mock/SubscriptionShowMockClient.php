<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Tests\Feature\Subscription\Mock;

use PlugAndPay\Sdk\Entity\Response;
use PlugAndPay\Sdk\Exception\ExceptionFactory;
use PlugAndPay\Sdk\Tests\Feature\ClientMock;

class SubscriptionShowMockClient extends ClientMock
{
    public const BASIC_SUBSCRIPTION = [
        "id"           => 1,
        "cancelled_at" => null,
        "created_at"   => "2022-09-20T08:15:24.000000Z",
        "deleted_at"   => null,
        "mode"         => 'live',
        'source'       => 'api',
        "status"       => 'active',
        "updated_at"   => "2022-09-20T08:15:24.000000Z",
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
        $response = new Response(Response::HTTP_OK, $this->responseBody);

        $exception = ExceptionFactory::create($response->status(), json_encode($response->body(), JSON_THROW_ON_ERROR));
        if ($exception) {
            throw $exception;
        }

        return $response;
    }

    public function billing(): self
    {
        $this->responseBody['data']['billing'] = [
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

    public function product(): self
    {
        $this->responseBody['data']['product'] = [
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

        return $this;
    }

    public function pricing(): self
    {
        $this->responseBody['data']['pricing'] = [
            'amount'          => '100.00',
            'amount_with_tax' => '121.00',
            'discounts'       => null,
            'quantity'        => 10,
            'tax'             => 21,
            'is_tax_included' => true,
        ];

        return $this;
    }

    public function trial(): self
    {
        $this->responseBody['data']['trial'] = [
            'end'       => '2019-01-16T00:00:00.000000Z',
            'is_active' => true,
            'start'     => '2019-01-16T00:00:00.000000Z',
        ];

        return $this;
    }

    public function tags(array $data): self
    {
        $this->responseBody['data']['tags'] = $data;

        return $this;
    }

    public function path(): string
    {
        return $this->path;
    }
}
