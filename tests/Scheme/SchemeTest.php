<?php


namespace AlwaysBlank\Schemer\Tests\Scheme;


use AlwaysBlank\Schemer\Node;
use PHPUnit\Framework\TestCase;

class SchemeTest extends TestCase
{
    public function testBasicSchemeIngestion(): void
    {
        $scheme = FakeScheme::ingest(['state' => 'OR']);
        $this->assertIsArray($scheme);
        $this->assertArrayHasKey('state', $scheme);
        $this->assertInstanceOf(Node::class, $scheme['state']);
    }

    public function testStorePropertiesInOrderTheyArePassed(): void
    {
        $properties = [
            'state' => 'OR',
            'url'   => [
                'url'     => 'https://www.alwaysblank.org',
                'content' => 'Visit Me!',
            ]
        ];

        $forward  = FakeScheme::ingest($properties);
        $backward = FakeScheme::ingest(array_reverse($properties, true));
        $this->assertEquals(array_shift($forward), array_pop($backward));
    }

    public function testRenderPropertiesInTheOrderTheyArePassed(): void
    {
        $properties = [
            'state' => 'OR',
            'url'   => [
                'url'     => 'https://www.alwaysblank.org',
                'content' => 'Visit Me!',
            ]
        ];

        $forward  = FakeScheme::build($properties);
        $backward = FakeScheme::build(array_reverse($properties, true));
        $this->assertNotEquals($forward->render(), $backward->render());
        $this->assertEquals(
            '<span itemscope itemprop="fake-scheme" itemprop="http://schema.org/FakeScheme"><span itemprop="addressRegion">OR</span><a itemprop="url" href="https://www.alwaysblank.org">Visit Me!</a></span>',
            $forward->render()
        );
        $this->assertEquals(
            '<span itemscope itemprop="fake-scheme" itemprop="http://schema.org/FakeScheme"><a itemprop="url" href="https://www.alwaysblank.org">Visit Me!</a><span itemprop="addressRegion">OR</span></span>',
            $backward->render()
        );
    }
}