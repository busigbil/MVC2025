<?php

namespace App\Card;

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
        }

        return $deckArr;
    }

    /**
     * @return string[]
     */
    public function drawCard(): array
    {
        //Draw random value from array, and remove from the deck
        $key = array_rand($this->deck, 1);
        $value = $this->deck[$key];
        unset($this->deck[$key]);
        return $value;
    }

    public function sortCards(): void
    {
        //Sort per suit, and add ace infront
        $suits = ['C', 'S', 'H', 'D'];
        $sortArray = [];

        foreach ($suits as $suit) {
            $loopValues = [];
            $startVal = [];

            foreach ($this->deck as $values) {

                if ($values[0] !== $suit) {
                    continue;
                }

                if ($values[1] === 'A') {
                    $startVal = $values;
                    continue;
                }

                $loopValues[] = $values;
            }
            asort($loopValues);
            array_unshift($loopValues, $startVal);
            $sortArray = array_merge($sortArray, $loopValues);
        }
        $this->deck = $sortArray;
    }

    public function shuffleCards(): void
    {
        //shuffle order in deck of cards
        shuffle($this->deck);
    }

    public function getNumberCards(): int
    {
        return count($this->deck);
    }

    /**
     * @return string[][]
     */
    public function getValues(): array
    {
        return $this->deck;
    }
}
