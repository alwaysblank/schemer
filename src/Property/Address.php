<?php


namespace AlwaysBlank\Schemer\Property;


use AlwaysBlank\Schemer\Node;

trait Address
{
    public static function address(array $address, $settings = []): Node
    {
        return \AlwaysBlank\Schemer\Scheme\PostalAddress::build($address, array_merge([
            'itemprop' => 'address',
            'tag'      => 'div',
        ], $settings));
    }
}
