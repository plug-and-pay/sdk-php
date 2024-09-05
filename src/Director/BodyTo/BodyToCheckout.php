<?php

namespace PlugAndPay\Sdk\Director\BodyTo;

use DateTimeImmutable;
use Exception;
use PlugAndPay\Sdk\Contract\BuildObjectInterface;
use PlugAndPay\Sdk\Entity\Checkout;
use PlugAndPay\Sdk\Entity\CheckoutInternal;
use PlugAndPay\Sdk\Exception\DecodeResponseException;

class BodyToCheckout implements BuildObjectInterface
{
    /**
     * @throws DecodeResponseException
     */
    public static function build(array $data): Checkout
    {
        $checkout = (new CheckoutInternal())
            ->setId($data['id'])
            ->setIsActive($data['is_active'])
            ->setIsExpired($data['is_expired'])
            ->setName($data['name'])
            ->setPreviewUrl($data['preview_url'])
            ->setPrimaryColor($data['primary_color'])
            ->setReturnUrl($data['return_url'])
            ->setSecondaryColor($data['secondary_color'])
            ->setSlug($data['slug'])
            ->setUrl($data['url'])
            ->setCreatedAt(self::date($data, 'created_at'))
            ->setUpdatedAt($data['updated_at'] ? self::date($data, 'updated_at') : null)
            ->setDeletedAt($data['deleted_at'] ? self::date($data, 'deleted_at') : null);

        if (isset($data['product'])) {
            $checkout->setProduct(BodyToProduct::build($data['product']));
        }

        return $checkout;
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
