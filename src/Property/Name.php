<?php


namespace AlwaysBlank\Schemer\Property;


use AlwaysBlank\Schemer\Node;

trait Name
{
    public static function name(string $name, $settings = []): Node
    {
        return Node::add(array_merge([
            'itemprop' => 'name',
            'content'  => $name,
        ], $settings));
    }
}
