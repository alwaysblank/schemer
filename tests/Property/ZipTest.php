<?php


namespace AlwaysBlank\Schemer\Tests\Property;


use AlwaysBlank\Schemer\Node;
use AlwaysBlank\Schemer\Property\Zip;
use PHPUnit\Framework\TestCase;

class ZipTest extends TestCase
{
    use Zip;

    public function testCreateZipNode(): void
    {
        $Zip = $this::zip('97123');
        $this->assertInstanceOf(Node::class, $Zip);
    }

    public function testRenderZipNode(): void
    {
        $Zip = $this::zip('97123');
        $this->assertEquals(
            '<span itemprop="postalCode">97123</span>&#8203;',
            $Zip->render()
        );
    }

}