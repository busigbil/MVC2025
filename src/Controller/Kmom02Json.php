<?php

namespace App\Controller;

use App\Card\Card;
use App\Card\CardGraphic;
use App\Card\CardHand;
use App\Card\DeckOfCards;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;

class Kmom02Json extends AbstractController
{
    #[Route("/api/deck", name: 'deck', methods: ['GET'], defaults: ['description' => 'Returnerar en JSON-struktur med hela kortleken sorterad per färg och värde.'])]
    public function deck(
        SessionInterface $session
    ): Response {
        //Hämta kortlek från session
        $carddeck = $session->get("api-deck");

        if (!$carddeck) {
            $carddeck = new DeckOfCards();
        }
        /** @var DeckOfCards $carddeck */

        //Sortera kortlek
        $carddeck->sortCards();

        //Returnera kortlek som JSON struktur
        $data = [
            'deck' => $carddeck->getValues()
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    #[Route("/api/deck/shuffle", name: 'shuffle', methods: ['GET', 'POST'], defaults: ['description' => 'Blandar kortleken och returnerar den som en JSON-struktur.'])]
    public function shuffle(
        SessionInterface $session
    ): Response {
        //Hämta kortlek från session
        $carddeck = $session->get("api-deck");

        if (!$carddeck) {
            $carddeck = new DeckOfCards();
        }
        /** @var DeckOfCards $carddeck */

        //Blanda kortlek
        $carddeck->shuffleCards();

        //Spara blandad kortlek till session
        $session->set("api-deck", $carddeck);

        //Returnera kortlek som JSON struktur
        $data = [
            'deck' => $carddeck->getValues()
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    #[Route("/api/deck/draw", name: 'draw', methods: ['GET', 'POST'], defaults: ['description' => 'Drar ett kort ur kortleken, och sparar den nya kortleken till session.'])]
    public function draw(
        SessionInterface $session
    ): Response {
        //Hämta kortlek från session
        $carddeck = $session->get("api-deck");

        if (!$carddeck) {
            $carddeck = new DeckOfCards();
        }
        /** @var DeckOfCards $carddeck */

        //Dra 1 kort ur kortleken
        $values = $carddeck->drawCard();
        $card = new Card($values);

        //Spara kortlek till sessionen
        $session->set("api-deck", $carddeck);

        //Returnera kortlek som JSON struktur
        $data = [
            'num-deck' => $carddeck->getNumberCards(),
            'card' => $card->getValue()
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;

    }

    #[Route("/api/deck/draw/{num<\d+>}", name: 'draw_number', methods: ['GET', 'POST'], defaults: ['description' => 'Drar flera kort ur kortleken och sparar den nya kortleken till session.'])]
    public function drawNumber(
        int $num,
        SessionInterface $session
    ): Response {
        //Hämta kortlek från session
        $carddeck = $session->get("api-deck");

        if (!$carddeck) {
            $carddeck = new DeckOfCards();
        }
        /** @var DeckOfCards $carddeck */

        if ($num > $carddeck->getNumberCards()) {
            throw new Exception("Can not draw more cards than available in deck!");
        }

        //Dra :number kort från kortlek
        $hand = new cardHand();
        for ($i = 0; $i < $num; $i++) {
            $value = $carddeck->drawCard();
            $card = new Card($value);
            $hand->add($card);
        }

        //Spara kortlek till sessionen
        $session->set("api-deck", $carddeck);

        //Returnera kort och antal kort i lek som JSON struktur
        $data = [
            'num-deck' => $carddeck->getNumberCards(),
            'card' => $hand->getValues()
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;

    }
}
