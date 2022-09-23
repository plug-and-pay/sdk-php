<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Entity;

class SubscriptionPricing
{
    private string $amount;
    private string $amountWithTax;
    private array $discounts;
    private int $quantity;
    private float $tax;
    private bool $isTaxIncluded;

    public function amount(): string
    {
        return $this->amount;
    }

    public function setAmount(string $amount): self
    {
        $this->amount = $amount;
        return $this;
    }

    public function amountWithTax(): string
    {
        return $this->amountWithTax;
    }

    public function setAmountWithTax(string $amountWithTax): self
    {
        $this->amountWithTax = $amountWithTax;
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

    public function quantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;
        return $this;
    }

    public function tax(): float
    {
        return $this->tax;
    }

    public function setTax(float $tax): self
    {
        $this->tax = $tax;
        return $this;
    }

    public function isTaxIncluded(): bool
    {
        return $this->isTaxIncluded;
    }

    public function setIsTaxIncluded(bool $isTaxIncluded): self
    {
        $this->isTaxIncluded = $isTaxIncluded;
        return $this;
    }
}
