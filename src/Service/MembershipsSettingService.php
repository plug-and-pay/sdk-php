<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Service;

use Exception;
use PlugAndPay\Sdk\Contract\ClientInterface;
use PlugAndPay\Sdk\Director\BodyTo\BodyToMembershipsSetting;
use PlugAndPay\Sdk\Director\ToBody\MembershipsSettingToBody;
use PlugAndPay\Sdk\Entity\MembershipsSetting;
use PlugAndPay\Sdk\Exception\DecodeResponseException;
use PlugAndPay\Sdk\Filters\MembershipsSettingFilter;
use PlugAndPay\Sdk\Support\Parameters;

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

    public function delete(int $membershipsSettingId): void
    {
        $this->client->delete("/v2/memberships/settings/$membershipsSettingId");
    }

    /** @throws Exception */
    public function get(?MembershipsSettingFilter $membershipsSettingsFilter = null): array
    {
        $membershipsSettingsFilter = $membershipsSettingsFilter ?? new MembershipsSettingFilter();
        $query                     = Parameters::toString($membershipsSettingsFilter->parameters());

        $response = $this->client->get("/v2/memberships/settings$query");

        return BodyToMembershipsSetting::buildMulti($response->body()['data']);
    }

    /** @throws DecodeResponseException */
    public function create(MembershipsSetting $membershipsSetting): MembershipsSetting
    {
        $body     = MembershipsSettingToBody::build($membershipsSetting);
        $response = $this->client->post('/v2/memberships/settings', $body);

        return BodyToMembershipsSetting::build($response->body()['data']);
    }

    /** @throws DecodeResponseException */
    public function update(int $membershipsSettingId, callable $update): MembershipsSetting
    {
        $membershipsSetting = new MembershipsSetting();
        $update($membershipsSetting);
        $body     = MembershipsSettingToBody::build($membershipsSetting);
        $response = $this->client->patch("/v2/memberships/settings/$membershipsSettingId", $body);

        return BodyToMembershipsSetting::build($response->body()['data']);
    }
}
