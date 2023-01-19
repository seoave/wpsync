<?php

namespace Wpsync;

class Configuration
{
    static function getParameter(string $name)
    {
        $parameters = include __DIR__ . '/../config/parameters.php';

        return $parameters[$name] ?: null;
    }
}
