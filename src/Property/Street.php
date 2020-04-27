<?php


namespace AlwaysBlank\Schemer\Property;


use AlwaysBlank\Schemer\Node;

trait Street
{
    public static function street(string $street, $settings = []): Node
    {
        return Node::add(array_merge([
            'itemprop' => 'streetAddress',
            'content'  => $street,
        ], $settings));
    }
}
