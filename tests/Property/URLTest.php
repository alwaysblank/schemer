<?php


namespace AlwaysBlank\Schemer\Tests\Property;


use AlwaysBlank\Schemer\Node;
use AlwaysBlank\Schemer\Property\URL;
use PHPUnit\Framework\TestCase;

class URLTest extends TestCase
{
    use URL;

    public function testCreateUrlNode(): void
    {
        $URL = $this::url('https://www.alwaysblank.org');
        $URLComplex = $this::url(['url' => 'https://www.alwaysblank.org', 'content' => 'Visit Me']);
        $this->assertInstanceOf(Node::class, $URL);
        $this->assertInstanceOf(Node::class, $URLComplex);
    }

    public function testRenderSimpleUrlNodeWithSettings(): void
    {
        $URL = $this::url('https://www.alwaysblank.org', ['spacer' => ', ']);
        $this->assertEquals(
            '<a itemprop="url" href="https://www.alwaysblank.org">https://www.alwaysblank.org</a>, ',
            $URL->render()
        );
    }

    public function testRenderSimpleUrlNode(): void
    {
        $URL = $this::url('https://www.alwaysblank.org');
        $this->assertEquals(
            '<a itemprop="url" href="https://www.alwaysblank.org">https://www.alwaysblank.org</a><span class="spc">&#8203;</span>',
            $URL->render()
        );
    }

    public function testRenderComplexUrlNode(): void
    {
        $URL = $this::url(['url' => 'https://www.alwaysblank.org', 'content' => 'Visit Me']);
        $this->assertEquals(
            '<a itemprop="url" href="https://www.alwaysblank.org">Visit Me</a><span class="spc">&#8203;</span>',
            $URL->render()
        );
    }

    public function testBadArgumentResultsInEmptyNode(): void
    {
        $URL = $this::url(['bad' => 'argument']);
        $this->assertTrue($URL->empty());
    }

}
