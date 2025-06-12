<?php

namespace App\Card;

use App\Card\Card;

/**
 * Methods for CardHand class.
 */
class CardHand
{
    /**
     * @var Card[]
     */
    private array $hand = [];

    /**
     * Add a card to the hand.
     */
    public function add(Card $card): void
    {
        $this->hand[] = $card;
    }

    /**
     * Return the values of the cards at hand.
     * @return string[][]
     */
    public function getValues(): array
    {
        $values = [];
        foreach ($this->hand as $card) {
            $values[] = $card->getValue();
        }
        return $values;
    }

    /**
     * Return the number of cards at hand.
     */
    public function getNumberCards(): int
    {
        return count($this->hand);
    }
}
