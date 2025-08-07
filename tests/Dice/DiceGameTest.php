<?php

namespace App\Dice;

use App\Dice\DiceGame;
use PHPUnit\Framework\TestCase;

/**
 * Test cases for class DiceGame.
 */
class DiceGameTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testCreateDiceGame(): void
    {
        $diceGame = new DiceGame();
        $this->assertInstanceOf("\App\Dice\DiceGame", $diceGame);
    }

    /**
     * Create a hand of dices with mixed values images/integers.
     */
    public function testCreateMixedHand(): void
    {
        $int = 4;
        $diceGame = new DiceGame();
        $hand = $diceGame->rollMixedHand($int);

        $this->assertInstanceOf("\App\Dice\DiceHand", $hand);
    }

    /**
     * Create a hand of dices.
     */
    public function testCreateHand(): void
    {
        $int = 3;
        $diceGame = new DiceGame();
        $hand = $diceGame->rollHand($int);

        $this->assertInstanceOf("\App\Dice\DiceHand", $hand);
    }

    /**
     * Roll hand of several dices.
     */
    public function testRollHand(): void
    {
        $int = 4;
        $game = new DiceGame();

        $res = $game->rollSeveral($int);

        $this->assertCount($int, $res);
    }

    /**
     * Run a round of game, with mocked result.
     */
    public function testGameRound(): void
    {
        $stub = $this->createMock(DiceHand::class);
        $stub->method('getValues')
            ->willReturn([3, 4, 7]);

        $game = new DiceGame();
        $res = $game->gameRound($stub);
        $exp = 14;

        $this->assertEquals($exp, $res);
    }

}
