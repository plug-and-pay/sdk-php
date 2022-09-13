<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director\BodyTo;

use DateTimeImmutable;
use Exception;
use PlugAndPay\Sdk\Entity\Product;
use PlugAndPay\Sdk\Enum\ProductType;
use PlugAndPay\Sdk\Exception\DecodeResponseException;

class BodyToProduct
{
    /**
     * @throws \PlugAndPay\Sdk\Exception\DecodeResponseException
     */
    public static function build(array $data): Product
    {
        $product = (new Product())
            ->setCreatedAt(self::date($data, 'created_at'))
            ->setDeletedAt($data['deleted_at'] ? self::date($data, 'deleted_at') : null)
            ->setDescription($data['description'])
            ->setId($data['id'])
            ->setIsPhysical($data['is_physical'])
            ->setPublicTitle($data['public_title'])
            ->setSku($data['sku'])
            ->setSlug($data['slug'])
            ->setTitle($data['title'])
            ->setType(ProductType::from($data['type']))
            ->setUpdatedAt(self::date($data, 'updated_at'));

        if (isset($data['pricing'])) {
            $product->setPricing(BodyToPricing::build($data['pricing']));
        }

        return $product;
    }

    /**
     * @return Product[]
     * @throws \PlugAndPay\Sdk\Exception\DecodeResponseException
     */
    public static function buildMulti(array $data): array
    {
        $result = [];
        foreach ($data as $order) {
            $result[] = self::build($order);
        }

        return $result;
    }

    /**
     * @throws \PlugAndPay\Sdk\Exception\DecodeResponseException
     */
    private static function date(array $data, string $field): DateTimeImmutable
    {
        try {
            return new DateTimeImmutable($data[$field]);
        } catch (Exception $e) {
            /** @noinspection JsonEncodingApiUsageInspection */
            $body = (string)json_encode($data, JSON_ERROR_NONE);
            throw new DecodeResponseException($body, $field, $e);
        }
    }
}
