<?php
declare(strict_types=1);

namespace Wpsync\Service;

class SortService
{
    public static function skuToCreate(array $newSku, array $oldSku): array
    {
        return array_diff($newSku, $oldSku);
    }

    public static function skuToUpdate(array $newSku, array $oldSku): array
    {
        return array_diff($newSku, $oldSku);
    }

    public static function skuToDelete(array $oldSku, array $newSku): array
    {
        return array_diff($oldSku, $newSku);
    }
}
