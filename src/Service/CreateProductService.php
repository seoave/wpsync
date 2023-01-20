<?php
declare(strict_types=1);

namespace Wpsync\Service;

use WC_Data_Exception;
use Wpsync\Repository\ProductRepository;

class CreateProductService
{
    /**
     * @throws WC_Data_Exception
     */
    public static function createProducts(array $productsArray): void
    {
        foreach ($productsArray as $item) {
            ProductRepository::createProductFromArray($item);
        }
    }
}
