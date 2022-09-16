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

        if ($product->isset('description')) {
            $result['description'] = $product->description();
        }

        if ($product->isset('isPhysical')) {
            $result['is_physical'] = $product->isPhysical();
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

        if ($product->isset('title')) {
            $result['title'] = $product->title();
        }

//        if ($product->isset('type')) {
//            $result['type'] = $product->type();
//        }
//
//        if ($product->isset('pricing')) {
//            $result['pricing'] = $product->pricing();
//        }

        return $result;
    }
}
