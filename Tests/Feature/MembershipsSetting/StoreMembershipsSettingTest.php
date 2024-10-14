<?php

declare(strict_types=1);

namespace Feature\MembershipsSetting;

use BadFunctionCallException;
use PHPUnit\Framework\TestCase;
use PlugAndPay\Sdk\Director\ToBody\MembershipsSettingToBody;
use PlugAndPay\Sdk\Entity\MembershipsSetting;
use PlugAndPay\Sdk\Service\MembershipsSettingService;
use PlugAndPay\Sdk\Tests\Feature\MembershipsSetting\Mock\StoreMembershipsSettingMockClient;

class StoreMembershipsSettingTest extends TestCase
{
    /** @test */
    public function it_should_return_bad_function_call_exception_with_unknown_field(): void
    {
        $exception = null;

        try {
            $rule = new MembershipsSetting();
            $rule->isset('bad_function');
        } catch (BadFunctionCallException $exception) {
        }

        static::assertInstanceOf(BadFunctionCallException::class, $exception);
    }

    /** @test */
    public function it_should_convert_basic_memberships_setting(): void
    {
        $membershipsSetting = $this->makeBasicMembershipsSetting();

        $body = MembershipsSettingToBody::build($membershipsSetting);

        static::assertSame('webhook', $body['driver']);
        static::assertTrue($body['is_active']);
        static::assertSame(1, $body['tenant_id']);
        static::assertSame('api_token', $body['api_token']);
    }

    /** @test */
    public function it_should_store_basic_memberships_setting(): void
    {
        $client  = new StoreMembershipsSettingMockClient();
        $service = new MembershipsSettingService($client);

        $membershipsSetting = $this->makeBasicMembershipsSetting();
        $membershipsSetting = $service->create($membershipsSetting);

        static::assertEquals('/v2/memberships/settings', $client->path());
        static::assertEquals(1, $membershipsSetting->id());
        static::assertEquals('api_token', $client->requestBody()['api_token']);
    }

    private function makeBasicMembershipsSetting(): MembershipsSetting
    {
        return (new MembershipsSetting)
            ->setDriver('webhook')
            ->setIsActive(true)
            ->setTenantId(1)
            ->setApiToken('api_token');

    }
}
