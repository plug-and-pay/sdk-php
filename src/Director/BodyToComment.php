<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director;

use DateTimeImmutable;
use PlugAndPay\Sdk\Entity\Comment;

class BodyToComment
{
    public static function build(array $data): Comment
    {
        return (new Comment())
            ->setCreatedAt(new DateTimeImmutable($data['created_at']))
            ->setId($data['id'])
            ->setUpdatedAt(new DateTimeImmutable($data['updated_at']))
            ->setValue($data['value']);
    }
}
