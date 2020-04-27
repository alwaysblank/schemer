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
    const RENDERED = '<span itemscope itemtype="http://schema.org/PostalAddress"><span itemprop="streetAddress">123 Oak St</span><span class="spc">&#8203;</span><span itemprop="addressRegion">OR</span><span class="spc">&#8203;</span><span itemprop="addressLocality">Portland</span><span class="spc">&#8203;</span><span itemprop="postalCode">97123</span><span class="spc">&#8203;</span><span itemprop="postOfficeBoxNumber">P.O. 1234</span><span class="spc">&#8203;</span><span itemprop="addressCountry">USA</span><span class="spc">&#8203;</span></span><span class="spc">&#8203;</span>';

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

    public function testRenderPostalAddressCustomSpacer(): void
    {
        $address = PostalAddress::build($this::ADDRESS, ['spacer' => ' ']);
        $compare = '<span itemscope itemtype="http://schema.org/PostalAddress"><span itemprop="streetAddress">123 Oak St</span><span class="spc">&#8203;</span><span itemprop="addressRegion">OR</span><span class="spc">&#8203;</span><span itemprop="addressLocality">Portland</span><span class="spc">&#8203;</span><span itemprop="postalCode">97123</span><span class="spc">&#8203;</span><span itemprop="postOfficeBoxNumber">P.O. 1234</span><span class="spc">&#8203;</span><span itemprop="addressCountry">USA</span><span class="spc">&#8203;</span></span> ';
        $this->assertEquals(
            $compare,
            $address->render()
        );
        $this->assertEquals(
            $compare,
            (string)$address
        );
    }

    public function testRenderPostalAddressWithSettings(): void
    {
        $compare = '<span itemscope itemtype="http://schema.org/PostalAddress"><span itemprop="streetAddress">123 Oak St</span><span class="spc">&#8203;</span><span itemprop="addressRegion">OR</span><br><span itemprop="addressLocality">Portland</span>, <span itemprop="postalCode">97123</span><span class="spc">&#8203;</span><span itemprop="postOfficeBoxNumber">P.O. 1234</span><span class="spc">&#8203;</span><span itemprop="addressCountry">USA</span><span class="spc">&#8203;</span></span><span class="spc">&#8203;</span>';

        $source    = $this::ADDRESS;
        $source[2] = ['city', 'Portland', ['spacer' => ', ']];
        $source[1] = ['state', 'OR', ['spacer' => '<br>']];
        $address   = PostalAddress::build($source);
        $this->assertEquals(
            $compare,
            $address->render()
        );
    }
}
