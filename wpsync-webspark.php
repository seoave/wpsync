<?php
/**
 * Plugin Name: wpsync-webspark
 * Description: The plugin receives product balances through the API
 * Version: 1.0
 * Author: Oleksandr Burkhan
 *
 */

define("WP_USE_THEMES", false);
require_once __DIR__ . '/bootstrap.php';

use Wpsync\Service\HttpRequestService;
use Wpsync\Repository\NewProductsRepository;
use Wpsync\Repository\OldProductsRepository;
use Wpsync\Service\SortService;
use Wpsync\Service\CreateProductService;

global $product;
$isRequest = true;

if ($isRequest) {
    $newProducts = (new HttpRequestService())->makeRequest();
}

if (! empty($newProducts)) {
    $newSKUs = NewProductsRepository::getArraySku($newProducts);
    var_dump($newSKUs); // TODO remove
}

$oldProducts = (new OldProductsRepository())->findAll();
$oldSKUs = OldProductsRepository::getArraySku($oldProducts);
//var_dump($oldSKUs);

$skuToCreate = SortService::skuToCreate($newSKUs, $oldSKUs);
//$skuToDelete = SortService::skuToDelete($oldSKUs, $newSKUs);
//$skuToUpdate = SortService::skuToUpdate($newSKUs, $oldSKUs);

$createProducts = (new CreateProductService())->fiilterProductsToCreate($newProducts, $skuToCreate);

var_dump($createProducts);

(new CreateProductService())->createProducts($createProducts);


//var_dump(count($skuToDelete));
//var_dump(count($skuToCreate));
//var_dump(count($skuToUpdate));

// TODO create new product
//$post_id = wp_insert_post(array(
//    'post_title' => $title,
//    'post_type' => 'product',
//    'post_status' => 'publish',
//    'post_content' => $body,
//));
//$product = wc_get_product($post_id);
//$product->set_sku($sku);
//$product->set_price($price);
//$product->set_regular_price($regular_price);
//$product->save();
