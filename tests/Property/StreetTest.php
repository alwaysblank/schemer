<?php


namespace AlwaysBlank\Schemer\Tests\Property;


use AlwaysBlank\Schemer\Node;
use AlwaysBlank\Schemer\Property\Street;
use PHPUnit\Framework\TestCase;

class StreetTest extends TestCase
{
    use Street;

    public function testCreateStreetNode(): void
    {
        $Street = $this::street('123 Oak St.');
        $this->assertInstanceOf(Node::class, $Street);
    }

    public function testRenderStreetNode(): void
    {
        $Street = $this::street('123 Oak St.');
        $this->assertEquals(
            '<span itemprop="streetAddress">123 Oak St.</span>&#8203;',
            $Street->render()
        );
    }

}