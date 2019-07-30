<?php


namespace AlwaysBlank\Schemer\Property;


use AlwaysBlank\Schemer\Node;

trait ZipCode
{
    public static function zip(string $zip): Node
    {
        return Node::add([
            'itemprop' => 'postalCode',
            'content'  => $zip,
        ]);
    }
}