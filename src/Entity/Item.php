<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Entity;

use PlugAndPay\Sdk\Enum\ItemType;
use PlugAndPay\Sdk\Traits\ValidatesFieldMethods;

class Item
{
    use ValidatesFieldMethods;

    protected float $amount;
    protected float $amountWithTax;
    /** @var Discount[] */
    protected array $discounts;
    protected int $id;
    protected string $label;
    protected int $productId;
    protected int $quantity;
    protected Tax $tax;
    protected ItemType $type;

    public function id(): int
    {
        return $this->id;
    }

    public function amount(): float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function discounts(): array
    {
        return $this->discounts;
    }

    public function label(): string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function productId(): int
    {
        return $this->productId;
    }

    public function setProductId(int $productId): self
    {
        $this->productId = $productId;

        return $this;
    }

    public function quantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function tax(): Tax
    {
        return $this->tax;
    }

    public function setTax(Tax $tax): self
    {
        $this->tax = $tax;

        return $this;
    }

    public function setTaxByRateId(int $id): self
    {
        $this->tax = (new Tax())->setRateId($id);

        return $this;
    }

    public function amountWithTax(): float
    {
        return $this->amountWithTax;
    }

    public function setAmountWithTax(float $amountWithTax): self
    {
        $this->amountWithTax = $amountWithTax;

        return $this;
    }

    public function type(): ItemType
    {
        return $this->type;
    }
}
