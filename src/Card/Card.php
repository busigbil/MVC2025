<?php

namespace App\Card;

use App\Card\DeckOfCards;

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
     * @return string[]
     */
    public function getValue(): array
    {
        return $this->value;
    }
}
