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

        $scoreValues = array(
            'J' => 11,
            'Q' => 12,
            'K' => 13
        );

        $cards = $hand->getValues();

        if (empty($cards)) {
            return 0;
        }

        foreach ($cards as $card) {

            $value = $card[1];

            if ($value == 'A') {
                $aces += 1;
                continue;
            }

            if (array_key_exists($value, $scoreValues)) {
                $score += $scoreValues[$value];
                continue;
            }

            // Default
            $score += intval($value);

        }

        if ($score + $aces * $bigAce >= $maxValue) {
            return $score + $aces * $smallAce;
        }

        return $score + $aces * $bigAce;
    }
}
