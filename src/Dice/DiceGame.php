<?php

namespace App\Dice;

use App\Dice\Dice;
use App\Dice\DiceGraphic;
use App\Dice\DiceHand;

/**
 * Methods for playing pig game.
 */
class DiceGame
{
    /**
     * Create hand and rolls all dices, returns hand with mixed images/integers.
     * @return diceHand
     */
    public function rollMixedHand(int $num): diceHand
    {
        $hand = new DiceHand();
        for ($i = 1; $i <= $num; $i++) {
            if ($i % 2 === 1) {
                $hand->add(new DiceGraphic());
                continue;
            }
            $hand->add(new Dice());
        }

        $hand->roll();

        return $hand;
    }

    /**
     * Create hand and rolls all dices, returns hand.
     * @return diceHand
     */
    public function rollHand(int $numDice): diceHand
    {
        // Skapar tärningshand
        $hand = new DiceHand();
        for ($i = 1; $i <= $numDice; $i++) {
            //Lägger antal tärningar i handen
            $hand->add(new DiceGraphic());
        }
        // Rullar tärningen
        $hand->roll();

        return $hand;
    }

    /**
     * Rolls number of dices used as parameter.
     * @return string[]
     */
    public function rollSeveral(int $num): array
    {
        $diceRoll = [];
        for ($i = 1; $i <= $num; $i++) {
            $die = new DiceGraphic();
            $die->roll();
            $diceRoll[] = $die->getAsString();
        }

        return $diceRoll;
    }

    /**
     * Calculates the value of game round.
     * @return int
     */
    public function gameRound(DiceHand $hand): int
    {
        $round = 0;
        $values = $hand->getValues();
        foreach ($values as $value) {
            if ($value === 1) {
                $round = 0;
                break;
            }
            $round += $value;
        }

        return $round;
    }
}
