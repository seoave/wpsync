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

    public function findProductsToCreate(array $newProducts, array $skuToCreate): array
    {
        $createProducts = [];

        foreach ($newProducts as $product) {
            if (in_array($product['sku'], $skuToCreate, true)) {
                $createProducts[] = $product;
            }
        }

        return $createProducts;
    }

    public function findProductsToUpdate(array $newProducts, array $skuToUpdate): array
    {
        $updatedProducts = [];

        foreach ($newProducts as $product) {
            if (in_array($product['sku'], $skuToUpdate, true)) {
                $updatedProducts[] = $product;
            }
        }

        return $updatedProducts;
    }
}
