<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Card.
 */
class CardTest extends TestCase
{
    /**
     * Construct object with input arguments and verify that the object has the expected
     * properties.
     */
    public function testCreateCard(): void
    {
        $card = new Card(["S", "8"]);
        $this->assertInstanceOf("\App\Card\Card", $card);

        $res = $card->getValue();
        $exp = ["S", "8"];
        $this->assertEquals($exp, $res);
    }
}
