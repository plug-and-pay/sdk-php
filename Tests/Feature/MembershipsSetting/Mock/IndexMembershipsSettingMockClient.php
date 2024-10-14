<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Tests\Feature\MembershipsSetting\Mock;

use PlugAndPay\Sdk\Entity\Response;
use PlugAndPay\Sdk\Tests\Feature\ClientMock;

class IndexMembershipsSettingMockClient extends ClientMock
{
    private string $path;

    public function __construct(array $data = [ShowMembershipsSettingMockClient::BASIC_MEMBERSHIPS_SETTING])
    {
        parent::__construct(body: $data);
    }

    public function get(string $path): Response
    {
        $this->path = $path;

        return new Response(Response::HTTP_OK, ['data' => $this->responseBody]);
    }

    public function path(): string
    {
        return $this->path;
    }
}
