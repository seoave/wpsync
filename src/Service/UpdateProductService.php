<?php
declare(strict_types=1);

namespace Wpsync\Service;

use WC_Data_Exception;
use Wpsync\Repository\ProductRepository;

class UpdateProductService
{
    /**
     * @throws WC_Data_Exception
     */
    public static function updateProducts(array $productsArray): void
    {
        if (! empty($productsArray)) {
            foreach ($productsArray as $item) {
                ProductRepository::updateProductFromArray($item);
            }
        }
        echo 'Update complete' . PHP_EOL;
    }
}
