<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Tests\Feature\AffiliateSeller\Mock;

use JsonException;
use PlugAndPay\Sdk\Entity\Response;
use PlugAndPay\Sdk\Exception\ExceptionFactory;
use PlugAndPay\Sdk\Exception\NotFoundException;
use PlugAndPay\Sdk\Exception\ValidationException;
use PlugAndPay\Sdk\Tests\Feature\ClientMock;

class AffiliateSellerShowMockClient extends ClientMock
{
    public const BASIC_SELLER = [
        'id'              => 1,
        'name'            => 'John Doe',
        'email'           => 'john@example.com',
        'decline_reason'  => '',
        'profile_id'      => 1,
        'status'          => 'accepted',
    ];
    protected string $path;

    /** @noinspection PhpMissingParentConstructorInspection */
    public function __construct(array $data = [])
    {
        $this->responseBody = ['data' => $data + self::BASIC_SELLER];
    }

    public function address(array $data = []): self
    {
        $this->responseBody['data']['address'] = $data + [
                'city'        => 'New York',
                'country'     => 'US',
                'street'      => 'Main St',
                'housenumber' => '123',
                'zipcode'     => '10001',
            ];

        return $this;
    }

    public function contact(array $data = []): self
    {
        $this->responseBody['data']['contact'] = $data + [
                'company'       => 'ACME Corp',
                'email'         => 'john@example.com',
                'firstname'     => 'John',
                'lastname'      => 'Doe',
                'telephone'     => '+1234567890',
                'website'       => 'https://example.com',
                'vat_id_number' => 'US123456789',
                'tax_exempt'    => 'none',
            ];

        return $this;
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

    public function profile(array $data = []): self
    {
        $this->responseBody['data']['profile'] = $data + [
                'id'                 => 14,
                'default_recurring'  => false,
                'default_type'       => 'percentage',
                'default_value'      => '50.00',
                'default_form_value' => '2.50',
                'label'              => '',
                'session_lifetime'   => 120,
                'tenant_id'          => 3,
            ];

        return $this;
    }

    public function statistics(array $data = []): self
    {
        $this->responseBody['data']['statistics'] = $data + [
                'clicks'     => null,
                'commission' => 0,
                'locked'     => 0,
                'orders'     => 0,
                'paidout'    => 0,
                'pending'    => 0,
                'recurring'  => 0,
                'sales'      => 0,
                'value'      => 0,
            ];

        return $this;
    }

    public function payoutOptions(array $data = []): self
    {
        $this->responseBody['data']['payout_options'] = $data + [
                'method'   => 'paypal',
                'settings' => [
                    'email'          => 'oramcharan@example.com',
                    'phone'          => '+3177 4223366',
                    'paypal_me_link' => 'https://paypal.me/lopes.jennifer',
                ],
            ];

        return $this;
    }

    public function payoutMethods(?array $data = null): self
    {
        if ($data === null) {
            $data = [
                [
                    'method'   => 'bank_transfer',
                    'settings' => [
                        'iban' => 'NL91ABNA0417164300',
                        'bic'  => 'ABNANL2A',
                    ],
                ],
            ];
        }

        $this->responseBody['data']['payout_methods'] = $data;

        return $this;
    }
}
