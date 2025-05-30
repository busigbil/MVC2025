<?php

namespace App\Game;

use App\Card\CardGraphic;
use App\Card\CardHand;
use App\Card\DeckOfCards;
use App\Game\Player;
use App\Traits\GameTraits;

class Game
{
    use GameTraits;

    /** @var DeckOfCards */
    private DeckOfCards $deck;
    /** @var Player */
    private Player $player;
    /** @var Player */
    private Player $bank;

    public function __construct()
    {
        $this->deck = new DeckOfCards();
        $this->player = new Player();
        $this->bank = new Player();
    }

    /**
     * @return array{
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
     * @return array{
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
     * @return int
     */
    public function getPlayerScore(): int
    {
        return $this->player->getScore();
    }

    /**
     * @return int
     */
    public function getBankScore(): int
    {
        return $this->bank->getScore();
    }

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
