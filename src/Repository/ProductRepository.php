<?php
declare(strict_types=1);

namespace Wpsync\Repository;

use WC_Data_Exception;
use WC_Product_Simple;

class ProductRepository
{
    /**
     * @throws WC_Data_Exception
     */
    public static function createProductFromArray(array $array): WC_Product_Simple
    {
        $newProduct = new WC_Product_Simple();
        $newProduct->set_name($array['name']);
        $newProduct->set_sku($array['sku']);
        $newProduct->set_status("publish");
        $newProduct->set_stock_quantity($array['in_stock']);
        $newProduct->set_description($array['description']);
        $newProduct->set_regular_price($array['price']);
        $newProduct->set_regular_price($array['price']);
        $newProduct->save();

        return $newProduct;
    }

    public static function deleteProductBySku(string $sku): void
    {
        $product_id = wc_get_product_id_by_sku($sku);
        if ($product_id) {
            $product = wc_get_product($product_id);
        }
        $product->delete();
    }
}
