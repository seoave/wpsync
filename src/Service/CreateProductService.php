<?php
declare(strict_types=1);

namespace Wpsync\Service;

use WC_Product_Simple;

class CreateProductService
{
    public function fiilterProductsToCreate(array $newProducts, array $skuToCreate): array
    {
        $createProducts = [];

        foreach ($newProducts as $product) {
            if (in_array($product['sku'], $skuToCreate)) {
                $createProducts[] = $product;
            }
        }

        return $createProducts;
    }

    public function createProducts(array $createProducts): void
    {
        foreach ($createProducts as $item) {
            $newProduct = new WC_Product_Simple();
            $newProduct->set_name($item['name']);
            $newProduct->set_sku($item['sku']);
            $newProduct->set_status("publish");
            $newProduct->set_stock_quantity($item['in_stock']);
            $newProduct->set_description($item['description']);
            $newProduct->set_regular_price($item['price']);
            $newProduct->set_regular_price($item['price']);
            $newProduct->save();
        }
    }
}

