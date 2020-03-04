<?php


namespace AlwaysBlank\Schemer\Tests\Scheme;


use AlwaysBlank\Schemer\Node;
use PHPUnit\Framework\TestCase;

class SchemeTest extends TestCase
{
    const PROPERTIES = [
        ['state', 'OR'],
        [
            'url',
            [
                'url'     => 'https://www.alwaysblank.org',
                'content' => 'Visit Me!',
            ]
        ]
    ];

    public function testBasicSchemeIngestion(): void
    {
        $scheme = FakeScheme::ingest([['state', 'OR']]);
        $this->assertIsArray($scheme);
        $this->assertArrayHasKey(0, $scheme);
        $this->assertInstanceOf(Node::class, $scheme[0]);
    }

    public function testStorePropertiesInOrderTheyArePassed(): void
    {
        $forward  = FakeScheme::ingest($this::PROPERTIES);
        $backward = FakeScheme::ingest(array_reverse($this::PROPERTIES, true));
        $this->assertEquals(array_shift($forward), array_pop($backward));
    }

    public function testRenderPropertiesInTheOrderTheyArePassed(): void
    {
        $forward  = FakeScheme::build($this::PROPERTIES);
        $backward = FakeScheme::build(array_reverse($this::PROPERTIES, true));
        $this->assertNotEquals($forward->render(), $backward->render());
        $this->assertEquals(
            '<span itemscope itemprop="fake-scheme" itemprop="http://schema.org/FakeScheme"><span itemprop="addressRegion">OR</span><span class="spc">&#8203;</span><a itemprop="url" href="https://www.alwaysblank.org">Visit Me!</a><span class="spc">&#8203;</span></span><span class="spc">&#8203;</span>',
            $forward->render()
        );
        $this->assertEquals(
            '<span itemscope itemprop="fake-scheme" itemprop="http://schema.org/FakeScheme"><a itemprop="url" href="https://www.alwaysblank.org">Visit Me!</a><span class="spc">&#8203;</span><span itemprop="addressRegion">OR</span><span class="spc">&#8203;</span></span><span class="spc">&#8203;</span>',
            $backward->render()
        );
    }

    public function testRenderMultiplePropertiesOfIdenticalType(): void
    {
        $scheme = FakeScheme::build(array_merge($this::PROPERTIES, [['state', 'CA'], ['state', 'MA']]));
        $this->assertEquals(
            '<span itemscope itemprop="fake-scheme" itemprop="http://schema.org/FakeScheme"><span itemprop="addressRegion">OR</span><span class="spc">&#8203;</span><a itemprop="url" href="https://www.alwaysblank.org">Visit Me!</a><span class="spc">&#8203;</span><span itemprop="addressRegion">CA</span><span class="spc">&#8203;</span><span itemprop="addressRegion">MA</span><span class="spc">&#8203;</span></span><span class="spc">&#8203;</span>',
            $scheme->render()
        );
    }
}