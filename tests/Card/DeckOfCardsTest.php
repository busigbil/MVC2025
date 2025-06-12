<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class DeckOfCards.
 */
class DeckOfCardsTest extends TestCase
{
    /**
     * Construct object without input arguments and verify that the object has the expected
     * properties.
     */
    public function testCreateDeckOfCards(): void
    {
        $deck = new DeckOfCards();
        $this->assertInstanceOf("\App\Card\DeckOfCards", $deck);

        $res = $deck->getValues();
        $exp = [
            ['C', 'A'], ['C', '2'], ['C', '3'], ['C', '4'], ['C', '5'], ['C', '6'], ['C', '7'], ['C', '8'], ['C', '9'], ['C', '10'], ['C', 'J'], ['C', 'Q'], ['C', 'K'],
            ['S', 'A'], ['S', '2'], ['S', '3'], ['S', '4'], ['S', '5'], ['S', '6'], ['S', '7'], ['S', '8'], ['S', '9'], ['S', '10'], ['S', 'J'], ['S', 'Q'], ['S', 'K'],
            ['H', 'A'], ['H', '2'], ['H', '3'], ['H', '4'], ['H', '5'], ['H', '6'], ['H', '7'], ['H', '8'], ['H', '9'], ['H', '10'], ['H', 'J'], ['H', 'Q'], ['H', 'K'],
            ['D', 'A'], ['D', '2'], ['D', '3'], ['D', '4'], ['D', '5'], ['D', '6'], ['D', '7'], ['D', '8'], ['D', '9'], ['D', '10'], ['D', 'J'], ['D', 'Q'], ['D', 'K'],
        ];
        $this->assertEquals($exp, $res);
    }

    /**
     * Test Deck-object against correct order, after:
     * 1. Deck has been shuffled
     * 2. Deck has been sorted
     */
    public function testShuffleAndSortCards(): void
    {
        $deck = new DeckOfCards();
        $exp = [
            ['C', 'A'], ['C', '2'], ['C', '3'], ['C', '4'], ['C', '5'], ['C', '6'], ['C', '7'], ['C', '8'], ['C', '9'], ['C', '10'], ['C', 'J'], ['C', 'Q'], ['C', 'K'],
            ['S', 'A'], ['S', '2'], ['S', '3'], ['S', '4'], ['S', '5'], ['S', '6'], ['S', '7'], ['S', '8'], ['S', '9'], ['S', '10'], ['S', 'J'], ['S', 'Q'], ['S', 'K'],
            ['H', 'A'], ['H', '2'], ['H', '3'], ['H', '4'], ['H', '5'], ['H', '6'], ['H', '7'], ['H', '8'], ['H', '9'], ['H', '10'], ['H', 'J'], ['H', 'Q'], ['H', 'K'],
            ['D', 'A'], ['D', '2'], ['D', '3'], ['D', '4'], ['D', '5'], ['D', '6'], ['D', '7'], ['D', '8'], ['D', '9'], ['D', '10'], ['D', 'J'], ['D', 'Q'], ['D', 'K'],
        ];

        // 1. Test shuffle
        $deck->shuffleCards();
        $res = $deck->getValues();
        $this->assertNotEquals($exp, $res);

        // 2. Test sorted
        $deck->sortCards();
        $res = $deck->getValues();
        $this->assertEquals($exp, $res);
    }

    /**
     * Test that the object contains the correct number of cards:
     * 1. After deck has been created
     * 2. After a card has been drawn from the deck
     */
    public function testGetNoOfCards(): void
    {
        $deck = new DeckOfCards();

        // 1. Initial amount of cards in deck
        $exp = 52;
        $res = $deck->getNumberCards();
        $this->assertEquals($exp, $res);

        // 2. After card has been drawn
        $deck->drawCard();
        $exp = 51;
        $res = $deck->getNumberCards();
        $this->assertEquals($exp, $res);
    }

    /**
     * Test draw card method against mocked object.
     */
    public function testDrawStubbedCard(): void
    {
        $stub = $this->createMock(DeckOfCards::class);
        $stub->method('drawCard')
            ->willReturn(["H", "10"]);

        $res = $stub->drawCard();
        $exp = ["H", "10"];
        $this->assertEquals($exp, $res);
    }

}
