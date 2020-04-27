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
            '<span itemprop="postalCode">97123</span><span class="spc">&#8203;</span>',
            $Zip->render()
        );
    }

    public function testRenderZipNodeWithSettings(): void
    {
        $Zip = $this::zip('97123', ['spacer' => ', ']);
        $this->assertEquals(
            '<span itemprop="postalCode">97123</span>, ',
            $Zip->render()
        );
    }

}
