<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Entity;

use BadFunctionCallException;
use PlugAndPay\Sdk\Enum\ItemType;

class Item
{
    private float $amount;
    private float $amountWithTax;
    /** @var Discount[] */
    private array $discounts;
    private int $id;
    private string $label;
    private int $productId;
    private int $quantity;
    private Tax $tax;
    private ItemType $type;

    public function id(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
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

    public function setDiscounts(array $discounts): self
    {
        $this->discounts = $discounts;
        return $this;
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
        $this->tax = (new Tax())->setRate((new TaxRate())->setId($id));
        return $this;
    }

    public function amountWithTax(): float
    {
        return $this->amountWithTax;
    }

    public function setTotal(float $amountWithTax): self
    {
        $this->amountWithTax = $amountWithTax;
        return $this;
    }

    public function type(): ItemType
    {
        return $this->type;
    }

    public function setType(ItemType $type): self
    {
        $this->type = $type;
        return $this;
    }

    public function isset(string $field): bool
    {
        if (!method_exists($this, $field)) {
            throw new BadFunctionCallException("Field '$field' does not exists");
        }

        return isset($this->{$field});
    }
}
