<?php

namespace App\Controller;

use App\Dice\DiceGame;
use App\Dice\DiceHand;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Session\Storage\MockFileSessionStorage;

/**
 * Test cases for class DiceGameController.
 */
class DiceGameControllerTest extends WebTestCase
{
    /**
     * Test instantiation of class
     */
    public function testInstantiateDiceGame(): void
    {
        $controller = new DiceGameController();
        $this->assertInstanceOf("\App\Controller\DiceGameController", $controller);
    }

    /**
     * Test route /game/pig
     */
    public function testControllerHome(): void
    {
        $client = static::createClient();
        $client->request('GET', '/game/pig');
        $this->assertResponseIsSuccessful();
    }

    /**
     * Test route /game/pig/test/roll
     */
    public function testControllerRollOneDice(): void
    {
        $client = static::createClient();
        $client->request('GET', '/game/pig/test/roll', [
            'dice' => 4,
            'diceString' => '⚃'
        ]);

        $this->assertResponseIsSuccessful();
    }

    /**
     * Test route /game/pig/test/roll/{num<\d+>}
     */
    public function testControllerRollNumDices(): void
    {
        $client = static::createClient();
        $client->request('GET', '/game/pig/test/roll/2', [
            'num_dices' => 2,
            'diceRoll' => ['⚁', '⚂']
        ]);

        $this->assertResponseIsSuccessful();
    }

    /**
     * Test route /game/pig/test/dicehand/{num<\d+>}
     */
    public function testControllerShowHand(): void
    {
        $client = static::createClient();
        $client->request('GET', '/game/pig/test/dicehand/5', [
            'num_dices' => 5,
            'diceRoll' => ['⚁', 1, '⚂', 4, '⚅']
        ]);

        $this->assertResponseIsSuccessful();
    }

    /**
     * Test route /game/pig/init
     */
    public function testControllerInit(): void
    {
        $client = static::createClient();
        $client->request('GET', '/game/pig/init');
        $this->assertResponseIsSuccessful();
    }

    /**
     * Test route /game/pig/init
     */
    public function testControllerInitCallback(): void
    {
        $client = static::createClient();

        $stub = $this->createMock(DiceGame::class);
        $stub->method('rollHand')
                ->with(5);

        $client->request('POST', '/game/pig/init', [
            'num_dices' => 5,
        ]);
        $this->assertResponseRedirects('/game/pig/play');
    }

    /**
     * Test route /game/pig/play
     */
    public function testControllerPlay(): void
    {
        $client = static::createClient();

        // Create session
        $sessionFactory = static::getContainer()->get('session.factory');
        $session = $sessionFactory->createSession();

        $stub = $this->createMock(DiceHand::class);
        $stub->method('getString')
            ->willReturn([4, 7, 9]);

        // Set session data for test
        $session->set('pig_dicehand', clone $stub);
        $session->set('pig_dices', 4);
        $session->set('pig_round', 3);
        $session->set('pig_total', 10);

        $session->save();

        $client->getCookieJar()->set(
            new Cookie($session->getName(), $session->getId())
        );

        $client->request('GET', '/game/pig/play');
        $this->assertResponseIsSuccessful();
    }

    /**
     * Test route /game/pig/roll
     */
    public function testControllerRoll(): void
    {
        $client = static::createClient();

        // Create session
        $sessionFactory = static::getContainer()->get('session.factory');
        $session = $sessionFactory->createSession();

        $stub = $this->createMock(DiceHand::class);
        $stub->method('roll');

        //Save to session
        $session->set('pig_dicehand', clone $stub);
        $session->save();

        $client->getCookieJar()->set(
            new Cookie($session->getName(), $session->getId())
        );

        $client->request('POST', '/game/pig/roll');
        $this->assertResponseRedirects('/game/pig/play');
    }

    /**
     * Test route /game/pig/save
     */
    public function testControllerSave(): void
    {
        $client = static::createClient();
        $client->request('POST', '/game/pig/save');
        $this->assertResponseRedirects('/game/pig/play');
    }
}
