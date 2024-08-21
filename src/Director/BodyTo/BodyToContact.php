<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director\BodyTo;

use PlugAndPay\Sdk\Contract\BuildObjectInterface;
use PlugAndPay\Sdk\Entity\Contact;
use PlugAndPay\Sdk\Enum\TaxExempt;

class BodyToContact implements BuildObjectInterface
{
    public static function build(array $data): Contact
    {
        return (new Contact())
            ->setCompany($data['company'] ?? null)
            ->setEmail($data['email'])
            ->setFirstName($data['firstname'])
            ->setLastName($data['lastname'])
            ->setTaxExempt(TaxExempt::from((array_key_exists('tax_exempt', $data)) ? $data['tax_exempt'] : 'unknown'))
            ->setTelephone($data['telephone'] ?? null)
            ->setWebsite($data['website'] ?? null)
            ->setVatIdNumber($data['vat_id_number'] ?? null);
    }
}
