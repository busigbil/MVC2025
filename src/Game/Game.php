<?php

namespace App\Game;

use App\Card\CardGraphic;
use App\Card\CardHand;
use App\Card\DeckOfCards;
use App\Game\Player;
use App\Traits\GameTraits;

/**
 * Methods for class Game; for playing the card game 21.
 */
class Game
{
    use GameTraits;

    /** @var DeckOfCards */
    private DeckOfCards $deck;
    /** @var Player */
    private Player $player;
    /** @var Player */
    private Player $bank;

    public function __construct(?DeckOfCards $deck = null, ?Player $player = null, ?Player $bank = null)
    {
        $this->deck = $deck ?? new DeckOfCards();
        $this->player = $player ?? new Player();
        $this->bank = $bank ?? new Player();
    }

    /**
     * Round of the game when it is the player's turn.
     * @return array<string, mixed> {
     *     cards: string[][],
     *     score: int,
     *     lost: bool
     * }
     */
    public function playerTurn(): array
    {
        $value = $this->deck->drawCard();
        $this->player->setHand(new CardGraphic($value));

        $gameLost = false;
        if ($this->player->isOver21()) {
            $gameLost = true;
        }

        return [
            'cards' => $this->player->getHand(),
            'score' => $this->player->getScore(),
            'lost' => $gameLost
        ];
    }

    /**
     * Round of the game when it is the bank's turn.
     * @return array<string, mixed> {
     *     cards: string[][],
     *     score: int,
     *     lost: bool
     * }
     */
    public function bankTurn(): array
    {
        do {
            $value = $this->deck->drawCard();
            $this->bank->setHand(new CardGraphic($value));

            $gameLost = false;
            if ($this->bank->isOver21()) {
                $gameLost = true;
                break;
            }
        } while ($this->bank->isNotOver17());

        return [
            'cards' => $this->bank->getHand(),
            'score' => $this->bank->getScore(),
            'lost' => $gameLost
        ];
    }

    /**
     * Returns the player's total score.
     * @return int
     */
    public function getPlayerScore(): int
    {
        return $this->player->getScore();
    }

    /**
     * Returns the bank's total score.
     * @return int
     */
    public function getBankScore(): int
    {
        return $this->bank->getScore();
    }

    /**
     * Returns the winner of the game, based on the player and bank scores.
     * @return string
     */
    public function isWinner(): string
    {
        $maxScore = 21;
        $playerScore = $this->getPlayerScore();
        $bankScore = $this->getBankScore();

        if ($playerScore > $maxScore) {
            return "Banken";
        }

        if ($bankScore > $maxScore) {
            return "Spelaren";
        }

        if ($bankScore >= $playerScore) {
            return "Banken";
        }

        return "Spelaren";
    }
}
