<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director\ToBody;

use PlugAndPay\Sdk\Entity\Comment;

class CommentToBody
{
    public static function build(Comment $comment): array
    {
        return [
            'value' => $comment->value(),
        ];
    }

    public static function buildMulti(array $comments): array
    {
        $result = [];
        foreach ($comments as $comment) {
            $result[] = self::build($comment);
        }

        return $result;
    }
}
