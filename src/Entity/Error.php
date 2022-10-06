<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Entity;

/**
 * @internal
 */
class Error
{
    private string $field;
    private string $message;

    public function __construct(string $message, string $field)
    {
        $this->message = $message;
        $this->field   = $field;
    }

    /**
     * @internal
     */
    public function field(): string
    {
        return $this->field;
    }

    /**
     * @internal
     */
    public function message(): string
    {
        return $this->message;
    }
}
