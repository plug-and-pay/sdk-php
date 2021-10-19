<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director;

use PlugAndPay\Sdk\Entity\Billing;

class ResponseToBilling
{
    public function build(array $data): Billing
    {
        return (new Billing())
            ->setAddress((new ResponseToAddress())->build($data['address']))
            ->setCompany($data['company'])
            ->setEmail($data['email'])
            ->setFirstName($data['first_name'])
            ->setInvoiceEmail($data['invoice_email'])
            ->setLastName($data['last_name'])
            ->setTelephone($data['telephone'])
            ->setWebsite($data['website']);
    }
}
