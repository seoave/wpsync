<?php

namespace Wpsync\Service;

use Wpsync\Repository\ProductRepository;

class DeleteProductService
{
    public static function deleteProducts(array $skuArray)
    {
        if (! empty($skuArray)) {
            foreach ($skuArray as $item) {
                ProductRepository::deleteProductBySku($item);
            }
        }
    }
}
