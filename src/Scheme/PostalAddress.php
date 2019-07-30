<?php


namespace AlwaysBlank\Schemer\Scheme;


use AlwaysBlank\Schemer\Node;
use AlwaysBlank\Schemer\Property\{City, Country, POBox, State, Street, Zip};

class PostalAddress extends Scheme
{
    use Street;
    use State;
    use City;
    use POBox;
    use Zip;
    use Country;

    public static function wrap(string $content, array $args = []): Node
    {
        return Node::add(array_merge([
            'itemscope' => true,
            'itemtype'  => 'http://schema.org/PostalAddress',
            'content'   => $content,
        ], $args));
    }
}