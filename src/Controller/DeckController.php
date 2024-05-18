<?php

namespace App\Controller;

use App\Cards\GraphicCard;
use App\Cards\DeckOfCards;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @codeCoverageIgnore
 */
class DeckController extends AbstractController
{
    #[Route("/card", name:"card", methods: ["GET"])]
    public function card(): Response
    {
        if (session_status() != "PHP_SESSION_ACTIVE") {
            $session = new Session();
            $session->start();
            if (!$session->get("deck")) {
                $deck = new DeckOfCards();
                $session->set("deck", $deck);
            }
        }
        $card = new GraphicCard();

        $data = [
            "card" => $card
        ];

        return $this->render("card.html.twig", $data);
    }

    #[Route("/card/deck", name:"deck", methods: ["GET"])]
    public function deck(Request $request): Response
    {
        if (session_status() != "PHP_SESSION_ACTIVE") {
            $session = new Session();
            $session->start();
            if (!$session->get("deck")) {
                $deck = new DeckOfCards();
                $session->set("deck", $deck);
            }
        }

        $session = $request->getSession();
        /** @var DeckOfCards $deck */
        $deck = $session->get("deck");

        $data = [
            "session" => $session,
            "deck" => $deck->deck
        ];

        return $this->render("deck.html.twig", $data);
    }

    #[Route("/card/deck/shuffle", name:"shuffle", methods: ["GET"])]
    public function shuffle(Request $request): Response
    {
        if (session_status() != "PHP_SESSION_ACTIVE") {
            $session = new Session();
            $session->start();
            if (!$session->get("deck")) {
                $deck = new DeckOfCards();
                $session->set("deck", $deck);
            }
        }

        $session = $request->getSession();
        /** @var DeckOfCards $deck */
        $deck = $session->get("deck");
        if ($deck->getLength() == 0) {
            $deck = new DeckOfCards();
            $deck->shuffle();
            $session->set("deck", $deck);
        }

        /** @var DeckOfCards $deck */
        $deck->shuffle();

        $data = [
            "session" => $session,
            "deck" => $deck->deck
        ];

        return $this->render("shuffle.html.twig", $data);
    }

    #[Route("card/deck/shuffle/reset", name:"cardShuffleReset", methods: ["GET"])]
    public function resetShuffle(Request $request): Response
    {
        if (session_status() != "PHP_SESSION_ACTIVE") {
            $session = new Session();
            $session->start();
        }

        $session = $request->getSession();

        $deck = new DeckOfCards();
        $deck->shuffle();
        $session->set("deck", $deck);

        return $this->redirect("../shuffle");
    }

    #[Route("card/deck/newDeckRedirect", name:"newDeckRedirect", methods:["POST"])]
    public function newDeckRedirect(Request $request): Response
    {
        $checkbox = $request->request->get("shfl");
        $deck = new DeckOfCards();
        $session = $request->getSession();
        $session->set("deck", $deck);
        if ($checkbox) {
            return $this->redirect("shuffle/reset");
        }
        return $this->redirect("../deck");
    }

    #[Route("card/deck/draw", name:"draw", methods: ["GET"])]
    public function draw(Request $request): Response
    {
        if (session_status() != "PHP_SESSION_ACTIVE") {
            $session = new Session();
            $session->start();
            if (!$session->get("deck")) {
                $deck = new DeckOfCards();
                $session->set("deck", $deck);
            }
        }

        $session = $request->getSession();
        /** @var DeckOfCards $deck */
        $deck = $session->get("deck");
        $cards = $deck->draw(1);
        $session->set("deck", $deck);
        /** @var DeckOfCards $deck */
        $length = $deck->getLength();

        $data = [
            "cards" => $cards,
            "length" => $length,
            "deck" => $deck->deck
        ];

        return $this->render("draw.html.twig", $data);
    }

    #[Route("card/deck/draw/{number}", name:"drawnum", methods: ["GET"])]
    public function drawnum(Request $request, int $number = 1): Response
    {

        if (session_status() != "PHP_SESSION_ACTIVE") {
            $session = new Session();
            $session->start();
            if (!$session->get("deck")) {
                $deck = new DeckOfCards();
                $session->set("deck", $deck);
            }
        }

        $session = $request->getSession();
        /** @var DeckOfCards $deck */
        $deck = $session->get("deck");

        $cards = $deck->draw($number);
        $session->set("deck", $deck);
        /** @var DeckOfCards $deck */
        $deck = $session->get("deck");
        $cardCount = $deck->getLength();

        $data = [
            "cards" => $cards,
            "length" => $cardCount,
            "deck" => $deck->deck
        ];

        return $this->render("draw.html.twig", $data);
    }
}
