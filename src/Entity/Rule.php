<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Entity;

use BadFunctionCallException;

class Rule
{
    protected int $id;
    protected string $actionType;
    protected array $actionData;
    protected string $triggerType;
    protected array $conditionData;
    protected string $name;
    protected bool $readonly;
    protected string $driver;

    public function id(): int
    {
        return $this->id;
    }

    public function actionType(): string
    {
        return $this->actionType;
    }

    public function setActionType(string $actionType): self
    {
        $this->actionType = $actionType;

        return $this;
    }

    public function actionData(): array
    {
        return $this->actionData;
    }

    public function setActionData(array $actionData): self
    {
        $this->actionData = $actionData;

        return $this;
    }

    public function triggerType(): string
    {
        return $this->triggerType;
    }

    public function setTriggerType(string $triggerType): self
    {
        $this->triggerType = $triggerType;

        return $this;
    }

    public function conditionData(): array
    {
        return $this->conditionData;
    }

    public function setConditionData(array $conditionData): self
    {
        $this->conditionData = $conditionData;

        return $this;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function readonly(): bool
    {
        return $this->readonly;
    }

    public function driver(): string
    {
        return $this->driver;
    }

    public function setDriver(string $driver): self
    {
        $this->driver = $driver;

        return $this;
    }

    public function isset(string $field): bool
    {
        if (!property_exists($this, $field)) {
            throw new BadFunctionCallException("Field '$field' does not exists");
        }

        return isset($this->{$field});
    }
}
