<?php

declare(strict_types=1);

namespace Feature\MembershipsSetting;

use PHPUnit\Framework\TestCase;
use PlugAndPay\Sdk\Entity\MembershipsSetting;
use PlugAndPay\Sdk\Exception\DecodeResponseException;
use PlugAndPay\Sdk\Service\MembershipsSettingService;
use PlugAndPay\Sdk\Tests\Feature\MembershipsSetting\Mock\UpdateMembershipsSettingMockClient;

class UpdateMembershipsSettingTest extends TestCase
{
    /**
     * @test
     * @throws DecodeResponseException
     */
    public function it_should_update_basic_memberships_setting(): void
    {
        $client  = new UpdateMembershipsSettingMockClient();
        $service = new MembershipsSettingService($client);

        $membershipsSetting = $service->update(1, function (MembershipsSetting $membershipsSetting) {
            $membershipsSetting->setDriver('huddle');
        });

        static::assertEquals('huddle', $membershipsSetting->driver());
        static::assertEquals('/v2/memberships/settings/1', $client->path());
    }
}
