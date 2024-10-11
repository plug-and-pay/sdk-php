<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Service;

use PlugAndPay\Sdk\Contract\ClientInterface;
use PlugAndPay\Sdk\Director\BodyTo\BodyToMembershipsSetting;
use PlugAndPay\Sdk\Entity\MembershipsSetting;
use PlugAndPay\Sdk\Exception\DecodeResponseException;

class MembershipsSettingService
{
    private ClientInterface $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /** @throws DecodeResponseException */
    public function find(int $id): MembershipsSetting
    {
        $response = $this->client->get("/v2/memberships/settings/$id");

        return BodyToMembershipsSetting::build($response->body()['data']);
    }
}