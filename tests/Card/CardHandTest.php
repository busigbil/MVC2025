<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class CardHand.
 */
class CardHandTest extends TestCase
{
    private CardHand $hand;

    /**
     * Setup method creates the input values needed to test CardHand-methods.
     */
    protected function setUp(): void
    {
        $values = [["S", "J"], ["D", "A"], ["C", "Q"], ["H", "K"]];
        $this->hand = new CardHand();

        foreach ($values as $value) {
            $card = new Card($value);
            $this->hand->add($card);
        }
    }

    /**
     * Construct object without input arguments and verify that the object has the expected
     * properties.
     */
    public function testCreateCardHand(): void
    {
        $values = [["S", "J"], ["D", "A"], ["C", "Q"], ["H", "K"]];
        $res = $this->hand->getValues();
        $this->assertEquals($values, $res);
    }

    /**
     * Test number of cards, compared with cards used in setup-section.
     */
    public function testGetCardCount(): void
    {
        $res = $this->hand->getNumberCards();
        $this->assertEquals(4, $res);
    }
}
