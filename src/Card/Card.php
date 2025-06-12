<?php

namespace App\Card;

use App\Card\DeckOfCards;

/**
 * Methods for Card class.
 */
class Card
{
    /**
     * @var string[]
     */
    protected array $value;

    /**
     * @param string[] $card
     */
    public function __construct(array $card)
    {
        $this->value = $card;
    }

    /**
     * Get the value of the current card.
     * @return string[]
     */
    public function getValue(): array
    {
        return $this->value;
    }
}
