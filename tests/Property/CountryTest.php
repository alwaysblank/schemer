<?php


namespace AlwaysBlank\Schemer\Tests\Property;


use AlwaysBlank\Schemer\Node;
use AlwaysBlank\Schemer\Property\Country;
use PHPUnit\Framework\TestCase;

class CountryTest extends TestCase
{
    use Country;

    public function testCreateCountryNode(): void
    {
        $Country = $this::country('USA');
        $this->assertInstanceOf(Node::class, $Country);
    }

    public function testRenderCountryNode(): void
    {
        $Country = $this::country('USA');
        $this->assertEquals(
            '<span itemprop="addressCountry">USA</span><span class="spc">&#8203;</span>',
            $Country->render()
        );
    }

}