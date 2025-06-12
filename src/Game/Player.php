<?php

namespace App\Game;

use App\Card\Card;
use App\Card\CardGraphic;
use App\Card\CardHand;
use App\Card\DeckOfCards;
use App\Traits\GameTraits;

/**
 * Methods for class player, that are used in the class Game to play the card game 21.
 * The object Player is used both for the player called "player" and the player called "bank".
 */
class Player
{
    use GameTraits;

    private CardHand $hand;

    public function __construct()
    {
        $this->hand = new CardHand();
    }

    /**
     * Draw a card from the deck of cards that is set up for the round of the game.
     * Add the drawn card to the hand.
     * @param DeckOfCards $deck
     */
    public function draw(DeckOfCards $deck): void
    {
        $value = $deck->drawCard();
        $card = new CardGraphic($value);
        $this->hand->add($card);
    }

    /**
     * Add a card to the hand.
     * @param Card $card
     */
    public function setHand(Card $card): void
    {
        $this->hand->add($card);
    }

    /**
     * Get the values of the cards at hand.
     * @return string[][]
     */
    public function getHand(): array
    {
        return $this->hand->getValues();
    }

    /**
     * Get the scores of the current hand.
     */
    public function getScore(): int
    {
        return $this->loopGameScore($this->hand);
    }

    /**
     * Check if the total score of the current hand is over 21.
     */
    public function isOver21(): bool
    {
        return $this->loopGameScore($this->hand) > 21;

    }

    /**
     * Check if the total score of the current hand is less than 17.
     */
    public function isNotOver17(): bool
    {
        return $this->loopGameScore($this->hand) < 17;

    }
}
