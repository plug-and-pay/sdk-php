<?php

/** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

namespace PlugAndPay\Sdk\Tests\Feature;

use PlugAndPay\Sdk\Contract\ClientInterface;
use PlugAndPay\Sdk\Entity\Response;
use PlugAndPay\Sdk\Exception\ExceptionFactory;

class ClientMock implements ClientInterface
{
    protected array $responseBody;
    protected int $status;

    public function __construct(int $status = 200, array $body = [])
    {
        $this->status       = $status;
        $this->responseBody = $body;
    }

    public function get(string $path): Response
    {
        return $this->standardResponse();
    }

    public function patch(string $path, array $data): Response
    {
        return $this->standardResponse();
    }

    public function put(string $path, array $data): Response
    {
        return $this->standardResponse();
    }

    public function post(string $path, array $body): Response
    {
        return $this->standardResponse();
    }

    public function delete(string $path): Response
    {
        return $this->standardResponse();
    }

    public function deleteMany(string $path, array $data): Response
    {
        return $this->standardResponse();
    }

    public function getAccessToken(string $code, string $codeVerifier, string $redirectUri, int $clientId): Response
    {
        return $this->standardResponse([
            'code'         => $code,
            'codeVerifier' => $codeVerifier,
            'redirectUri'  => $redirectUri,
            'clientId'     => $clientId,
        ]);
    }

    private function standardResponse(array $additionalBody = []): Response
    {
        $responseBody = array_merge($this->responseBody, $additionalBody);
        $exception    = ExceptionFactory::create($this->status, json_encode($responseBody, JSON_THROW_ON_ERROR));
        if ($exception) {
            throw $exception;
        }

        return new Response($this->status, $responseBody);
    }
}
