<?php

declare(strict_types=1);

namespace Wpsync\Repository;

class OldProductsRepository
{
    public function findAll()
    {
        return wc_get_products(['status' => 'publish', 'limit' => -1]);
    }
}
