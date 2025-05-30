<?php

namespace App\Card;

class CardGraphic extends Card
{
    /**
     * @var array<string, string>
     */
    private $graphics = [
        'C' => '♣',
        'S' => '♠',
        'H' => '♥',
        'D' => '♦'
    ];

    public function __construct(array $card)
    {
        parent::__construct($card);

        foreach ($this->graphics as $suit => $unicode) {
            if ($suit == $this->value[0]) {
                array_push($this->value, $unicode);
            }
        }
    }
}
