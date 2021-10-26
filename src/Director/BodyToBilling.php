<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director;

use PlugAndPay\Sdk\Entity\Billing;
use PlugAndPay\Sdk\Entity\Comment;

class BodyToBilling
{
    public static function build(array $data): Billing
    {
        return (new Billing())
            ->setAddress(BodyToAddress::build($data['address']))
            ->setCompany($data['company'])
            ->setEmail($data['email'])
            ->setFirstName($data['first_name'])
            ->setInvoiceEmail($data['invoice_email'])
            ->setLastName($data['last_name'])
            ->setTelephone($data['telephone'])
            ->setWebsite($data['website']);
    }

    /**
     * @param $comments
     * @return Comment[]
     */
    public static function buildMulti($comments): array
    {
        $result = [];
        foreach ($comments as $comment) {
            $result[] = BodyToComment::build($comment);
        }
        return $result;
    }
}
