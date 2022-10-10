<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Tests\Feature\Subscription\Mock;

use PlugAndPay\Sdk\Entity\Response;
use PlugAndPay\Sdk\Support\Arr;

class SubscriptionUpdateMockClient extends SubscriptionShowMockClient
{
    protected array $requestBody;

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
