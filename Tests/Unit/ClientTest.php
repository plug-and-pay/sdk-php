<?php

namespace PlugAndPay\Sdk\Tests\Unit;

use PHPUnit\Framework\TestCase;
use PlugAndPay\Sdk\Entity\Response;
use PlugAndPay\Sdk\Service\Client;
use PlugAndPay\Sdk\Service\TokenService;

class ClientTest extends TestCase
{
    /** @test */
    public function it_should_return_random_string(): void
    {
        $length = 10;

        $randomString = Client::getRandomString($length);

        $this->assertIsString($randomString);
        $this->assertEquals($length, strlen($randomString));
    }

    /** @test */
    public function it_should_return_authorization_url(): void
    {
        $clientId     = 123;
        $state        = 'testState';
        $codeVerifier = 'testVerifier';
        $redirectUrl  = 'https://example.com/callback';

        $client = new Client();
        $url    = $client->generateAuthorizationUrl($clientId, $state, $codeVerifier, $redirectUrl);

        $this->assertStringContainsString('client_id=123', $url);
        $this->assertStringContainsString('state=testState', $url);
        $this->assertStringContainsString('redirect_uri=https%3A%2F%2Fexample.com%2Fcallback', $url);
    }

    /** @test */
    public function it_should_return_credentials(): void
    {
        $code         = 'testCode';
        $codeVerifier = 'testVerifier';
        $redirectUrl  = 'https://example.com/callback';
        $clientId     = 123;
        $testTenantId = 456;

        $mockResponse     = new Response(200, ['access_token' => 'testAccessToken', 'refresh_token' => 'testRefreshToken']);
        $mockGuzzleClient = $this->createMock(Client::class);
        $mockGuzzleClient->method('getCredentials')->willReturn($mockResponse);

        $response = $mockGuzzleClient->getCredentials($code, $codeVerifier, $redirectUrl, $clientId, $testTenantId);

        $this->assertEquals(200, $response->status());
        $this->assertEquals('testAccessToken', $response->body()['access_token']);
    }

    /** @test */
    public function it_should_refresh_access_token(): void
    {
        // Given
        $refreshToken       = 'testRefreshToken';
        $clientId           = 123;
        $newAccessToken     = 'newAccessToken';
        $tenantId           = 3;

        $mockResponse = new Response(200, ['access_token' => $newAccessToken, 'refreshed' => true]);

        $mockGuzzleClient = $this->createMock(Client::class);
        $mockGuzzleClient->method('refreshTokensIfNeeded')->willReturn($mockResponse);

        $mockTokenService = $this->createMock(TokenService::class);
        $mockTokenService->method('isValid')->willReturn(false);

        // When
        $response = $mockGuzzleClient->refreshTokensIfNeeded($refreshToken, $clientId, $tenantId);

        // Then
        $this->assertEquals(200, $response->status());
        $this->assertEquals($newAccessToken, $response->body()['access_token']);
        $this->assertTrue($response->body()['refreshed']);
    }

    /** @test */
    public function it_should_not_refresh_access_token_when_valid(): void
    {
        // Given
        $refreshToken       = 'testRefreshToken';
        $clientId           = 123;
        $tenantId           = 3;

        $mockResponse = new Response(200, ['refreshed' => false]);

        $mockTokenService = $this->createMock(TokenService::class);
        $mockTokenService->method('isValid')->willReturn(true);

        $mockGuzzleClient = $this->createMock(Client::class);
        $mockGuzzleClient->method('refreshTokensIfNeeded')->willReturn($mockResponse);

        // When
        $response = $mockGuzzleClient->refreshTokensIfNeeded($refreshToken, $clientId, $tenantId);

        // Then
        $this->assertEquals(200, $response->status());
        $this->assertFalse($response->body()['refreshed']);
    }

    /** @test */
    public function it_should_revoke_tokens(): void
    {
        // Given
        $mockResponse = new Response(200, ['revoked' => true]);

        $mockGuzzleClient = $this->createMock(Client::class);
        $mockGuzzleClient->method('revokeTokens')->willReturn($mockResponse);

        // When
        $response = $mockGuzzleClient->revokeTokens();

        // Then
        $this->assertEquals(200, $response->status());
        $this->assertTrue($response->body()['revoked']);
    }
}
