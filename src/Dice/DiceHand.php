<?php

namespace App\Dice;

use App\Dice\Dice;

class DiceHand
{
    /**
     * @var Dice[]
     */
    private array $hand = [];

    public function add(Dice $die): void
    {
        $this->hand[] = $die;
    }

    public function roll(): void
    {
        foreach ($this->hand as $die) {
            $die->roll();
        }
    }

    public function getNumberDices(): int
    {
        return count($this->hand);
    }

    /**
     * @return list<int|null>
     */
    public function getValues(): array
    {
        $values = [];
        foreach ($this->hand as $die) {
            $values[] = $die->getValue();
        }
        return $values;
    }

    /**
     * @return int
     */
    public function sum(): int
    {
        $sum = 0;
        foreach ($this->hand as $die) {
            $sum += $die->getValue();
        }
        return $sum;
    }

    /**
     * @return string[]
     */
    public function getString(): array
    {
        $values = [];
        foreach ($this->hand as $die) {
            $values[] = $die->getAsString();
        }
        return $values;
    }
}
