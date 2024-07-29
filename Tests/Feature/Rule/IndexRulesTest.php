<?php

declare(strict_types=1);

namespace Feature\Rule;

use PHPUnit\Framework\TestCase;
use PlugAndPay\Sdk\Entity\Response;
use PlugAndPay\Sdk\Enum\RuleGroupType;
use PlugAndPay\Sdk\Exception\UnauthenticatedException;
use PlugAndPay\Sdk\Filters\RuleFilter;
use PlugAndPay\Sdk\Service\RuleService;
use PlugAndPay\Sdk\Tests\Feature\ClientMock;
use PlugAndPay\Sdk\Tests\Feature\Rule\Mock\RuleIndexMockClient;

class IndexRulesTest extends TestCase
{
    /** @test */
    public function index_unauthorized_rules(): void
    {
        $client    = new ClientMock(Response::HTTP_UNAUTHORIZED);
        $service   = new RuleService($client);
        $exception = null;

        try {
            $service->get();
        } catch (UnauthenticatedException $exception) {
        }

        static::assertEquals('Unable to connect with Plug&Pay. Request is unauthenticated.', $exception->getMessage());
    }

    /** @test */
    public function index_rules(): void
    {
        $client  = new RuleIndexMockClient();
        $service = new RuleService($client);

        $rules = $service->get();

        static::assertSame(1, $rules[0]->id());
        static::assertSame('call_webhook', $rules[0]->actionType());
        static::assertSame(['hook_url' => 'https://example.com/webhook'], $rules[0]->actionData());
        static::assertSame('order_created', $rules[0]->triggerType());
        static::assertSame(['is_first' => true, 'product_id' => [1]], $rules[0]->conditionData());
        static::assertSame('Plug&Pay webhook rule', $rules[0]->name());
        static::assertFalse($rules[0]->readonly());
        static::assertSame('webhook', $rules[0]->driver());
    }

    /**
     * @test
     * @dataProvider ruleFilterDataProvider
     */
    public function index_rules_with_filter(string $method, mixed $value, string $queryKey, string $queryValue): void
    {
        $client  = new RuleIndexMockClient();
        $service = new RuleService($client);

        $filter = (new RuleFilter())->$method($value);
        $service->get($filter);

        static::assertSame("/v2/rules?$queryKey=$queryValue", $client->path());
    }

    public function ruleFilterDataProvider(): array
    {
        return [
            [
                'method'     => 'group',
                'value'      => RuleGroupType::PRODUCT,
                'queryKey'   => 'group',
                'queryValue' => 'product',
            ],
            [
                'method'     => 'tenantId',
                'value'      => 1,
                'queryKey'   => 'tenant_id',
                'queryValue' => '1',
            ],
            [
                'method'     => 'upsellId',
                'value'      => 1,
                'queryKey'   => 'upsell_id',
                'queryValue' => '1',
            ],
            [
                'method'     => 'checkoutId',
                'value'      => 1,
                'queryKey'   => 'checkout_id',
                'queryValue' => '1',
            ],
            [
                'method'     => 'formId',
                'value'      => 1,
                'queryKey'   => 'form_id',
                'queryValue' => '1',
            ],
            [
                'method'     => 'productId',
                'value'      => 1,
                'queryKey'   => 'product_id',
                'queryValue' => '1',
            ],
            [
                'method'     => 'limit',
                'value'      => 3,
                'queryKey'   => 'limit',
                'queryValue' => '3',
            ],
            [
                'method'     => 'page',
                'value'      => 3,
                'queryKey'   => 'page',
                'queryValue' => '3',
            ],
        ];
    }
}
