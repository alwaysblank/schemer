<?php


namespace AlwaysBlank\Schemer\Tests\Property;


use AlwaysBlank\Schemer\Node;
use AlwaysBlank\Schemer\Property\Phone;
use PHPUnit\Framework\TestCase;

class PhoneTest extends TestCase
{
    use Phone;

    public function testCreatePhoneNode(): void
    {
        $Phone = $this::phone('(123) 456-7890');
        $this->assertInstanceOf(Node::class, $Phone);
    }

    public function testRenderPhoneNode(): void
    {
        $Phone = $this::phone('(123) 456-7890');
        $this->assertEquals(
            '<a itemprop="telephone" href="tel:1234567890">(123) 456-7890</a>',
            $Phone->render()
        );
    }

}