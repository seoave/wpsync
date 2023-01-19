<?php

namespace Wpsync\Service;

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
