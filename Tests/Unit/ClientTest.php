<?php

namespace PlugAndPay\Sdk\Tests\Unit;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Psr7\Response as GuzzleResponse;
use PHPUnit\Framework\TestCase;
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

        $mockResponse     = new GuzzleResponse(200, [], json_encode(['access_token' => 'testAccessToken', 'refresh_token' => 'testRefreshToken'], JSON_THROW_ON_ERROR));
        $mockGuzzleClient = $this->createMock(GuzzleClient::class);
        $mockGuzzleClient->method('request')->willReturn($mockResponse);

        $client   = new Client(null, null, null, null, $mockGuzzleClient);
        $response = $client->getCredentials($code, $codeVerifier, $redirectUrl, $clientId);

        $this->assertEquals(200, $response->status());
        $this->assertEquals('testAccessToken', $response->body()['access_token']);
    }

    /** @test */
    public function it_should_refresh_access_token_if_needed(): void
    {
        $mockResponse     = new GuzzleResponse(200, [], json_encode(['access_token' => 'newAccessToken'], JSON_THROW_ON_ERROR));
        $mockGuzzleClient = $this->createMock(GuzzleClient::class);
        $mockGuzzleClient->method('request')->willReturn($mockResponse);

        $mockTokenService = $this->createMock(TokenService::class);
        $mockTokenService->method('isValid')->willReturn(false);

        $client = new Client('expiredAccessToken', 'expiredRefreshToken', null, 123, $mockGuzzleClient, $mockTokenService);

        $client->refreshAccessTokenIfNeeded();

        $this->assertEquals('newAccessToken', $client->getAccessToken());
    }

    /** @test */
    public function it_should_refresh_access_token(): void
    {
        $refreshToken = 'testRefreshToken';
        $clientId     = 123;

        $mockResponse     = new GuzzleResponse(200, [], json_encode(['access_token' => 'newAccessToken']));
        $mockGuzzleClient = $this->createMock(GuzzleClient::class);
        $mockGuzzleClient->method('request')->willReturn($mockResponse);

        $client   = new Client(null, null, null, null, $mockGuzzleClient);
        $response = $client->refreshAccessToken($refreshToken, $clientId);

        $this->assertEquals(200, $response->status());
        $this->assertEquals('newAccessToken', $response->body()['access_token']);
    }
}
