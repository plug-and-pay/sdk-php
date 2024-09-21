<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Traits;

use Exception;
use PlugAndPay\Sdk\Entity\AbstractEntity;

trait BuildMultipleObjects
{
    /**
     * @return AbstractEntity[]
     * @throws Exception
     */
    public static function buildMulti(array $input): array
    {
        $result = [];
        foreach ($input as $data) {
            $result[] = self::build($data);
        }

        return $result;
    }
}
