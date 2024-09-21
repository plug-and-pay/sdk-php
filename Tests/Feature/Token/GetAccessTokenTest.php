<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Tests\Feature\Token;

use PHPUnit\Framework\TestCase;
use PlugAndPay\Sdk\Tests\Feature\ClientMock;

class GetAccessTokenTest extends TestCase
{
    /** @test */
    public function it_should_return_access_token(): void
    {
        $client   = new ClientMock(200, ['access_token' => 'token']);
        $response = $client->getAccessToken('code', 'codeVerifier', 'redirectUri', 123);

        $this->assertEquals(200, $response->status());
        $this->assertEquals([
            'access_token' => 'token',
            'code'         => 'code',
            'codeVerifier' => 'codeVerifier',
            'redirectUri'  => 'redirectUri',
            'clientId'     => 123,
        ], $response->body());
    }
}
