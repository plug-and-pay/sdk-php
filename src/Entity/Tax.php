<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Entity;

use PlugAndPay\Sdk\Exception\RelationNotLoadedException;
use PlugAndPay\Sdk\Traits\ValidatesFieldMethods;

class Tax extends AbstractEntity
{
    use ValidatesFieldMethods;

    protected bool $allowEmptyRelations;
    protected float $amount;
    protected TaxRate $rate;

    public function __construct(bool $allowEmptyRelations = true)
    {
        $this->allowEmptyRelations = $allowEmptyRelations;
    }

    public function amount(): float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @throws RelationNotLoadedException
     */
    public function rate(): TaxRate
    {
        if (!isset($this->rate)) {
            if ($this->allowEmptyRelations) {
                $this->rate = new TaxRate();
            } else {
                throw new RelationNotLoadedException('rate');
            }
        }

        return $this->rate;
    }

    public function setRateId(int $id): self
    {
        $this->rate = (new TaxRateInternal())->setId($id);

        return $this;
    }
}
