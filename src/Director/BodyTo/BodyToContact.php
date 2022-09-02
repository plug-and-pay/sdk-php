<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director\BodyTo;

use PlugAndPay\Sdk\Entity\Contact;

class BodyToContact
{
    public static function build(array $data): Contact
    {
        return (new Contact())
            ->setCompany($data['company'] ?? null)
            ->setEmail($data['email'])
            ->setFirstName($data['firstname'])
            ->setLastName($data['lastname'])
            ->setTelephone($data['telephone'] ?? null)
            ->setWebsite($data['website'] ?? null)
            ->setVatIdNumber($data['vat_id_number'] ?? null);
    }
}
