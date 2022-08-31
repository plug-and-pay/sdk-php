<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Entity;

use BadFunctionCallException;

class Item
{
    private Money $amount;
    private Money $amountWithTax;
    /**
     * @var Discount[]
     */
    private array $discounts;
    private int $id;
    private string $label;
    private int $productId;
    private int $quantity;
    private Tax $tax;
    /**
     * @see \PlugAndPay\Sdk\Enum\ProductType
     */
    private ?string $type;

    public function amount(): Money
    {
        return $this->amount;
    }

    public function discounts(): array
    {
        return $this->discounts;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function isset(string $field): bool
    {
        if (!method_exists($this, $field)) {
            throw new BadFunctionCallException("Method '$field' does not exists");
        }
        return isset($this->{$field});
    }

    public function label(): string
    {
        return $this->label;
    }

    public function productId(): int
    {
        return $this->productId;
    }

    public function quantity(): int
    {
        return $this->quantity;
    }

    public function setAmount(Money $amount): Item
    {
        $this->amount = $amount;

        return $this;
    }

    public function setDiscounts(array $discounts): Item
    {
        $this->discounts = $discounts;
        return $this;
    }

    public function setId(int $id): Item
    {
        $this->id = $id;
        return $this;
    }

    public function setLabel(string $label): Item
    {
        $this->label = $label;
        return $this;
    }

    public function setProductId(int $productId): Item
    {
        $this->productId = $productId;
        return $this;
    }

    public function setQuantity(int $quantity): Item
    {
        $this->quantity = $quantity;
        return $this;
    }

    public function setTax(Tax $tax): Item
    {
        $this->tax = $tax;
        return $this;
    }

    public function setTaxByRateId(int $id): Item
    {
        $this->tax = (new Tax())->setRate(Rate::byId($id));
        return $this;
    }

    public function setTotal(Money $amountWithTax): Item
    {
        $this->amountWithTax = $amountWithTax;
        return $this;
    }

    public function setType(?string $type): Item
    {
        $this->type = $type;
        return $this;
    }

    public function tax(): Tax
    {
        return $this->tax;
    }

    public function amountWithTax(): Money
    {
        return $this->amountWithTax;
    }

    public function type(): ?string
    {
        return $this->type;
    }
}
