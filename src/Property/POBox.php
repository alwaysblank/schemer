<?php


namespace AlwaysBlank\Schemer\Property;


use AlwaysBlank\Schemer\Node;

trait POBox
{
    public static function pobox(string $boxNumber): Node
    {
        return Node::add([
            'itemprop' => 'postOfficeBoxNumber',
            'content'  => $boxNumber,
        ]);
    }
}