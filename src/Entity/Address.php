<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Entity;

use PlugAndPay\Sdk\Enum\CountryCode;
use PlugAndPay\Sdk\Traits\ValidatesFieldMethods;

class Address
{
    use ValidatesFieldMethods;

    private ?string $city;
    private ?CountryCode $country;
    private ?string $street;
    private ?string $houseNumber;
    private ?string $zipcode;

    public function city(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function country(): ?CountryCode
    {
        return $this->country;
    }

    public function setCountry(?CountryCode $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function street(): ?string
    {
        return $this->street;
    }

    public function setStreet(?string $street): self
    {
        $this->street = $street;

        return $this;
    }

    public function houseNumber(): ?string
    {
        return $this->houseNumber;
    }

    public function setHouseNumber(?string $houseNumber): self
    {
        $this->houseNumber = $houseNumber;

        return $this;
    }

    public function zipcode(): ?string
    {
        return $this->zipcode;
    }

    public function setZipcode(?string $zipcode): self
    {
        $this->zipcode = $zipcode;

        return $this;
    }
}
