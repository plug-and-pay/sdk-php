<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Entity;

use PlugAndPay\Sdk\Traits\ValidatesFieldMethods;

class OrderBilling
{
    use ValidatesFieldMethods;

    private Address $address;
    private Contact $contact;
    private bool $allowEmptyRelations;

    public function __construct(bool $allowEmptyRelations = true)
    {
        $this->allowEmptyRelations = $allowEmptyRelations;
    }

    public function address(): Address
    {
        if ($this->allowEmptyRelations && !$this->isset('address')) {
            $this->address = new Address();
        }

        return $this->address;
    }

    public function setAddress(Address $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function contact(): Contact
    {
        if ($this->allowEmptyRelations && !$this->isset('contact')) {
            $this->contact = new Contact();
        }

        return $this->contact;
    }

    public function setContact(Contact $contact): self
    {
        $this->contact = $contact;

        return $this;
    }
}
