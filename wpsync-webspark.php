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
use Wpsync\Repository\ProductRepository;
use Wpsync\Service\DeleteProductService;

global $product;
$isRequest = true;

if ($isRequest) {
    $newProducts = (new HttpRequestService())->makeRequest();
}

if (! empty($newProducts)) {
    $newSKUs = NewProductsRepository::getArraySku($newProducts);
}

$oldProducts = (new OldProductsRepository())->findAll();
$oldSKUs = OldProductsRepository::getArraySku($oldProducts);

if (! empty($newSKUs) && ! empty($oldSKUs)) {
    $skuToCreate = SortService::skuToCreate($newSKUs, $oldSKUs);
    $skuToDelete = SortService::skuToDelete($oldSKUs, $newSKUs);
    $skuToUpdate = SortService::skuToUpdate($newSKUs, $oldSKUs);
}

// $createProducts = (new NewProductsRepository())->findProductsToCreate($newProducts, $skuToCreate);

//(new CreateProductService())->createProducts($createProducts);

var_dump($skuToDelete);
//var_dump(count($skuToCreate));
//var_dump(count($skuToUpdate));

//DeleteProductService::deleteProducts($skuToDelete);
