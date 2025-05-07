<?php

namespace App\Card;

class CardGraphic extends Card
{
    private $graphics = [
        'C' => '♣',
        'S' => '♠',
        'H' => '♥',
        'D' => '♦'
    ];

    public function getValue(): array
    {
        foreach ($this->graphics as $suit => $unicode) {

            if ($suit == $this->value[0]) {
                array_push($this->value, $unicode);
            }
        }
        return $this->value;
    }
}