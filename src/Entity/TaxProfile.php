<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Entity;

class TaxProfile
{
    private int $id;
    private bool $editable;
    private string $label;
    private array $rates;

    public function id(): int
    {
        return $this->id;
    }

    public function setId(int $id): TaxProfile
    {
        $this->id = $id;
        return $this;
    }

    public function isEditable(): bool
    {
        return $this->editable;
    }

    public function setEditable(bool $editable): TaxProfile
    {
        $this->editable = $editable;
        return $this;
    }

    public function label(): string
    {
        return $this->label;
    }

    public function setLabel(string $label): TaxProfile
    {
        $this->label = $label;
        return $this;
    }

    public function rates(): array
    {
        return $this->rates;
    }

    public function setRates(array $rates): TaxProfile
    {
        $this->rates = $rates;
        return $this;
    }

}
