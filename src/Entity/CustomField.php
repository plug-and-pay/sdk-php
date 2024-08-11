<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Entity;

class CustomField
{
    private int $id;
    private int $customFieldId;

    private string $input;
    private string $label;

    public function id(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function customFieldId(): int
    {
        return $this->customFieldId;
    }

    public function setCustomFieldId(int $customFieldId): self
    {
        $this->customFieldId = $customFieldId;

        return $this;
    }

    public function input(): string
    {
        return $this->input;
    }

    public function setInput(string $input): self
    {
        $this->input = $input;

        return $this;
    }

    public function label(): string
    {
        return $this->input;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }
}
