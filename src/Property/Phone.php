<?php


namespace AlwaysBlank\Schemer\Property;


use AlwaysBlank\Schemer\Node;

trait Phone
{
    public static function phone(string $phone, $settings = []): Node
    {
        return Node::add(array_merge([
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
        ], $settings));
    }
}
