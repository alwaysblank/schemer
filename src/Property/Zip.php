<?php


namespace AlwaysBlank\Schemer\Property;


use AlwaysBlank\Schemer\Node;

trait Zip
{
    public static function zip(string $zip, $settings = []): Node
    {
        return Node::add(array_merge([
            'itemprop' => 'postalCode',
            'content'  => $zip,
        ], $settings));
    }
}
