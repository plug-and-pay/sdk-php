<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Service;

use PlugAndPay\Sdk\Contract\ClientInterface;
use PlugAndPay\Sdk\Contract\ClientPatchInterface;
use PlugAndPay\Sdk\Director\BodyTo\BodyToRate;
use PlugAndPay\Sdk\Entity\Rate;
use PlugAndPay\Sdk\Enum\TaxRateIncludes;
use PlugAndPay\Sdk\Filters\TaxRateFilter;
use PlugAndPay\Sdk\Support\Parameters;

class TaxRateService
{
    private ClientPatchInterface $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function include(TaxRateIncludes ...$includes): self
    {
        $this->includes = $includes;

        return $this;
    }

    /**
     * @return Rate[]
     */
    public function get(TaxRateFilter $taxRateFilter = null): array
    {
        $query = Parameters::toString($taxRateFilter ? $taxRateFilter->parameters() : []);
        $response = $this->client->get("/v2/tax-rates$query");

        return BodyToRate::buildMulti($response->body()['data']);
    }
}
