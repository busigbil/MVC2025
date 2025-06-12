<?php

namespace App\Game;

use App\Card\CardGraphic;
use App\Card\DeckOfCards;
use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Game.
 */
class GameTest extends TestCase
{
    /**
     * Construct object without input arguments and verify that the object has the expected
     * properties.
     */
    public function testCreateGame(): void
    {
        $game = new Game();
        $this->assertInstanceOf("\App\Game\Game", $game);

        $exp = 0;
        $res = $game->getPlayerScore();
        $this->assertEquals($exp, $res);

        $res = $game->getBankScore();
        $this->assertEquals($exp, $res);
    }

    /**
     * Test a round of the game where the player loses, based on mocked scores.
     */
    public function testPlayerLose(): void
    {
        $stubDeck = $this->createMock(DeckOfCards::class);
        $stubPlayer = $this->createMock(Player::class);

        $card = new CardGraphic(["C", "2"]);

        $stubDeck ->method('drawCard')
                    ->willReturn(["C", "2"]);

        $stubPlayer ->method('setHand')
                    ->with($card);

        $stubPlayer ->method('isOver21')
                    ->willReturn(true);

        $stubPlayer ->method('getScore')
                    ->willReturn(25);

        $stubPlayer ->method('getHand')
                    ->willReturn([["C", "2"], ["H", "K"]]);

        $game = new Game($stubDeck, $stubPlayer);

        $res = $game->playerTurn();
        $cards = [["C", "2"], ["H", "K"]];
        $score = 25;
        $lost = true;

        $this->assertEquals($cards, $res["cards"]);
        $this->assertEquals($score, $res["score"]);
        $this->assertEquals($lost, $res["lost"]);
    }

    /**
     * Test a round of the game where the bank winns, based on mocked scores.
     */
    public function testBankWinn(): void
    {
        $stubDeck = $this->createMock(DeckOfCards::class);
        $stubBank = $this->createMock(Player::class);

        $card = new CardGraphic(["S", "A"]);

        $stubDeck ->method('drawCard')
                    ->willReturn(["S", "A"]);

        $stubBank ->method('setHand')
                    ->with($card);

        $stubBank ->method('isOver21')
                    ->willReturn(false);

        $stubBank ->method('getScore')
                    ->willReturn(18);

        $stubBank ->method('getHand')
                    ->willReturn([["S", "A"], ["D", "10"]]);

        $game = new Game($stubDeck, null, $stubBank);

        $res = $game->bankTurn();
        $cards = [["S", "A"], ["D", "10"]];
        $score = 18;
        $lost = false;

        $this->assertEquals($cards, $res["cards"]);
        $this->assertEquals($score, $res["score"]);
        $this->assertEquals($lost, $res["lost"]);

    }

    /**
     * Test a round of the game where the bank loses, based on mocked scores.
     */
    public function testBankLose(): void
    {
        $stubDeck = $this->createMock(DeckOfCards::class);
        $stubBank = $this->createMock(Player::class);

        $card = new CardGraphic(["C", "A"]);

        $stubDeck ->method('drawCard')
                    ->willReturn(["C", "A"]);

        $stubBank ->method('setHand')
                    ->with($card);

        $stubBank ->method('isOver21')
                    ->willReturn(true);

        $stubBank ->method('getScore')
                    ->willReturn(22);

        $stubBank ->method('getHand')
                    ->willReturn([["C", "A"], ["D", "J"], ["H", "K"]]);

        $game = new Game($stubDeck, null, $stubBank);

        $res = $game->bankTurn();
        $cards = [["C", "A"], ["D", "J"], ["H", "K"]];
        $score = 22;
        $lost = true;

        $this->assertEquals($cards, $res["cards"]);
        $this->assertEquals($score, $res["score"]);
        $this->assertEquals($lost, $res["lost"]);

    }

    /**
     * Player is returned as the winner of the game, based on mocked scores.
     */
    public function testPlayerIsWinner(): void
    {
        $stubPlayer = $this->createMock(Player::class);
        $stubBank = $this->createMock(Player::class);

        $stubPlayer ->method('getScore')
            ->willReturn(21);

        $stubBank ->method('getScore')
            ->willReturn(18);

        $game = new Game(null, $stubPlayer, $stubBank);

        $exp = "Spelaren";
        $res = $game->isWinner();
        $this->assertEquals($exp, $res);

    }

    /**
     * Bank is returned as the winner of the game, based on mocked scores.
     */
    public function testBankIsWinner(): void
    {
        $stubPlayer = $this->createMock(Player::class);
        $stubBank = $this->createMock(Player::class);

        $stubPlayer ->method('getScore')
            ->willReturn(12);

        $stubBank ->method('getScore')
            ->willReturn(20);

        $game = new Game(null, $stubPlayer, $stubBank);

        $exp = "Banken";
        $res = $game->isWinner();
        $this->assertEquals($exp, $res);
    }

    /**
     * Player has a total score over 21, and the bank winns. Mocked scores used.
     */
    public function testPlayerOver21(): void
    {
        $stubPlayer = $this->createMock(Player::class);
        $stubBank = $this->createMock(Player::class);

        $stubPlayer ->method('getScore')
            ->willReturn(26);

        $stubBank ->method('getScore')
            ->willReturn(20);

        $game = new Game(null, $stubPlayer, $stubBank);

        $exp = "Banken";
        $res = $game->isWinner();
        $this->assertEquals($exp, $res);

    }

    /**
     * Bank has a total score over 21, and the player winns. Mocked scores used.
     */
    public function testBankOver21(): void
    {
        $stubPlayer = $this->createMock(Player::class);
        $stubBank = $this->createMock(Player::class);

        $stubPlayer ->method('getScore')
            ->willReturn(21);

        $stubBank ->method('getScore')
            ->willReturn(29);

        $game = new Game(null, $stubPlayer, $stubBank);

        $exp = "Spelaren";
        $res = $game->isWinner();
        $this->assertEquals($exp, $res);

    }
}
