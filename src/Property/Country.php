<?php


namespace AlwaysBlank\Schemer\Property;


use AlwaysBlank\Schemer\Node;

trait Country
{
    public static function country(string $country): Node
    {
        return Node::add([
            'itemprop' => 'addressCountry',
            'content'  => $country,
        ]);
    }
}