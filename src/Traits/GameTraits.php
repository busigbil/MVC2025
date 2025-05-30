<?php

namespace App\Traits;

use App\Card\CardHand;

trait GameTraits
{
    public function loopGameScore(CardHand $hand): int
    {
        $score = 0;
        $aces = 0;
        $bigAce = 14;
        $smallAce = 1;
        $maxValue = 21;

        $cards = $hand->getValues();

        if (empty($cards)) {
            return 0;
        }

        foreach ($cards as $card) {

            $value = $card[1];

            switch ($card[1]) {
                case 'A':
                    $aces += 1;
                    break;
                case 'J':
                    $score += 11;
                    break;
                case 'Q':
                    $score += 12;
                    break;
                case 'K':
                    $score += 13;
                    break;
                default:
                    $score += intval($value);
            }
        }

        if ($score + $aces * $bigAce >= $maxValue) {
            return $score + $aces * $smallAce;
        }

        return $score + $aces * $bigAce;
    }
}
