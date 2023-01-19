<?php

declare(strict_types=1);

namespace Wpsync\Repository;

class OldProductsRepository
{
    public function findAll(): array
    {
        return wc_get_products(['status' => 'publish', 'limit' => -1]);
    }

    public static function getArraySku(?array $products): ?array
    {
        if ($products === null) {
            return null;
        }

        $arraySku = [];
        foreach ($products as $product) {
            $arraySku[] = $product->get_sku();
        }

        return $arraySku;
    }
}
