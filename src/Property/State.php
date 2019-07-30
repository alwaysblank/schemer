<?php


namespace AlwaysBlank\Schemer\Property;


use AlwaysBlank\Schemer\Node;

trait State
{
    public static function state(string $state): Node
    {
        return Node::add([
            'itemprop' => 'addressRegion',
            'content'  => $state,
        ]);
    }
}