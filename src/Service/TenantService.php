<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Service;

use PlugAndPay\Sdk\Contract\ClientInterface;
use PlugAndPay\Sdk\Director\BodyTo\BodyToTenant;
use PlugAndPay\Sdk\Entity\Tenant;

class TenantService
{
    private ClientInterface $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function find(): Tenant
    {
        $response = $this->client->get('/v2/tenant/info');

        return BodyToTenant::build($response->body()['data']);
    }
}
