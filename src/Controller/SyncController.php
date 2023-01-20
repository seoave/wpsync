<?php
declare(strict_types=1);

namespace Wpsync\Controller;

use Wpsync\Service\HttpRequestService;
use Wpsync\Repository\NewProductsRepository;
use Wpsync\Repository\OldProductsRepository;
use Wpsync\Service\SortService;
use Wpsync\Service\CreateProductService;
use Wpsync\Service\UpdateProductService;
use Wpsync\Service\DeleteProductService;

class SyncController
{
    private static ?SyncController $instance = null;

    private function __construct()
    {
    }

    public static function getInstance(): self
    {
        if (static::$instance === null) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    public function sync(): void
    {
        $newProducts = (new HttpRequestService())->makeRequest();

        if (empty($newProducts)) {
            return;
        }

        $oldProducts = (new OldProductsRepository())->findAll();
        $newSkuArray = NewProductsRepository::getArraySku($newProducts);
        $oldSkuArray = OldProductsRepository::getArraySku($oldProducts);

        if (empty($newSkuArray) && empty($oldSkuArray)) {
            return;
        }

        $skuToCreate = SortService::skuToCreate($newSkuArray, $oldSkuArray);
        $skuToDelete = SortService::skuToDelete($oldSkuArray, $newSkuArray);
        $skuToUpdate = SortService::skuToUpdate($newSkuArray, $oldSkuArray);

        $this->createProductsInDB($skuToCreate, $newProducts);
        $this->updateProductsInDB($skuToUpdate, $newProducts);
        $this->deleteProductsInDB($skuToDelete);
    }

    public function createProductsInDB(array $skuToCreate, array $newProducts)
    {
        $createProducts = (new NewProductsRepository())->findProductsToCreate($newProducts, $skuToCreate);
        CreateProductService::createProducts($createProducts);
    }

    public function updateProductsInDB(array $skuToUpdate, array $newProducts)
    {
        $productsToUpdate = (new NewProductsRepository())->findProductsToUpdate($newProducts, $skuToUpdate);
        UpdateProductService::updateProducts($productsToUpdate);
    }

    public function deleteProductsInDB(array $skuToDelete)
    {
        DeleteProductService::deleteProducts($skuToDelete);
    }
}
