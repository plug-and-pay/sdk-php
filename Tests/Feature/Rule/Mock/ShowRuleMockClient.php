<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Tests\Feature\Rule\Mock;

use PlugAndPay\Sdk\Tests\Feature\ClientMock;

class ShowRuleMockClient extends ClientMock
{
    public const BASIC_RULE = [
        'id'             => 1,
        'action_type'    => 'call_webhook',
        'action_data'    => [
            'hook_url' => 'https://example.com/webhook',
        ],
        'trigger_type'   => 'order_paid',
        'condition_data' => ['is_first' => true, 'product_id' => [1]],
        'name'           => 'Plug&Pay Example Rule',
        'readonly'       => false,
        'created_at'     => null,
        'updated_at'     => null,
        'deleted_at'     => null,
        'driver'         => 'webhook',
    ];
    protected string $path;

    public function __construct(int $status = 200, array $data = [])
    {
        parent::__construct($status, $data);

        $this->responseBody = ['data' => $data + self::BASIC_RULE];
    }
}
