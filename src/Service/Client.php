<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Service;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ClientException;
use PlugAndPay\Sdk\Contract\ClientInterface;
use PlugAndPay\Sdk\Entity\Response;
use PlugAndPay\Sdk\Exception\ExceptionFactory;
use Psr\Http\Message\ResponseInterface;

class Client implements ClientInterface
{
    private const METHOD_DELETE = 'DELETE';
    private const METHOD_GET = 'GET';
    private const METHOD_PATCH = 'PATCH';
    private const METHOD_POST = 'POST';

    /**
     * @var \GuzzleHttp\Client
     */
    private GuzzleClient $guzzleClient;

    public function __construct(string $baseUrl, string $secretToken, GuzzleClient $guzzleClient = null)
    {
        $this->guzzleClient = $guzzleClient ?? new GuzzleClient([
                'base_uri' => $baseUrl,
                'headers'  => [
                    'Accept'        => 'application/json',
                    'Authorization' => "Bearer $secretToken",
                ],
                'timeout'  => 25,
            ]);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonException
     * @throws \PlugAndPay\Sdk\Exception\NotFoundException
     * @throws \PlugAndPay\Sdk\Exception\ValidationException
     */
    public function delete(string $path): Response
    {
        $response = $this->request(self::METHOD_DELETE, $path);

        return new Response($response->getStatusCode());
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonException
     * @throws \PlugAndPay\Sdk\Exception\NotFoundException
     * @throws \PlugAndPay\Sdk\Exception\ValidationException
     */
    public function get(string $path): Response
    {
        $response = $this->request(self::METHOD_GET, $path);

        return $this->fromGuzzleResponse($response);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonException
     * @throws \PlugAndPay\Sdk\Exception\NotFoundException
     * @throws \PlugAndPay\Sdk\Exception\ValidationException
     */
    public function patch(string $path, array $body): Response
    {
        $response = $this->request(self::METHOD_PATCH, $path, $body);

        return $this->fromGuzzleResponse($response);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonException
     * @throws \PlugAndPay\Sdk\Exception\NotFoundException
     * @throws \PlugAndPay\Sdk\Exception\ValidationException
     */
    public function post(string $path, array $body): Response
    {
        $response = $this->request(self::METHOD_POST, $path, $body);

        return $this->fromGuzzleResponse($response);
    }

    /**
     * @throws \PlugAndPay\Sdk\Exception\NotFoundException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \PlugAndPay\Sdk\Exception\ValidationException
     * @throws \JsonException
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

    private function fromGuzzleResponse(ResponseInterface $response): Response
    {
        return new Response($response->getStatusCode(), json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR));
    }
}
