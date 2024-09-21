<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Entity;

use PlugAndPay\Sdk\Enum\TaxExempt;
use PlugAndPay\Sdk\Traits\ValidatesFieldMethods;

class Contact extends AbstractEntity
{
    use ValidatesFieldMethods;

    private ?string $company;
    private string $email;
    private string $firstName;
    private string $lastName;
    private TaxExempt $taxExempt;
    private ?string $telephone;
    private ?string $vatIdNumber;
    private ?string $website;

    public function company(): ?string
    {
        return $this->company;
    }

    public function setCompany(?string $company): self
    {
        $this->company = $company;

        return $this;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function firstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function lastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function taxExempt(): TaxExempt
    {
        return $this->taxExempt;
    }

    public function setTaxExempt(TaxExempt $taxExempt): self
    {
        $this->taxExempt = $taxExempt;

        return $this;
    }

    public function telephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function vatIdNumber(): ?string
    {
        return $this->vatIdNumber;
    }

    public function setVatIdNumber(?string $number): self
    {
        $this->vatIdNumber = $number;

        return $this;
    }

    public function website(): ?string
    {
        return $this->website;
    }

    public function setWebsite(?string $website): self
    {
        $this->website = $website;

        return $this;
    }
}
