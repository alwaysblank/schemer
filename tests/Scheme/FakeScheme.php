<?php


namespace AlwaysBlank\Schemer\Tests\Scheme;

use AlwaysBlank\Schemer\Node;
use AlwaysBlank\Schemer\Scheme\Scheme;
use AlwaysBlank\Schemer\Property\{State, URL};

class FakeScheme extends Scheme
{
    use State;
    use URL;

    public static function wrap(string $content, array $args = []): Node
    {
        return Node::add(array_merge([
            'itemscope' => true,
            'itemprop'  => 'fake-scheme',
            'itemtype'  => 'http://schema.org/FakeScheme',
            'content'   => $content,
        ], $args));
    }
}