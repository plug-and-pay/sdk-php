<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Tests\Feature\Rule\Mock;

use PlugAndPay\Sdk\Entity\Response;
use PlugAndPay\Sdk\Tests\Feature\ClientMock;

class IndexRulesMockClient extends ClientMock
{
    private string $path;

    public function __construct(array $data = [ShowRuleMockClient::BASIC_RULE])
    {
        parent::__construct(data: $data);
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
