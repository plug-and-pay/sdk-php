<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Tests\Feature\MembershipsSetting\Mock;

use PlugAndPay\Sdk\Entity\Response;
use PlugAndPay\Sdk\Support\Arr;

class UpdateMembershipsSettingMockClient extends ShowMembershipsSettingMockClient
{
    protected array $requestBody;
    protected string $path;

    public function patch(string $path, array $data): Response
    {
        $this->responseBody = Arr::mergeDistinct($this->responseBody, ['data' => $data]);
        $this->path         = $path;
        $this->requestBody  = $data;

        return new Response(Response::HTTP_OK, $this->responseBody);
    }

    public function path(): string
    {
        return $this->path;
    }
}
