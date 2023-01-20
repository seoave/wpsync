<?php
declare(strict_types=1);

namespace Wpsync\Repository;

use WC_Data_Exception;
use WC_Product_Simple;
use WP_Error;

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
        $newProduct->save();

        return $newProduct;
    }

    public static function deleteProductBySku(string $sku): void
    {
        $productId = wc_get_product_id_by_sku($sku);
        if ($productId) {
            $product = wc_get_product($productId);
            $product->delete();
        }
    }

    /**
     * @throws WC_Data_Exception
     */
    public static function updateProductFromArray(array $array): void
    {
        $productId = wc_get_product_id_by_sku($array['sku']);
        // TODO change
        $defaultImageId = 2583;

        if ($productId) {
            $product = wc_get_product($productId);

            if ($array['name'] != $product->get_name()) {
                $product->set_name($array['name']);
            }

            if ($array['description'] !== $product->get_description()) {
                $product->set_description($array['description']);
            }

            if ($array['price'] !== $product->get_price()) {
                $product->set_price($array['price']);
            }

            if ($array['in_stock'] !== $product->get_stock_quantity()) {
                $product->set_stock_quantity($array['in_stock']);
            }

            if ($defaultImageId !== $product->get_image_id()) {
                $product->set_image_id($defaultImageId);
            }

            $product->save();
        }
    }

    public static function uploadImage(string $imageUrl): int
    {
        require_once(ABSPATH . 'wp-admin/includes/file.php');
        require_once(ABSPATH . 'wp-admin/includes/image.php');
        require_once(ABSPATH . 'wp-admin/includes/media.php');

        media_sideload_image($imageUrl);

        $attachments = get_posts([
            'post_type' => 'attachment',
            'post_status' => null,
            'post_parent' => 0,
            'orderby' => 'post_date',
            'order' => 'DESC',
        ]);

        return $attachments[0]->ID;
    }
}
