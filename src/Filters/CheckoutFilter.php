<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Filters;

use PlugAndPay\Sdk\Enum\CheckoutSort;
use PlugAndPay\Sdk\Enum\CheckoutStatus;
use PlugAndPay\Sdk\Enum\Direction;

class CheckoutFilter
{
    private array $parameters = [];

    public function limit(int $value): self
    {
        $this->parameters['limit'] = $value;

        return $this;
    }

    public function query(string $value): self
    {
        $this->parameters['q'] = $value;

        return $this;
    }

    public function productId(int $value): self
    {
        $this->parameters['product_id'] = $value;

        return $this;
    }

    public function status(CheckoutStatus $value): self
    {
        $this->parameters['status'] = $value->value;

        return $this;
    }

    public function sort(CheckoutSort $value, Direction $direction = Direction::ASC): self
    {
        $this->parameters['sort'] = $value->value . '|' . strtolower($direction->value);

        return $this;
    }

    public function parameters(): array
    {
        return $this->parameters;
    }
}
