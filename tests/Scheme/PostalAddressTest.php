<?php


namespace AlwaysBlank\Schemer\Tests\Scheme;


use AlwaysBlank\Schemer\Node;
use AlwaysBlank\Schemer\Scheme\PostalAddress;
use PHPUnit\Framework\TestCase;

class PostalAddressTest extends TestCase
{
    const ADDRESS  = [
        ['street', '123 Oak St'],
        ['state', 'OR'],
        ['city', 'Portland'],
        ['zip', '97123'],
        ['pobox', 'P.O. 1234'],
        ['country', 'USA'],
    ];
    const RENDERED = '<span itemscope itemprop="http://schema.org/PostalAddress"><span itemprop="streetAddress">123 Oak St</span>&#8203;<span itemprop="addressRegion">OR</span>&#8203;<span itemprop="addressLocality">Portland</span>&#8203;<span itemprop="postalCode">97123</span>&#8203;<span itemprop="postOfficeBoxNumber">P.O. 1234</span>&#8203;<span itemprop="addressCountry">USA</span>&#8203;</span>&#8203;';

    public function testCreatePostalAddress(): void
    {
        $address = PostalAddress::build($this::ADDRESS);
        $this->assertInstanceOf(Node::class, $address);
    }

    public function testRenderPostalAddress(): void
    {
        $address = PostalAddress::build($this::ADDRESS);
        $this->assertEquals(
            $this::RENDERED,
            $address->render()
        );
        $this->assertEquals(
            $this::RENDERED,
            (string)$address
        );
    }
}