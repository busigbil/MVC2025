<?php

namespace App\Card;

use App\Card\Card;

class CardHand
{
    private $hand = [];

    public function add(Card $card): void
    {
        $this->hand[] = $card;
    }

    public function getValues(): array
    {
        $values = [];
        foreach ($this->hand as $card) {
            $values[] = $card->getValue();
        }
        return $values;
    }

    public function getNumberCards(): int
    {
        return count($this->hand);
    }
}