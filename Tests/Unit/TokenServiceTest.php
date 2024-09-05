<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Tests\Unit;

use PHPUnit\Framework\TestCase;
use PlugAndPay\Sdk\Exception\InvalidTokenException;
use PlugAndPay\Sdk\Service\TokenService;

class TokenServiceTest extends TestCase
{
    /** @test */
    public function it_should_return_true_for_valid_token(): void
    {
        $payload = json_encode(['exp' => time() + 3600], JSON_THROW_ON_ERROR); // Token expires in 1 hour
        $jwt     = $this->createJwt($payload);

        $isTokenValid = (new TokenService)->isValid($jwt);

        $this->assertTrue($isTokenValid);
    }

    /** @test */
    public function it_should_return_false_for_invalid_token(): void
    {
        $payload = json_encode(['exp' => time() - 3600], JSON_THROW_ON_ERROR); // Token expired 1 hour ago
        $jwt     = $this->createJwt($payload);

        $isTokenValid = (new TokenService)->isValid($jwt);

        $this->assertFalse($isTokenValid);
    }

    /** @test */
    public function it_should_throw_exception_when_jwt_structure_is_invalid(): void
    {
        $this->expectException(InvalidTokenException::class);
        $this->expectExceptionMessage('Invalid JWT structure.');

        (new TokenService)->isValid('invalid.jwt');
    }

    /** @test */
    public function it_should_throw_exception_when_payload_is_invalid(): void
    {
        $this->expectException(InvalidTokenException::class);
        $this->expectExceptionMessage('Invalid payload JSON.');

        $jwt = $this->createJwt('invalid_json');
        (new TokenService)->isValid($jwt);
    }

    /** @test */
    public function it_should_throw_exception_when_expiration_time_is_not_set(): void
    {
        $this->expectException(InvalidTokenException::class);
        $this->expectExceptionMessage('Expiration time not set in token.');

        $payload = json_encode(['data' => 'no_exp'], JSON_THROW_ON_ERROR);
        $jwt     = $this->createJwt($payload);

        (new TokenService)->isValid($jwt);
    }

    private function createJwt(string $payload): string
    {
        $header           = json_encode(['alg' => 'HS256', 'typ' => 'JWT'], JSON_THROW_ON_ERROR);
        $base64UrlHeader  = $this->base64UrlEncode($header);
        $base64UrlPayload = $this->base64UrlEncode($payload);
        $signature        = 'signature'; // Mock signature for testing

        return $base64UrlHeader . '.' . $base64UrlPayload . '.' . $signature;
    }

    /** @test */
    public function it_should_return_false_for_token_with_less_than_30_seconds_ttl(): void
    {
        $payload = json_encode(['exp' => time() + 20], JSON_THROW_ON_ERROR); // Token expires in 20 seconds

        $isTokenValid = (new TokenService)->isValid($this->createJwt($payload));

        $this->assertFalse($isTokenValid);
    }

    private function base64UrlEncode(string $input): string
    {
        return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($input));
    }
}
