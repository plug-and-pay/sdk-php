<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Tests\Feature\Portal\Settings\Mock;

use JsonException;
use PlugAndPay\Sdk\Entity\Response;
use PlugAndPay\Sdk\Exception\ExceptionFactory;
use PlugAndPay\Sdk\Exception\NotFoundException;
use PlugAndPay\Sdk\Exception\ValidationException;
use PlugAndPay\Sdk\Tests\Feature\ClientMock;

class PortalSettingsShowMockClient extends ClientMock
{
    public const BASIC_ORDER = [
        'enabled'              => false,
        'read_only'            => false,
        'edit_invoice_details' => false,
        'edit_payment_term'    => false,
        'edit_payment_method'  => false,
        'cancel_subscription'  => false,
        'resume_subscription'  => false,
        'custom_color'         => '#000000',
        'hide_powered_by'      => false,
        'external_login'       => false,
    ];

    protected string $path;

    /** @noinspection PhpMissingParentConstructorInspection */
    public function __construct(array $data = [])
    {
        $this->responseBody = ['data' => $data + self::BASIC_ORDER];
    }

    /**
     * @throws NotFoundException
     * @throws ValidationException
     * @throws JsonException
     */
    public function get(string $path): Response
    {
        $this->path = $path;
        $response   = new Response(Response::HTTP_OK, $this->responseBody);

        $exception = ExceptionFactory::create($response->status(), json_encode($response->body(), JSON_THROW_ON_ERROR));
        if ($exception) {
            throw $exception;
        }

        return $response;
    }

    public function path(): string
    {
        return $this->path;
    }
}
