<?php
declare(strict_types=1);

namespace Wpsync\Repository;

class NewProductsRepository
{
    public static function getArraySku(?array $products): ?array
    {
        if ($products === null) {
            return null;
        }

        $newSKUs = [];

        if (! empty($products)) {
            foreach ($products as $product) {
                $newSKUs[] = $product['sku'];
            }
        }

        return $newSKUs;
    }
}
