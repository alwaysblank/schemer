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
            '<span itemprop="postOfficeBoxNumber">P.O. 1234</span>&#8203;',
            $POBox->render()
        );
    }

}