<?php


namespace AlwaysBlank\Schemer\Property;


use AlwaysBlank\Schemer\Node;

trait PostalAddress
{
    public static function address(array $address): Node
    {
        return \AlwaysBlank\Schemer\Scheme\PostalAddress::build($address, [
            'itemprop' => 'address',
            'tag'      => 'div',
        ]);
    }
}