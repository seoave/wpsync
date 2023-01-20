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
use Wpsync\Service\UpdateProductService;

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

//Create
var_dump(count($skuToCreate));
$createProducts = (new NewProductsRepository())->findProductsToCreate($newProducts, $skuToCreate);
CreateProductService::createProducts($createProducts);

// Update
var_dump(count($skuToUpdate));
$productsToUpdate = (new NewProductsRepository())->findProductsToUpdate($newProducts, $skuToUpdate);
UpdateProductService::updateProducts($productsToUpdate);

// Delete
var_dump(count($skuToDelete));
DeleteProductService::deleteProducts($skuToDelete);

//$imageUrl = 'https://loremflickr.com/cache/resized/65535_52429670066_edd841377b_640_480_nofilter.jpg';
//ProductRepository::uploadImage($imageUrl);
