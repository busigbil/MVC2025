<?php

namespace App\Game;

use App\Card\Card;
use App\Card\CardGraphic;
use App\Card\CardHand;
use App\Card\DeckOfCards;
use App\Traits\GameTraits;

class Player
{
    use GameTraits;

    private CardHand $hand;

    public function __construct()
    {
        $this->hand = new CardHand();
    }

    public function draw(DeckOfCards $deck): void
    {
        $value = $deck->drawCard();
        $card = new CardGraphic($value);
        $this->hand->add($card);
    }

    public function setHand(Card $card): void
    {
        $this->hand->add($card);
    }

    /**
     * @return string[][]
     */
    public function getHand(): array
    {
        return $this->hand->getValues();
    }

    public function getScore(): int
    {
        return $this->loopGameScore($this->hand);
    }

    public function isOver21(): bool
    {
        return $this->loopGameScore($this->hand) > 21;

    }

    public function isNotOver17(): bool
    {
        return $this->loopGameScore($this->hand) < 17;

    }
}
