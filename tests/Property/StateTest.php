<?php


namespace AlwaysBlank\Schemer\Tests\Property;


use AlwaysBlank\Schemer\Node;
use AlwaysBlank\Schemer\Property\State;
use PHPUnit\Framework\TestCase;

class StateTest extends TestCase
{
    use State;

    public function testCreateStateNode(): void
    {
        $State = $this::state('Oregon');
        $this->assertInstanceOf(Node::class, $State);
    }

    public function testRenderStateNode(): void
    {
        $State = $this::state('Oregon');
        $this->assertEquals(
            '<span itemprop="addressRegion">Oregon</span><span class="spc">&#8203;</span>',
            $State->render()
        );
    }

}