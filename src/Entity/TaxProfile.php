<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Entity;

use BadFunctionCallException;

class TaxProfile
{
    protected int $id;
    protected bool $editable;
    protected string $label;
    protected array $rates;

    public function id(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function isEditable(): bool
    {
        return $this->editable;
    }

    public function label(): string
    {
        return $this->label;
    }

    public function rates(): array
    {
        return $this->rates;
    }

    public function isset(string $field): bool
    {
        if (!method_exists($this, $field)) {
            throw new BadFunctionCallException("Field '$field' does not exists");
        }

        return isset($this->{$field});
    }
}
