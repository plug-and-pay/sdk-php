<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Entity;

class Address
{
    private string $city;
    private string $country;
    private string $street;
    private string $streetSuffix;
    private string $zipcode;

    public function city(): string
    {
        return $this->city;
    }

    public function country(): string
    {
        return $this->country;
    }

    public function setCity(string $city): Address
    {
        $this->city = $city;
        return $this;
    }

    public function setCountry(string $country): Address
    {
        $this->country = $country;
        return $this;
    }

    public function setStreet(string $street): Address
    {
        $this->street = $street;
        return $this;
    }

    public function setStreetSuffix(string $streetSuffix): Address
    {
        $this->streetSuffix = $streetSuffix;
        return $this;
    }

    public function setZipcode(string $zipcode): Address
    {
        $this->zipcode = $zipcode;
        return $this;
    }

    public function street(): string
    {
        return $this->street;
    }

    public function streetSuffix(): string
    {
        return $this->streetSuffix;
    }

    public function zipcode(): string
    {
        return $this->zipcode;
    }
}
