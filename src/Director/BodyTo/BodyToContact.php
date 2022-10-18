<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director\BodyTo;

use PlugAndPay\Sdk\Entity\Contact;
use PlugAndPay\Sdk\Enum\TaxExempt;

class BodyToContact
{
    public static function build(array $data): Contact
    {
        return (new Contact())
            ->setCompany($data['company'])
            ->setEmail($data['email'])
            ->setFirstName($data['firstname'])
            ->setLastName($data['lastname'])
            ->setTaxExempt(TaxExempt::from($data['tax_exempt']))
            ->setTelephone($data['telephone'])
            ->setWebsite($data['website'])
            ->setVatIdNumber($data['vat_id_number']);
    }
}
