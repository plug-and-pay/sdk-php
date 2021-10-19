<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Entity;

class Item
{
    /**
     * @var Discount[]
     */
    private array $discounts;
    private int $id;
    private int $productId;
    private string $publicTitle;
    private int $quantity;
    private Money $subtotal;
    private Money $total;
    private ?string $type;

    public function discounts(): array
    {
        return $this->discounts;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function productId(): int
    {
        return $this->productId;
    }

    public function publicTitle(): string
    {
        return $this->publicTitle;
    }

    public function quantity(): int
    {
        return $this->quantity;
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

    public function setProductId(int $productId): Item
    {
        $this->productId = $productId;
        return $this;
    }

    public function setPublicTitle(string $publicTitle): Item
    {
        $this->publicTitle = $publicTitle;
        return $this;
    }

    public function setQuantity(int $quantity): Item
    {
        $this->quantity = $quantity;
        return $this;
    }

    public function setSubtotal(Money $subtotal): Item
    {
        $this->subtotal = $subtotal;
        return $this;
    }

    public function setTotal(Money $total): Item
    {
        $this->total = $total;
        return $this;
    }

    public function setType(?string $type): Item
    {
        $this->type = $type;
        return $this;
    }

    public function subtotal(): Money
    {
        return $this->subtotal;
    }

    public function total(): Money
    {
        return $this->total;
    }

    public function type(): ?string
    {
        return $this->type;
    }
}
