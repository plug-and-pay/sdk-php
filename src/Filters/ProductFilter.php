<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Filters;

use PlugAndPay\Sdk\Enum\ContractType;
use PlugAndPay\Sdk\Enum\Direction;
use PlugAndPay\Sdk\Enum\ProductSortType;

class ProductFilter
{
    private array $parameters = [];

    public function direction(Direction $value): self
    {
        $this->parameters['direction'] = $value->value;

        return $this;
    }

    public function hasLimitedStock(bool $value): self
    {
        $this->parameters['has_limited_stock'] = $value;

        return $this;
    }

    public function isDeleted(bool $value): self
    {
        $this->parameters['is_deleted'] = $value;

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

    public function query(string $value): self
    {
        $this->parameters['q'] = $value;

        return $this;
    }

    public function sort(ProductSortType $value): self
    {
        $this->parameters['sort'] = $value->value;

        return $this;
    }

    public function tag(array $value): self
    {
        $this->parameters['tag'] = implode(',', $value);

        return $this;
    }

    public function type(ContractType $value): self
    {
        $this->parameters['type'] = $value->value;

        return $this;
    }

    public function parameters(): array
    {
        return $this->parameters;
    }

    public function productIds(array $productIds): self
    {
        $this->parameters['product_ids'] = implode(',', $productIds);

        return $this;
    }
}
