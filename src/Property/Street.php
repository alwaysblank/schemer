<?php


namespace AlwaysBlank\Schemer\Property;


use AlwaysBlank\Schemer\Node;

trait Street
{
    public static function street(string $street): Node
    {
        return Node::add([
            'itemprop' => 'streetAddress',
            'content'  => $street,
        ]);
    }
}