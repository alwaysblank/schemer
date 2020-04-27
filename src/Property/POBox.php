<?php


namespace AlwaysBlank\Schemer\Property;


use AlwaysBlank\Schemer\Node;

trait POBox
{
    public static function pobox(string $boxNumber, $settings = []): Node
    {
        return Node::add(array_merge([
            'itemprop' => 'postOfficeBoxNumber',
            'content'  => $boxNumber,
        ], $settings));
    }
}
