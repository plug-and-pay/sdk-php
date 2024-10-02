<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Filters;

use PlugAndPay\Sdk\Enum\RuleGroupType;

class RuleFilter
{
    private array $parameters = [];

    public function group(RuleGroupType $value): self
    {
        $this->parameters['group'] = $value->value;

        return $this;
    }

    public function driver(string $value): self
    {
        $this->parameters['driver'] = $value;

        return $this;
    }

    public function tenantId(int $value): self
    {
        $this->parameters['tenant_id'] = $value;

        return $this;
    }

    public function upsellId(int $value): self
    {
        $this->parameters['upsell_id'] = $value;

        return $this;
    }

    public function checkoutId(int $value): self
    {
        $this->parameters['checkout_id'] = $value;

        return $this;
    }

    public function formId(int $value): self
    {
        $this->parameters['form_id'] = $value;

        return $this;
    }

    public function productId(int $value): self
    {
        $this->parameters['product_id'] = $value;

        return $this;
    }

    public function levelId(int $value): self
    {
        $this->parameters['level_id'] = $value;

        return $this;
    }

    public function limit(int $value): self
    {
        $this->parameters['limit'] = $value;

        return $this;
    }

    public function page(int $value): self
    {
        $this->parameters['page'] = $value;

        return $this;
    }

    public function parameters(): array
    {
        return $this->parameters;
    }
}
