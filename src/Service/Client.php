<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Service;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use JsonException;
use PlugAndPay\Sdk\Contract\ClientInterface;
use PlugAndPay\Sdk\Entity\Response;
use PlugAndPay\Sdk\Exception\ExceptionFactory;
use PlugAndPay\Sdk\Exception\InvalidTokenException;
use PlugAndPay\Sdk\Exception\NotFoundException;
use PlugAndPay\Sdk\Exception\ValidationException;
use PlugAndPay\Sdk\Support\Str;
use Psr\Http\Message\ResponseInterface;

/**
 * @codeCoverageIgnore
 */
class Client implements ClientInterface
{
    private const METHOD_DELETE = 'DELETE';
    private const METHOD_GET    = 'GET';
    private const METHOD_PATCH  = 'PATCH';
    private const METHOD_POST   = 'POST';

    private const BASE_API_URL_PRODUCTION = 'https://api.plugandpay.nl';

    /**
     * @var GuzzleClient
     */
    private GuzzleClient $guzzleClient;
    private string $baseUrl;
    private ?string $accessToken;
    private TokenService $tokenService;

    public function __construct(
        ?string $accessToken = null,
        string $baseUrl = null,
        ?GuzzleClient $guzzleClient = null,
        TokenService $tokenService = null
    ) {
        $this->baseUrl     = $baseUrl ?? self::BASE_API_URL_PRODUCTION;
        $this->accessToken = $accessToken;
        $this->createGuzzleClient($this->baseUrl, $this->accessToken, $guzzleClient);
        $this->tokenService = $tokenService ?? new TokenService(); // Initialize it
    }

    private function createGuzzleClient(
        string $baseUrl,
        ?string $accessToken,
        ?GuzzleClient $guzzleClient
    ): void {
        $headers = ['Accept' => 'application/json'];

        if ($accessToken) {
            $headers['Authorization'] = "Bearer $accessToken";
        }

        $this->guzzleClient = $guzzleClient ?? new GuzzleClient([
            'base_uri' => $baseUrl,
            'headers'  => $headers,
            'timeout'  => 25,
        ]);
    }

    /**
     * @throws GuzzleException
     * @throws JsonException
     * @throws NotFoundException
     * @throws ValidationException
     */
    public function delete(string $path): Response
    {
        $response = $this->request(self::METHOD_DELETE, $path);

        return new Response($response->getStatusCode());
    }

    /**
     * @throws GuzzleException
     * @throws JsonException
     * @throws NotFoundException
     * @throws ValidationException
     */
    public function deleteMany(string $path, array $data): Response
    {
        $response = $this->request(self::METHOD_DELETE, $path, $data);

        return new Response($response->getStatusCode());
    }

    /**
     * @throws GuzzleException
     * @throws JsonException
     * @throws NotFoundException
     * @throws ValidationException
     */
    public function get(string $path): Response
    {
        $response = $this->request(self::METHOD_GET, $path);

        return $this->fromGuzzleResponse($response);
    }

    /**
     * @throws GuzzleException
     * @throws JsonException
     * @throws NotFoundException
     * @throws ValidationException
     */
    public function patch(string $path, array $data): Response
    {
        $response = $this->request(self::METHOD_PATCH, $path, $data);

        return $this->fromGuzzleResponse($response);
    }

    /**
     * @throws GuzzleException
     * @throws JsonException
     * @throws NotFoundException
     * @throws ValidationException
     */
    public function post(string $path, array $body): Response
    {
        $response = $this->request(self::METHOD_POST, $path, $body);

        return $this->fromGuzzleResponse($response);
    }

    /**
     * @throws NotFoundException
     * @throws GuzzleException
     * @throws ValidationException
     * @throws JsonException
     */
    private function request(string $method, string $path, array $body = []): ResponseInterface
    {
        if (!empty($body)) {
            $options = [
                'json' => $body,
            ];
        }
        try {
            return $this->guzzleClient->request($method, $path, $options ?? []);
        } catch (ClientException $e) {
            $response = $e->getResponse();
            throw ExceptionFactory::create($response->getStatusCode(), $response->getBody()->getContents());
        }
    }

    /**
     * @throws JsonException
     */
    private function fromGuzzleResponse(ResponseInterface $response): Response
    {
        $content = $response->getBody()->getContents();

        return new Response($response->getStatusCode(), json_decode($content, true, 512, JSON_THROW_ON_ERROR));
    }

    /**
     * Generate a random string.
     */
    public static function getRandomString(int $length): string
    {
        return Str::random($length);
    }

    /**
     * Generate redirect URI for authorization code flow.
     */
    public function generateAuthorizationUrl(int $clientId, string $state, string $codeVerifier, string $redirectUrl): string
    {
        $codeChallenge = strtr(rtrim(
            base64_encode(hash('sha256', $codeVerifier, true)),
            '='
        ), '+/', '-_');

        $query = http_build_query([
            'client_id'             => $clientId,
            'redirect_uri'          => $redirectUrl,
            'response_type'         => 'code',
            'scope'                 => '',
            'state'                 => $state,
            'code_challenge'        => $codeChallenge,
            'code_challenge_method' => 'S256',
            'step'                  => 'select_tenant',
        ]);

        return $this->baseUrl . '/oauth/authorize?' . $query;
    }

    /**
     * Exchange authorization code for access token and refresh token.
     *
     * @throws GuzzleException
     * @throws JsonException
     * @throws NotFoundException
     * @throws ValidationException
     */
    public function getCredentials(string $code, string $codeVerifier, string $redirectUrl, int $clientId, int $tenantId): Response
    {
        $response = $this->request(self::METHOD_POST, '/oauth/token', [
            'grant_type'    => 'authorization_code',
            'client_id'     => $clientId,
            'redirect_uri'  => $redirectUrl,
            'code_verifier' => $codeVerifier,
            'code'          => $code,
            'tenant_id'     => $tenantId,
        ]);

        return $this->fromGuzzleResponse($response);
    }

    /**
     * Exchange refresh token for a new access token.
     *
     * @throws GuzzleException
     * @throws JsonException
     * @throws NotFoundException
     * @throws ValidationException
     * @throws InvalidTokenException
     */
    public function refreshTokensIfNeeded(string $refreshToken, int $clientId, int $tenantId): Response
    {
        if ($this->tokenService->isValid($this->accessToken)) {
            return new Response(200, ['refreshed' => false]);
        }

        $response = $this->request(self::METHOD_POST, '/oauth/token', [
            'grant_type'    => 'refresh_token',
            'client_id'     => $clientId,
            'refresh_token' => $refreshToken,
            'tenant_id'     => $tenantId,
        ]);

        $guzzleResponse = $this->fromGuzzleResponse($response);
        $responseData   = $guzzleResponse->body();

        // Update the Guzzle client with the new access token
        $this->createGuzzleClient(
            $this->baseUrl,
            $responseData['access_token'],
            null,
        );

        $this->accessToken = $responseData['access_token'];

        $responseData['refreshed'] = true;

        return new Response($guzzleResponse->status(), $responseData);
    }

    /**
     * @throws GuzzleException
     * @throws NotFoundException
     * @throws ValidationException
     * @throws JsonException
     */
    public function revokeTokens(): Response
    {
        $response = $this->request(self::METHOD_POST, '/v2/auth/oauth/revoke');

        return $this->fromGuzzleResponse($response);
    }
}
