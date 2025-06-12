<?php

namespace App\Card;

/**
 * Methods for the DeckOfCards class.
 */
class DeckOfCards
{
    /**
     * @var string[][]
     */
    private array $deck;

    public function __construct()
    {
        $this->deck = $this->createDeck();
    }

    /**
     * Create a deck of french standard with 52 cards.
     * @return string[][]
     */
    public function createDeck(): array
    {
        $suits = ['C', 'S', 'H', 'D'];
        $ranks = ['A', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K'];
        $deckArr = [];

        foreach ($suits as $suit) {
            foreach ($ranks as $rank) {
                $deckArr[] = [$suit, $rank];
            }
        };

        return $deckArr;
    }

    /**
     * Draw a random card from the deck, and remove the card from the deck.
     * @return string[]
     */
    public function drawCard(): array
    {
        $key = array_rand($this->deck, 1);
        $value = $this->deck[$key];
        unset($this->deck[$key]);
        return $value;
    }

    /**
     * Sort the cards in the deck.
     * The first card of a suite has the value "A".
     * The last value of a suite has the value "K".
     */
    public function sortCards(): void
    {
        //Sort per suit, and add ace infront
        $suits = ['C', 'S', 'H', 'D'];
        $sortArray = [];

        foreach ($suits as $suit) {
            $loopValues = [];
            $startVal = [];
            $endVal = [];

            foreach ($this->deck as $values) {

                if ($values[0] !== $suit) {
                    continue;
                }

                if ($values[1] === 'A') {
                    $startVal = $values;
                    continue;
                }

                if ($values[1] === 'K') {
                    $endVal = $values;
                    continue;
                }

                $loopValues[] = $values;
            }
            asort($loopValues);
            array_unshift($loopValues, $startVal);
            array_push($loopValues, $endVal);
            $sortArray = array_merge($sortArray, $loopValues);
        }
        $this->deck = $sortArray;
    }

    /**
     * Shuffle the order of the cards in the deck.
     */
    public function shuffleCards(): void
    {
        shuffle($this->deck);
    }

    /**
     * Get the current number of cards in the deck.
     */
    public function getNumberCards(): int
    {
        return count($this->deck);
    }

    /**
     * Return all the values of the cards in the deck.
     * @return string[][]
     */
    public function getValues(): array
    {
        return $this->deck;
    }
}
