<?php


namespace AlwaysBlank\Schemer\Property;


use AlwaysBlank\Schemer\Node;

trait City
{
    public static function city(string $city): Node
    {
        return Node::add([
            'itemprop' => 'addressLocality',
            'content'  => $city,
        ]);
    }
}