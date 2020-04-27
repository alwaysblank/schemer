<?php


namespace AlwaysBlank\Schemer\Property;


use AlwaysBlank\Schemer\Node;

trait City
{
    public static function city(string $city, $settings = []): Node
    {
        return Node::add(array_merge([
            'itemprop' => 'addressLocality',
            'content'  => $city,
        ], $settings));
    }
}
