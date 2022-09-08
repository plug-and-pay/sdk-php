<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Entity;

use DateTimeImmutable;
use PlugAndPay\Sdk\Exception\RelationNotLoadedException;

class Pricing
{
    private bool $allowEmptyRelations;
    private bool $is_tax_included;
    private array $prices;
    private ?bool $shipping;
    private Tax $tax;
    private DateTimeImmutable $updatedAt;

    public function __construct(bool $allowEmptyRelations = true)
    {
        $this->allowEmptyRelations = $allowEmptyRelations;
    }

    public function tax(): Tax
    {
        if (!isset($this->tax)) {
            if ($this->allowEmptyRelations) {
                $this->tax = new Tax($this->allowEmptyRelations);
            } else {
                throw new RelationNotLoadedException('tax');
            }
        }

        return $this->tax;
    }

    public function setTax(Tax $tax): Pricing
    {
        $this->tax = $tax;
        return $this;
    }
}
