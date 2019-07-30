<?php


namespace AlwaysBlank\Schemer\Tests\Scheme;


use AlwaysBlank\Schemer\Node;
use AlwaysBlank\Schemer\Scheme\LocalBusiness;
use PHPUnit\Framework\TestCase;

class LocalBusinessTest extends TestCase
{
    const BUSINESS = [
        ['address', PostalAddressTest::ADDRESS],
        ['name', 'Always Blank'],
        ['phone', '(123) 456-7890'],
        ['url', 'https://www.alwaysblank.org'],
    ];

    public function testCreateLocalBusiness(): void
    {
        $business = LocalBusiness::build($this::BUSINESS);
        $this->assertInstanceOf(Node::class, $business);
    }

    public function testRenderLocalBusiness(): void
    {
        $expected = '<span itemscope itemprop="http://schema.org/LocalBusiness"><div itemscope itemprop="address" itemprop="http://schema.org/PostalAddress"><span itemprop="streetAddress">123 Oak St</span><span itemprop="addressRegion">OR</span><span itemprop="addressLocality">Portland</span><span itemprop="postalCode">97123</span><span itemprop="postOfficeBoxNumber">P.O. 1234</span><span itemprop="addressCountry">USA</span></div><span itemprop="name">Always Blank</span><a itemprop="telephone" href="tel:1234567890">(123) 456-7890</a><a itemprop="url" href="https://www.alwaysblank.org">https://www.alwaysblank.org</a></span>';
        $business = LocalBusiness::build($this::BUSINESS);
        $this->assertEquals(
            $expected,
            $business->render()
        );
        $this->assertEquals(
            $expected,
            (string)$business
        );
    }
}