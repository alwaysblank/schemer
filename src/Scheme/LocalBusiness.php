<?php namespace

AlwaysBlank\Schemer\Scheme;


use AlwaysBlank\Schemer\Node;
use AlwaysBlank\Schemer\Property\{Name, Phone, URL};

class LocalBusiness extends Scheme
{
    use \AlwaysBlank\Schemer\Property\PostalAddress;
    use Name;
    use Phone;
    use URL;


    public static function wrap(string $content, array $args = []): Node
    {
        return Node::add(array_merge([
            'itemscope' => true,
            'itemtype'  => 'http://schema.org/LocalBusiness',
            'content'   => $content,
        ], $args));
    }
}