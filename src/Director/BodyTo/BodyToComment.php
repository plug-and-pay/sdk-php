<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director\BodyTo;

use DateTimeImmutable;
use Exception;
use PlugAndPay\Sdk\Entity\Comment;
use PlugAndPay\Sdk\Entity\CommentInternal;

class BodyToComment
{
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

    /**
     * @param $comments
     * @return Comment[]
     * @throws Exception
     */
    public static function buildMulti($comments): array
    {
        $result = [];
        foreach ($comments as $comment) {
            $result[] = self::build($comment);
        }
        return $result;
    }
}
