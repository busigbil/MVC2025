<?php

namespace App\Controller;

use App\Game\Game;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;

class Kmom03Json extends AbstractController
{
    #[Route("/api/game", name: 'json-game', methods: ['GET'], defaults: ['description' => 'Returnerar en JSON-struktur med den aktuella ställningen för spelet.'])]
    public function game(
        SessionInterface $session
    ): Response {
        // Hämta spelomgång från session
        /** @var Game $game */
        $game = $session->get('game');

        // Returnerar aktuell ställning som JSON-struktur
        $data = [
            "playerScore" => $game->getPlayerScore(),
            "bankScore" => $game->getBankScore()
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }
}
