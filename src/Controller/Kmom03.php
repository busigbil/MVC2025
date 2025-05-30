<?php

namespace App\Controller;

use App\Card\Card;
use App\Card\CardGraphic;
use App\Card\CardHand;
use App\Card\DeckOfCards;
use App\Game\Game;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class Kmom03 extends AbstractController
{
    #[Route("/game", name: "game", methods: ['GET'])]
    public function game(): Response
    {
        return $this->render('game.html.twig');
    }

    #[Route("/game/doc", name: "game-doc", methods: ['GET'])]
    public function gameDoc(): Response
    {
        return $this->render('game_doc.html.twig');
    }

    #[Route("/game/init", name: "game-plan", methods: ['POST'])]
    public function init(
        SessionInterface $session
    ): Response {
        //rensa session
        $session->clear();

        // Initiera spelet och spara till session
        /** @var Game $game */
        $game = new Game();
        $session->set('game', $game);

        // redirect till spelaren
        return $this->redirectToRoute('game-player');
    }

    #[Route("/game/player", name: "game-player", methods: ['GET', 'POST'])]
    public function gamePlayer(
        SessionInterface $session
    ): Response {
        // Hämta spelomgång från session
        /** @var Game $game */
        $game = $session->get('game');

        // Draw card and set to hand
        $currentRound = $game->playerTurn();

        // Check if over 21?
        if ($currentRound['lost']) {
            $this->addFlash(
                'notice',
                'Game over! Banken vann!'
            );
        }

        // Sätt spelomgång till session
        $session->set('game', $game);

        $data = [
            "header" => "Spelarens runda",
            "values" => $currentRound['cards'],
            "score" => $currentRound['score'],
            "isLost" => $currentRound['lost']
        ];

        return $this->render('game_plan.html.twig', $data);
    }

    #[Route("/game/bank", name: "game-bank", methods: ['GET', 'POST'])]
    public function gameBank(
        SessionInterface $session
    ): Response {
        // Hämta spelomgång från session
        /** @var Game $game */
        $game = $session->get('game');

        // Bankens runda
        $bankRound = $game->bankTurn();

        // Check if over 21?
        if ($bankRound['lost']) {
            $this->addFlash(
                'notice',
                'Game over! Spelaren vann!'
            );
        }

        // Sätt spelomgång till session
        $session->set('game', $game);

        $data = [
            "header" => "Bankens runda",
            "values" => $bankRound['cards'],
            "score" => $bankRound['score'],
            "isLost" => $bankRound['lost']
        ];
        return $this->render('game_plan.html.twig', $data);
    }

    #[Route("/game/winner", name: "game-winner", methods: ['GET', 'POST'])]
    public function gameWinner(
        SessionInterface $session
    ): Response {
        // Hämta spelomgång från session
        /** @var Game $game */
        $game = $session->get('game');
        $winner = $game->isWinner();

        $data = [
            "text" => $winner . " har vunnit!",
            "playerScore" => $game->getPlayerScore(),
            "bankScore" => $game->getBankScore()
        ];
        return $this->render('winner.html.twig', $data);

    }
}
