<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Tests\Feature\TaxRate\Mock;

use PlugAndPay\Sdk\Entity\Response;
use PlugAndPay\Sdk\Tests\Feature\ClientMock;

class TaxRatesIndexMockClient extends ClientMock
{
    private string $path;
    private const BASIC_COUNTRY = [
        'id'         => 1,
        'country'    => 'NL',
        'percentage' => '6.0',
    ];

    /** @noinspection PhpMissingParentConstructorInspection */
    public function __construct(array $data = [[]])
    {
        foreach ($data as $taxRateData) {
            $this->responseBody[] = $taxRateData + self::BASIC_COUNTRY;
        }
    }

    public function get(string $path): Response
    {
        $this->path = $path;

        return new Response(Response::HTTP_OK, ['data' => $this->responseBody]);
    }

    public function path(): string
    {
        return $this->path;
    }
}
