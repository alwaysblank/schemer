<?php


namespace AlwaysBlank\Schemer\Property;


use AlwaysBlank\Schemer\Node;

trait URL
{
    public static function url($url): Node
    {
        if (is_string($url)) {
            $content = $url;
            $uri     = $url;
        } elseif (is_array($url) && isset($url['content']) && isset($url['url'])) {
            $content = $url['content'];
            $uri     = $url['url'];
        } else {
            // can't use this
            return Node::add([]);
        }

        return Node::add([
            'itemprop'   => 'url',
            'content'    => $content,
            'tag'        => 'a',
            'attributes' => [
                'href' => $uri,
            ]
        ]);
    }
}