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

    public function setAmount(string $amount): SubscriptionPricing
    {
        $this->amount = $amount;
        return $this;
    }

    public function amountWithTax(): string
    {
        return $this->amountWithTax;
    }

    public function setAmountWithTax(string $amountWithTax): SubscriptionPricing
    {
        $this->amountWithTax = $amountWithTax;
        return $this;
    }

    public function discounts(): array
    {
        return $this->discounts;
    }

    public function setDiscounts(array $discounts): SubscriptionPricing
    {
        $this->discounts = $discounts;
        return $this;
    }

    public function quantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): SubscriptionPricing
    {
        $this->quantity = $quantity;
        return $this;
    }

    public function tax(): float
    {
        return $this->tax;
    }

    public function setTax(float $tax): SubscriptionPricing
    {
        $this->tax = $tax;
        return $this;
    }

    public function isTaxIncluded(): bool
    {
        return $this->isTaxIncluded;
    }

    public function setIsTaxIncluded(bool $isTaxIncluded): SubscriptionPricing
    {
        $this->isTaxIncluded = $isTaxIncluded;
        return $this;
    }
}
