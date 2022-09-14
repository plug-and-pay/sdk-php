<?php

declare(strict_types=1);

namespace PlugAndPay\Sdk\Director\ToBody;

use PlugAndPay\Sdk\Entity\Product;

class ProductToBody
{
    /**
     * @throws \PlugAndPay\Sdk\Exception\RelationNotLoadedException
     */
    public static function build(Product $product): array
    {
        $result = [];

        if ($product->isset('title')) {
            $result['title'] = $product->title();
        }

        if ($product->isset('description')) {
            $result['description'] = $product->description();
        }

        if ($product->isset('physical')) {
            $result['is_physical'] = $product->isPhysical();
        }

        if ($product->isset('ledger')) {
            $result['ledger'] = $product->ledger();
        }

        if ($product->isset('publicTitle')) {
            $result['public_title'] = $product->publicTitle();
        }

        if ($product->isset('sku')) {
            $result['sku'] = $product->sku();
        }

        if ($product->isset('slug')) {
            $result['slug'] = $product->slug();
        }

        if ($product->isset('stock')) {
            $result['stock'] = [
                'is_enabled' => $product->stock()->isEnabled(),
            ];
            if ($product->stock()->isset('hidden')) {
                $result['stock']['is_hidden'] = $product->stock()->isHidden();
            }
            if ($product->stock()->isset('value')) {
                $result['stock']['value'] = $product->stock()->value();
            }
        }

        if ($product->isset('type')) {
            $result['type'] = $product->type()->value;
        }

        return $result;
    }
}
