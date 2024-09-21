<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director\BodyTo;

use DateTimeImmutable;
use Exception;
use PlugAndPay\Sdk\Contract\BuildMultipleObjectsInterface;
use PlugAndPay\Sdk\Contract\BuildObjectInterface;
use PlugAndPay\Sdk\Entity\Product;
use PlugAndPay\Sdk\Entity\ProductInternal;
use PlugAndPay\Sdk\Entity\Stock;
use PlugAndPay\Sdk\Enum\ContractType;
use PlugAndPay\Sdk\Exception\DecodeResponseException;
use PlugAndPay\Sdk\Traits\BuildMultipleObjects;

class BodyToProduct implements BuildObjectInterface, BuildMultipleObjectsInterface
{
    use BuildMultipleObjects;

    /**
     * @throws DecodeResponseException
     */
    public static function build(array $data): Product
    {
        $stock = (new Stock())
            ->setEnabled($data['stock']['is_enabled'])
            ->setHidden($data['stock']['is_hidden'] ?? true)
            ->setValue($data['stock']['value'] ?? null);

        $product = (new ProductInternal())
            ->setCreatedAt(self::date($data, 'created_at'))
            ->setDeletedAt($data['deleted_at'] ? self::date($data, 'deleted_at') : null)
            ->setDescription($data['description'])
            ->setId($data['id'])
            ->setPhysical($data['is_physical'])
            ->setLedger($data['ledger'])
            ->setPublicTitle($data['public_title'])
            ->setSku($data['sku'])
            ->setSlug($data['slug'])
            ->setStock($stock)
            ->setTitle($data['title'])
            ->setType(ContractType::from($data['type']))
            ->setUpdatedAt(self::date($data, 'updated_at'));

        if (isset($data['pricing'])) {
            $product->setPricing(BodyToProductPricing::build($data['pricing']));
        }

        return $product;
    }

    /**
     * @throws DecodeResponseException
     * @codeCoverageIgnore
     */
    private static function date(array $data, string $field): DateTimeImmutable
    {
        try {
            return new DateTimeImmutable($data[$field]);
        } catch (Exception $e) {
            /** @noinspection JsonEncodingApiUsageInspection */
            $body = (string) json_encode($data, JSON_ERROR_NONE);
            throw new DecodeResponseException($body, $field, $e);
        }
    }
}
