<?php


namespace AlwaysBlank\Schemer\Property;


use AlwaysBlank\Schemer\Node;

trait Country
{
    public static function country(string $country, $settings = []): Node
    {
        return Node::add(array_merge([
            'itemprop' => 'addressCountry',
            'content'  => $country,
        ], $settings));
    }
}
