<?php


namespace AlwaysBlank\Schemer\Property;


use AlwaysBlank\Schemer\Node;

trait Name
{
    public static function name(string $name): Node
    {
        return Node::add([
            'itemprop' => 'name',
            'content'  => $name,
        ]);
    }
}