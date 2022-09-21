<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Tests\Feature\TaxRate;

use PHPUnit\Framework\TestCase;
use PlugAndPay\Sdk\Enum\CountryCode;
use PlugAndPay\Sdk\Filters\TaxRateFilter;
use PlugAndPay\Sdk\Service\TaxRateService;
use PlugAndPay\Sdk\Tests\Feature\TaxRate\Mock\TaxRatesIndexMockClient;

class IndexTaxRatesTest extends TestCase
{
    /** @test */
    public function index_products_get_all(): void
    {
        $client   = (new TaxRatesIndexMockClient());
        $service  = new TaxRateService($client);
        $taxRates = $service->get();

        static::assertSame(1, $taxRates[0]->id());
        static::assertSame('/v2/tax-rates', $client->path());
    }

    /**
     * @dataProvider taxRateFilterDataProvider
     * @test
     */
    public function index_tax_rate_with_filter(string $method, mixed $value, string $queryKey, string $queryValue): void
    {
        $client  = (new TaxRatesIndexMockClient());
        $service = new TaxRateService($client);

        $filter = (new TaxRateFilter())->$method($value);
        $service->get($filter);

        static::assertSame("/v2/tax-rates?$queryKey=$queryValue", $client->path());
    }

    public function taxRateFilterDataProvider(): array
    {
        return [
            [
                'method'     => 'country',
                'value'      => CountryCode::NL,
                'queryKey'   => 'country',
                'queryValue' => 'NL',
            ],
        ];
    }
}

