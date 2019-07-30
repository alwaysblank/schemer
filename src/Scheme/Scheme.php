<?php


namespace AlwaysBlank\Schemer\Scheme;


use AlwaysBlank\Schemer\Iterator;
use AlwaysBlank\Schemer\Node;

abstract class Scheme
{

    /**
     * This wraps content generated in the scheme.
     *
     * @param string $content
     *
     * @param array  $args
     *
     * @return Node
     */
    abstract public static function wrap(string $content, array $args = []): Node;

    /**
     * Takes a keyed array of segments, and returns and array of Nodes.
     *
     * @param array $segments
     *
     * @return array
     */
    public static function ingest(array $segments): array
    {
        return Iterator::iterate(function ($type, $value) {
            if (method_exists(static::class, $type)) {
                $node = static::$type($value);
                if (is_a($node, Node::class) && $node->notEmpty()) {
                    return $node;
                }
            }
        }, $segments);
    }

    /**
     * Takes an array of Nodes and returns a fully compiled HTML string with the content of a scheme.
     *
     * This does *not* contain the scheme itself.
     *
     * Usually you'll pass the output of ::ingest directly to this method.
     *
     * @param array $nodes
     *
     * @return string
     */
    public static function content(array $nodes): string
    {
        return array_reduce($nodes, function (string $carry, Node $node) {
            return "$carry{$node->render()}";
        }, '');
    }

    /**
     * Constructs and returns the entire scheme.
     *
     * @param array $segments
     * @param array $args
     *
     * @return Node
     */
    public static function build(array $segments, array $args = []): Node
    {
        return static::wrap(static::content(static::ingest($segments)), $args);
    }
}