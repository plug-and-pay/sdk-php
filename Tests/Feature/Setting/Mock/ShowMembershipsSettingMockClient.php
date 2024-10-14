<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Tests\Feature\Setting\Mock;

use PlugAndPay\Sdk\Tests\Feature\ClientMock;

class ShowMembershipsSettingMockClient extends ClientMock
{
    public const BASIC_MEMBERSHIPS_SETTING = [
        'id'         => 1,
        'driver'     => 'huddle',
        'is_active'  => true,
        'tenant_id'  => 1,
        'api_token'  => 'secret_token',
        'created_at' => '2021-01-01T00:00:00Z',
        'updated_at' => null,
    ];

    public function __construct(int $status = 200, array $data = [])
    {
        parent::__construct($status, $data);

        $this->responseBody = ['data' => $data + self::BASIC_MEMBERSHIPS_SETTING];
    }
}
