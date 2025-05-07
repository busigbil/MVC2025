<?php

namespace App\Controller;

use App\Card\Card;
use App\Card\CardGraphic;
use App\Card\CardHand;
use App\Card\DeckOfCards;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class Kmom02 extends AbstractController
{
    #[Route("/session", name: "session", methods: ['GET'])]
    public function session(
        SessionInterface $session
    ): Response
    {

        //Get all session data
        $allData = $session->all();

        $data = [
            "session" => $allData
        ];

        return $this->render('session.html.twig', $data);
    }

    #[Route("/session/delete", name: "delete_session", methods: ['POST'])]
    public function deleteSession(
        SessionInterface $session
    ): Response
    {
        //Clear session content and destroy session
        $session->clear();
        $session->invalidate();

        //Add info flash that session is deleted
        $this->addFlash(
            'notice',
            'Session is deleted!'
        );
        return $this->redirectToRoute('session');
    }

    #[Route("/card", name: "card", methods: ['GET'])]
    public function card(): Response
    {
        return $this->render('card.html.twig');
    }

    #[Route("/card/deck", name: "card_deck",  methods: ['GET', 'POST'])]
    public function cardDeck(
        SessionInterface $session
    ): Response
    {
        //Visar samtliga kort i kortleken sorterade per färg och värde.
        $carddeck = $session->get("card_deck");

        if (empty($carddeck)) {
            $carddeck = new DeckOfCards();
        }

        //Add cards sorted
        $carddeck->sortCards();

        //Add deck to session
        $session->set("card_deck", $carddeck);

        $cards = [];
        foreach ($carddeck->getValues() as $card) {
            $newCard = new CardGraphic($card);
            $cards[] = $newCard->getValue();
        }

        $data = [
            "header" => "All cards sorted",
            "cardValues" => $cards
        ];

        return $this->render('show_deck.html.twig', $data);
    }

    #[Route("/card/deck/shuffle", name: "card_shuffle", methods: ['POST'])]
    public function cardShuffle(
        SessionInterface $session
    ): Response
    {
        //Återställ kortlek
        $carddeck = new DeckOfCards();

        //shuffle carddeck
        $carddeck->shuffleCards();

        $cards = [];
        foreach ($carddeck->getValues() as $card) {
            $newCard = new CardGraphic($card);
            $cards[] = $newCard->getValue();
        }

        //Sätt uppdaterad deck till session
        $session->remove('card_deck');
        $session->set("card_deck", $carddeck);

        $data = [
            "header" => "All cards shuffled",
            "cardValues" => $cards
        ];

        return $this->render('show_deck.html.twig', $data);
    }

    #[Route("/card/deck/draw", name: "card_draw",  methods: ['GET', 'POST'])]
    public function cardDraw(
        SessionInterface $session
    ): Response
    {
        //Hämta kortlek från session
        $carddeck = $session->get("card_deck");

        if (empty($carddeck)) {
            $carddeck = new DeckOfCards();
        }

        //Dra 1 kort från kortleken
        $values = $carddeck->drawCard();
        $card = new CardGraphic($values);

        //Spara uppdaterad deck till session
        $session->set("card_deck", $carddeck);

        //Visa kort och antal kvar i kortlek
        $data = [
            "header" => "Draw one card",
            "num_cards" => $carddeck->getNumberCards(),
            "value" => $card->getValue(),
        ];

        return $this->render('draw_card.html.twig', $data);
    }

    #[Route("/card/deck/draw/{num<\d+>}", name: "card_hand", methods: ['GET', 'POST'])]
    public function cardHand(
        int $num,
        SessionInterface $session
    ): Response
    {
        //Hämta kortlek från session
        $carddeck = $session->get("card_deck");

        if (empty($carddeck)) {
            $carddeck = new DeckOfCards();
        }

        if ($num > $carddeck->getNumberCards()) {
            throw new \Exception("Can not draw more cards than available in deck!");
        }

        //Dra flera kort från kortlek
        $hand = new cardHand();
        for ($i = 0; $i < $num; $i++) {
            $value = $carddeck->drawCard();
            $card = new CardGraphic($value);
            $hand->add($card);
        }

        //Spara uppdaterad deck till session
        $session->set("card_deck", $carddeck);

        $data = [
            "header" => "Draw multiple cards",
            "num_cards" => $carddeck->getNumberCards(),
            "values" => $hand->getValues(),
        ];

        return $this->render('draw_cards.html.twig', $data);
    }
}