<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Service;

use PlugAndPay\Sdk\Contract\ClientInterface;
use PlugAndPay\Sdk\Director\BodyTo\BodyToAffiliateSeller;
use PlugAndPay\Sdk\Entity\AffiliateSeller;
use PlugAndPay\Sdk\Enum\AffiliateSellerIncludes;
use PlugAndPay\Sdk\Exception\DecodeResponseException;
use PlugAndPay\Sdk\Filters\AffiliateSellerFilter;
use PlugAndPay\Sdk\Support\Parameters;

class AffiliateSellerService
{
    private ClientInterface $client;

    /** @var string[] */
    private array $includes = [];

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function include(AffiliateSellerIncludes ...$includes): self
    {
        $this->includes = $includes;

        return $this;
    }

    /**
     * @throws DecodeResponseException
     */
    public function find(int $id): AffiliateSeller
    {
        $query    = Parameters::toString(['include' => $this->includes]);
        $response = $this->client->get("/v2/affiliates/sellers/$id$query");

        return BodyToAffiliateSeller::build($response->body()['data']);
    }

    /**
     * @return AffiliateSeller[]
     * @throws DecodeResponseException
     */
    public function get(?AffiliateSellerFilter $filter = null): array
    {
        $parameters = $filter ? $filter->parameters() : [];
        if (!empty($this->includes)) {
            $parameters['include'] = $this->includes;
        }
        $query = Parameters::toString($parameters);

        $response = $this->client->get("/v2/affiliates/sellers$query");

        return BodyToAffiliateSeller::buildMulti($response->body()['data']);
    }
}