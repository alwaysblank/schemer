<?php


namespace AlwaysBlank\Schemer\Property;


use AlwaysBlank\Schemer\Node;

trait State
{
    public static function state(string $state, $settings = []): Node
    {
        return Node::add(array_merge([
            'itemprop' => 'addressRegion',
            'content'  => $state,
        ], $settings));
    }
}
