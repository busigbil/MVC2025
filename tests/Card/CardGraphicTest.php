<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class CardGraphic.
 */
class CardGraphicTest extends TestCase
{
    /**
     * Construct object with input arguments and verify that the object has the expected
     * properties.
     */
    public function testCreateCardGraphic(): void
    {
        $card = new CardGraphic(["D", "K"]);
        $this->assertInstanceOf("\App\Card\CardGraphic", $card);

        $res = $card->getValue();
        $exp = ["D", "K", '♦'];
        $this->assertEquals($exp, $res);
    }
}
