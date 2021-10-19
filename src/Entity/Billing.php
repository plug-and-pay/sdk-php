<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Entity;

class Billing
{
    private Address $address;
    private string $company;
    private string $email;
    private string $firstName;
    private string $invoiceEmail;
    private string $lastName;
    private string $telephone;
    private string $website;

    public function address(): Address
    {
        return $this->address;
    }

    public function company(): string
    {
        return $this->company;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function firstName(): string
    {
        return $this->firstName;
    }

    public function invoiceEmail(): string
    {
        return $this->invoiceEmail;
    }

    public function lastName(): string
    {
        return $this->lastName;
    }

    public function setAddress(Address $address): Billing
    {
        $this->address = $address;
        return $this;
    }

    public function setCompany(string $company): Billing
    {
        $this->company = $company;
        return $this;
    }

    public function setEmail(string $email): Billing
    {
        $this->email = $email;
        return $this;
    }

    public function setFirstName(string $firstName): Billing
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function setInvoiceEmail(string $invoiceEmail): Billing
    {
        $this->invoiceEmail = $invoiceEmail;
        return $this;
    }

    public function setLastName(string $lastName): Billing
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function setTelephone(string $telephone): Billing
    {
        $this->telephone = $telephone;
        return $this;
    }

    public function setWebsite(string $website): Billing
    {
        $this->website = $website;
        return $this;
    }

    public function telephone(): string
    {
        return $this->telephone;
    }

    public function website(): string
    {
        return $this->website;
    }
}
