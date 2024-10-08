<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Entity;

use PlugAndPay\Sdk\Enum\ItemType;

/**
 * @internal
 */
class ItemInternal extends Item
{
    /**
     * @internal
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @internal
     */
    public function setDiscounts(array $discounts): self
    {
        $this->discounts = $discounts;

        return $this;
    }

    /**
     * @internal
     */
    public function setType(ItemType $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @internal
     */
    public function setCustomFields(CustomField $customFields): self
    {
        $this->customFields = $customFields;

        return $this;
    }
}
