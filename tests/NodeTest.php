<?php


namespace AlwaysBlank\Schemer\Tests;


use AlwaysBlank\Schemer\Node;
use PHPUnit\Framework\TestCase;

class NodeTest extends TestCase
{
    public function testCreateNodeSuccessfully(): void
    {
        $node = Node::add([
            'itemscope' => true,
            'itemtype'  => 'http://schema.org/LocalBusiness',
            'itemprop'  => 'description',
            'tag'       => 'div',
            'content'   => "Always Blank",
        ]);

        $this->assertEquals(
            '<div itemscope itemprop="description" itemprop="http://schema.org/LocalBusiness">Always Blank</div>',
            $node->render()
        );
    }

    public function testCreateSelfClosingNodeSuccessfully(): void
    {
        $node = Node::add([
            'itemscope'   => true,
            'itemtype'    => 'http://schema.org/LocalBusiness',
            'itemprop'    => 'description',
            'tag'         => 'meta',
            'content'     => "Always Blank",
            'selfclosing' => true,
        ]);

        $this->assertEquals(
            '<meta itemscope itemprop="description" itemprop="http://schema.org/LocalBusiness" content="Always Blank" />',
            $node->render()
        );
    }

    public function testCastNodeToString(): void
    {
        $node = Node::add([
            'itemscope' => true,
            'itemtype'  => 'http://schema.org/LocalBusiness',
            'itemprop'  => 'description',
            'tag'       => 'div',
            'content'   => "Always Blank",
        ]);

        $this->assertEquals(
            '<div itemscope itemprop="description" itemprop="http://schema.org/LocalBusiness">Always Blank</div>',
            (string)$node
        );
    }

    public function testAddArbitraryAttributes(): void
    {
        $this->assertEquals(
            '<div itemscope itemprop="description" itemprop="http://schema.org/LocalBusiness" hidden>Always Blank</div>',
            Node::add([
                'itemscope' => true,
                'itemtype'  => 'http://schema.org/LocalBusiness',
                'itemprop'  => 'description',
                'tag'       => 'div',
                'content'   => "Always Blank",
                'attributes' => [
                    'hidden' => true,
                ]
            ])->render()
        );
        $this->assertEquals(
            '<a itemscope itemprop="description" itemprop="http://schema.org/LocalBusiness" href="https://www.alwaysblank.org">Always Blank</a>&#8203;',
            Node::add([
                'itemscope' => true,
                'itemtype'  => 'http://schema.org/LocalBusiness',
                'itemprop'  => 'description',
                'tag'       => 'a',
                'content'   => "Always Blank",
                'attributes' => [
                    'href' => 'https://www.alwaysblank.org',
                ]
            ])->render()
        );
    }

    public function testSetAttributesViaAliases(): void
    {
        $this->assertEquals(
            '<a itemscope itemprop="description" itemprop="http://schema.org/LocalBusiness" href="https://www.alwaysblank.org">Always Blank</a>&#8203;',
            Node::add([
                'scope' => true,
                'type'  => 'http://schema.org/LocalBusiness',
                'prop'  => 'description',
                'tag'       => 'a',
                'content'   => "Always Blank",
                'attrs' => [
                    'href' => 'https://www.alwaysblank.org',
                ]
            ])->render()
        );
        $this->assertEquals(
            '<a itemscope itemprop="description" itemprop="http://schema.org/LocalBusiness" href="https://www.alwaysblank.org">Always Blank</a>&#8203;',
            Node::add([
                'iscope' => true,
                'itype'  => 'http://schema.org/LocalBusiness',
                'iprop'  => 'description',
                'tag'       => 'a',
                'content'   => "Always Blank",
                'attr' => [
                    'href' => 'https://www.alwaysblank.org',
                ]
            ])->render()
        );
    }

    public function testEmptyNodeReturnsEmptyString(): void
    {
        $Node = Node::add([]);
        $this->assertEmpty($Node->render());
    }

}