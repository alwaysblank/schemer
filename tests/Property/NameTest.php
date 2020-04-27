<?php


namespace AlwaysBlank\Schemer\Tests\Property;


use AlwaysBlank\Schemer\Node;
use AlwaysBlank\Schemer\Property\Name;
use PHPUnit\Framework\TestCase;

class NameTest extends TestCase
{
    use Name;

    public function testCreateNameNode(): void
    {
        $Name = $this::name('Always Blank');
        $this->assertInstanceOf(Node::class, $Name);
    }

    public function testRenderNameNode(): void
    {
        $Name = $this::name('Always Blank');
        $this->assertEquals(
            '<span itemprop="name">Always Blank</span><span class="spc">&#8203;</span>',
            $Name->render()
        );
    }

    public function testRenderNameNodeWithSettings(): void
    {
        $Name = $this::name('Always Blank', ['spacer' => ', ']);
        $this->assertEquals(
            '<span itemprop="name">Always Blank</span>, ',
            $Name->render()
        );
    }

}
