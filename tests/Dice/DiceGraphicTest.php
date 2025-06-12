<?php

namespace App\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class DiceGraphic.
 */
class DiceGraphicTest extends TestCase
{
    /**
     * Construct object without input arguments and verify that the object has the expected
     * properties.
     */
    public function testCreateDiceGraphic(): void
    {
        $die = new DiceGraphic();
        $this->assertInstanceOf("\App\Dice\DiceGraphic", $die);

        $die->roll();
        $res = $die->getAsString();
        $this->assertNotEmpty($res);
    }
}
