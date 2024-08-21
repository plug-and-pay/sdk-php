<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Service;

use PlugAndPay\Sdk\Contract\ClientInterface;
use PlugAndPay\Sdk\Director\BodyTo\BodyToRate;
use PlugAndPay\Sdk\Entity\TaxRate;
use PlugAndPay\Sdk\Filters\TaxRateFilter;
use PlugAndPay\Sdk\Support\Parameters;

class TaxRateService
{
    private ClientInterface $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @return TaxRate[]
     */
    public function get(TaxRateFilter $taxRateFilter = null): array
    {
        $query    = Parameters::toString($taxRateFilter ? $taxRateFilter->parameters() : []);
        $response = $this->client->get("/v2/tax-rates$query");

        return BodyToRate::buildMulti($response->body()['data']);
    }
}
