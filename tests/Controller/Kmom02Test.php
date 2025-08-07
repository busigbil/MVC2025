<?php

namespace App\Controller;

use App\Dice\DiceHand;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Test cases for class DiceGameController.
 */
class Kmom02Test extends WebTestCase
{
    /**
     * Test instantiation of class
     */
    public function testInstantiateKmom02(): void
    {
        $controller = new Kmom02();
        $this->assertInstanceOf("\App\Controller\Kmom02", $controller);
    }

    /**
     * Test route /session
     */
    public function testControllerSession(): void
    {
        $client = static::createClient();
        $client->request('GET', '/session');
        $this->assertResponseIsSuccessful();
    }

    /**
     * Test route /session/delete
     */
    public function testControllerSessionDelete(): void
    {
        $client = static::createClient();
        $client->request('POST', '/session/delete');
        $this->assertResponseRedirects('/session');
    }

    /**
     * Test route /card
     */
    public function testControllerCard(): void
    {
        $client = static::createClient();
        $client->request('GET', '/card');
        $this->assertResponseIsSuccessful();
    }

    /**
     * Test route /card/deck
     */
    public function testControllerCardDeck(): void
    {
        $client = static::createClient();

        $client->request('POST', '/card/deck', [
            "header" => "All cards sorted",
            "cardValues" => null
        ]);

        $this->assertResponseIsSuccessful();
    }

    /**
     * Test route /card/deck/shuffle
     */
    public function testControllerCardDeckShuffle(): void
    {
        $client = static::createClient();

        $client->request('POST', '/card/deck/shuffle', [
            "header" => "All cards shuffled",
            "cardValues" => null
        ]);

        $this->assertResponseIsSuccessful();
    }

    /**
     * Test route /card/deck/draw
     */
    public function testControllerCardDeckDraw(): void
    {
        $client = static::createClient();

        $client->request('POST', '/card/deck/draw', [
            "header" => "Draw one card",
            "num_cards" => null,
            "value" => null,
        ]);

        $this->assertResponseIsSuccessful();
    }

    /**
     * Test route /card/deck/draw/{num<\d+>}
     */
    public function testControllerCardHand(): void
    {
        $client = static::createClient();

        $client->request('POST', '/card/deck/draw/3', [
            "header" => "Draw multiple cards",
            "num_cards" => null,
            "values" => null,
        ]);

        $this->assertResponseIsSuccessful();
    }
}
