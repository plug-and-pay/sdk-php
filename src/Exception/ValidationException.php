<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Exception;

use PlugAndPay\Sdk\Entity\Error;

class ValidationException extends ClientException
{
    /**
     * @var Error[]
     */
    private array $errors;

    public function __construct(string $message, array $errors)
    {
        $this->constructErrors($errors);
        parent::__construct($this->errorMessage());
    }

    /**
     * @return \PlugAndPay\Sdk\Entity\Error[]
     */
    public function errors(): array
    {
        return $this->errors;
    }

    private function constructErrors(array $errors): void
    {
        foreach ($errors as $field => $messages) {
            foreach ($messages as $message) {
                $this->errors[] = new Error($message, $field);
            }
        }
    }

    private function errorMessage(): string
    {
        $messages = [];
        foreach ($this->errors as $error) {
            $messages[] = $error->message();
        }

        return implode(' ', $messages);
    }
}
