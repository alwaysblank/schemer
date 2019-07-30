<?php


namespace AlwaysBlank\Schemer\Tests;


use AlwaysBlank\Brief\Brief;
use AlwaysBlank\Schemer\Node;
use PHPUnit\Framework\TestCase;

class NodeTest extends TestCase
{
    public function testCreateNodeSuccessfully(): void
    {
        $node = Node::add(Brief::make([
            'itemscope' => true,
            'itemtype'  => 'http://schema.org/LocalBusiness',
            'itemprop'  => 'description',
            'tag'       => 'div',
            'content'   => "Always Blank",
        ]));

        $this->assertEquals(
            '<div itemscope itemprop="description" itemprop="http://schema.org/LocalBusiness">Always Blank</div>',
            $node->render()
        );
    }

    public function testCreateSelfClosingNodeSuccessfully(): void
    {
        $node = Node::add(Brief::make([
            'itemscope'   => true,
            'itemtype'    => 'http://schema.org/LocalBusiness',
            'itemprop'    => 'description',
            'tag'         => 'meta',
            'content'     => "Always Blank",
            'selfclosing' => true,
        ]));

        $this->assertEquals(
            '<meta itemscope itemprop="description" itemprop="http://schema.org/LocalBusiness" content="Always Blank" />',
            $node->render()
        );
    }

    public function testCastNodeToString(): void
    {
        $node = Node::add(Brief::make([
            'itemscope' => true,
            'itemtype'  => 'http://schema.org/LocalBusiness',
            'itemprop'  => 'description',
            'tag'       => 'div',
            'content'   => "Always Blank",
        ]));

        $this->assertEquals(
            '<div itemscope itemprop="description" itemprop="http://schema.org/LocalBusiness">Always Blank</div>',
            (string)$node
        );
    }

}