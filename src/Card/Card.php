<?php

namespace App\Card;

use App\Card\DeckOfCards;

class Card
{
    protected $value;

    public function __construct(?Array $card = null)
    {
        $this->value = $card;
    }

    public function getValue(): array
    {
        return $this->value;
    }
}