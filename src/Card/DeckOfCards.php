<?php

namespace App\Card;

class DeckOfCards
{
    private $deck;

    public function __construct(?Array $deckOfCards = null)
    {
        $this->deck = $deckOfCards ?? $this->createDeck();
    }

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

    public function drawCard(): array
    {
        //Draw random value from array, and remove from the deck
        $key = array_rand($this->deck, 1);
        $value = $this->deck[$key];
        array_splice($this->deck, $key, 1);
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

                if ($values[0] === $suit) {

                    if ($values[1] === 'A') {
                        $startVal = $values;

                    } else {
                        $loopValues[] = $values;
                    }
                }
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

    public function getValues(): array
    {
        return $this->deck;
    }
}