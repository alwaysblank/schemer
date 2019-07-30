<?php


namespace AlwaysBlank\Schemer\Property;


use AlwaysBlank\Schemer\Node;

trait Phone
{
    public static function phone(string $phone): Node
    {
        return Node::add([
            'itemprop'   => 'telephone',
            'content'    => $phone,
            'tag'        => 'a',
            'attributes' => [
                'href' => sprintf("tel:%s",
                    str_replace(
                        ['+', '-'],
                        '',
                        filter_var($phone, FILTER_SANITIZE_NUMBER_INT)
                    )
                ),
            ]
        ]);
    }
}