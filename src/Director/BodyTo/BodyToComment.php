<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director\BodyTo;

use DateTimeImmutable;
use Exception;
use PlugAndPay\Sdk\Contract\BuildMultipleObjectsInterface;
use PlugAndPay\Sdk\Contract\BuildObjectInterface;
use PlugAndPay\Sdk\Entity\Comment;
use PlugAndPay\Sdk\Entity\CommentInternal;
use PlugAndPay\Sdk\Traits\BuildMultipleObjects;

class BodyToComment implements BuildObjectInterface, BuildMultipleObjectsInterface
{
    use BuildMultipleObjects;

    /**
     * @throws Exception
     */
    public static function build(array $data): Comment
    {
        return (new CommentInternal())
            ->setCreatedAt(new DateTimeImmutable($data['created_at']))
            ->setId($data['id'])
            ->setUpdatedAt(new DateTimeImmutable($data['updated_at']))
            ->setValue($data['value']);
    }
}
