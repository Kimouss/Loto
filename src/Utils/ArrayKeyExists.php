<?php

namespace App\Utils;

class ArrayKeyExists
{
    public function getOrNull(array $array, string $key, string $type = 'string')
    {
        if (array_key_exists($key, $array)) {
            settype($array[$key], $type);

            return $array[$key];
        }

        return null;
    }
}
