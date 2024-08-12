<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Entity;

use PlugAndPay\Sdk\Traits\ValidatesFieldMethods;

class TaxProfile
{
    use ValidatesFieldMethods;

    protected int $id;
    protected bool $editable;
    protected string $label;
    protected array $rates;

    public function id(): int
    {
        return $this->id;
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
}
