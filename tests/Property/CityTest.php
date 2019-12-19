<?php


namespace AlwaysBlank\Schemer\Tests\Property;


use AlwaysBlank\Schemer\Node;
use AlwaysBlank\Schemer\Property\City;
use PHPUnit\Framework\TestCase;

class CityTest extends TestCase
{
    use City;

    public function testCreateCityNode(): void
    {
        $City = $this::city('Portland');
        $this->assertInstanceOf(Node::class, $City);
    }

    public function testRenderCityNode(): void
    {
        $City = $this::city('Portland');
        $this->assertEquals(
            '<span itemprop="addressLocality">Portland</span>&#8203;',
            $City->render()
        );
    }

}