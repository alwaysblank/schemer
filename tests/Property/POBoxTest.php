<?php


namespace AlwaysBlank\Schemer\Tests\Property;


use AlwaysBlank\Schemer\Node;
use AlwaysBlank\Schemer\Property\POBox;
use PHPUnit\Framework\TestCase;

class POBoxTest extends TestCase
{
    use POBox;

    public function testCreatePOBoxNode(): void
    {
        $POBox = $this::pobox('P.O. 1234');
        $this->assertInstanceOf(Node::class, $POBox);
    }

    public function testRenderPOBoxNode(): void
    {
        $POBox = $this::pobox('P.O. 1234');
        $this->assertEquals(
            '<span itemprop="postOfficeBoxNumber">P.O. 1234</span><span class="spc">&#8203;</span>',
            $POBox->render()
        );
    }

    public function testRenderPOBoxNodeWithSettings(): void
    {
        $POBox = $this::pobox('P.O. 1234', ['spacer' => ', ']);
        $this->assertEquals(
            '<span itemprop="postOfficeBoxNumber">P.O. 1234</span>, ',
            $POBox->render()
        );
    }

}
