<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director\BodyTo;

use PlugAndPay\Sdk\Entity\Tag;

class BodyToTag
{
    public static function build(array $data): Tag
    {
        return (new Tag())
            ->setName($data['name']);
    }

    /**
     * @param $tags
     * @return Tag[]
     */
    public static function buildMulti($tags): array
    {
        $result = [];
        foreach ($tags as $tag) {
            $result[] = self::build($tag);
        }

        return $result;
    }
}
