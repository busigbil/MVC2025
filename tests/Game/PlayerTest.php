<?php

namespace App\Game;

use App\Card\Card;
use App\Card\DeckOfCards;
use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Player.
 */
class PlayerTest extends TestCase
{
    /**
     * Construct object without input arguments and verify that the object has the expected
     * properties.
     */
    public function testCreatePlayer(): void
    {
        $player = new Player();
        $this->assertInstanceOf("\App\Game\Player", $player);

        $exp = 0;
        $res = $player->getScore();
        $this->assertEquals($exp, $res);
    }

    /**
     * Draw a card from mocked deck and verify that correct card is returned.
     */
    public function testDrawCardAndGetHand(): void
    {
        $stub = $this->createMock(DeckOfCards::class);

        $stub->method('drawCard')
            ->willReturn(["D", "7"]);

        $player = new Player();
        $player->draw(clone $stub);

        $res = $player->getHand();
        $exp = [["D", "7", "♦"]];

        $this->assertEquals($exp, $res);
    }

    /**
     * Add a mocked card to the hand and verify that the expected score is returned.
     */
    public function testSetHandAndGetScore(): void
    {
        $stub = $this->createMock(Card::class);

        $stub->method('getValue')
            ->willReturn(["H", "Q"]);

        $player = new Player();
        $player->setHand(clone $stub);

        $res = $player->getScore();
        $exp = 12;

        $this->assertEquals($exp, $res);
    }

    /**
     * Draw cards from a mocked deck and verify that the total score is over 21.
     */
    public function testDrawCardOver21(): void
    {
        $player = new Player();
        $stub = $this->createMock(DeckOfCards::class);

        $stub->method('drawCard')
            ->willReturn(["D", "Q"]);

        $player->draw(clone $stub);

        $stub->method('drawCard')
            ->willReturn(["S", "K"]);

        $player->draw(clone $stub);

        $res = $player->isOver21();
        $this->assertTrue($res);
    }

    /**
     * Draw card from a mocked deck and verify that the total score is under 17.
     */
    public function testHandLessThan17(): void
    {
        $stub = $this->createMock(Card::class);

        $stub->method('getValue')
            ->willReturn(["D", "2"]);

        $player = new Player();
        $player->setHand(clone $stub);

        $res = $player->isNotOver17();
        $this->assertTrue($res);
    }
}
