<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director\ToBody;

use PlugAndPay\Sdk\Entity\Contact;

class ContactToBody
{
    public static function build(Contact $contact): array
    {
        $result = [];

        if ($contact->isset('company')) {
            $result['company'] = $contact->company();
        }

        if ($contact->isset('email')) {
            $result['email'] = $contact->email();
        }

        if ($contact->isset('firstName')) {
            $result['firstname'] = $contact->firstName();
        }

        if ($contact->isset('lastName')) {
            $result['lastname'] = $contact->lastName();
        }

        if ($contact->isset('telephone')) {
            $result['telephone'] = $contact->telephone();
        }

        if ($contact->isset('website')) {
            $result['website'] = $contact->website();
        }

        if ($contact->isset('vatIdNumber')) {
            $result['vat_id_number'] = $contact->vatIdNumber();
        }

        return $result;
    }
}
