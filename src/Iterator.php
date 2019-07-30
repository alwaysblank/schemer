<?php


namespace AlwaysBlank\Schemer;


class Iterator
{
    public static function iterate(callable $callable, array $array): array
    {
        foreach ($array as $key => &$value) {
            $value = $callable($key, $value);
            if (is_array($value)) {
                $value = static::iterate($callable, $value);
            }
        }
        return $array;
    }
}