<?php


namespace AlwaysBlank\Schemer\Tests\Property;


use AlwaysBlank\Schemer\Node;
use AlwaysBlank\Schemer\Property\Address;
use AlwaysBlank\Schemer\Tests\Scheme\PostalAddressTest;
use PHPUnit\Framework\TestCase;

class AddressTest extends TestCase
{
    use Address;

    const RENDERED = '<div itemscope itemprop="address" itemprop="http://schema.org/PostalAddress"><span itemprop="streetAddress">123 Oak St</span><span class="spc">&#8203;</span><span itemprop="addressRegion">OR</span><span class="spc">&#8203;</span><span itemprop="addressLocality">Portland</span><span class="spc">&#8203;</span><span itemprop="postalCode">97123</span><span class="spc">&#8203;</span><span itemprop="postOfficeBoxNumber">P.O. 1234</span><span class="spc">&#8203;</span><span itemprop="addressCountry">USA</span><span class="spc">&#8203;</span></div>';

    public function testCreateAddressNode(): void
    {
        $Address = $this::address(PostalAddressTest::ADDRESS);
        $this->assertInstanceOf(Node::class, $Address);
    }

    public function testRenderAddressNode(): void
    {
        $Address = $this::address(PostalAddressTest::ADDRESS);
        $this->assertEquals(
            $this::RENDERED,
            $Address->render()
        );
    }

}