<?php

namespace App\Controller;

use App\Cards\CardGame;
use App\Cards\GraphicCard;
use App\Cards\DeckOfCards;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class DeckController extends AbstractController
{
    #[Route("/card", name:"card", methods: ["GET"])]
    public function card(): Response
    {
        if (session_status() != "PHP_SESSION_ACTIVE") {
            $session = new Session();
            $session->start();
        }
        if (!$session->get("deck")) {
            $deck = new DeckOfCards();
            $session->set("deck", $deck);
        }

        $card = new GraphicCard();

        $data = [
            "card" => $card
        ];

        return $this->render("card.html.twig", $data);
    }

    #[Route("/card/deck", name:"deck", methods: ["GET"])]
    public function deck(): Response
    {
        if (session_status() != "PHP_SESSION_ACTIVE") {
            $session = new Session();
            $session->start();
        }
        if (!$session->get("deck")) {
            $deck = new DeckOfCards();
            $session->set("deck", $deck);
        }

        $deckBag = $session->getBag("attributes");
        $deck = $deckBag->get("deck");

        $data = [
            "session" => $session,
            "deck" => $deck->deck
        ];

        return $this->render("deck.html.twig", $data);
    }

    #[Route("/card/deck/shuffle", name:"shuffle", methods: ["GET"])]
    public function shuffle(): Response
    {
        if (session_status() != "PHP_SESSION_ACTIVE") {
            $session = new Session();
            $session->start();
        }
        if (!$session->get("deck")) {
            $deck = new DeckOfCards();
            $deck->shuffle();
            $session->set("deck", $deck);
        }

        $deckBag = $session->getBag("attributes");
        $deck = $deckBag->get("deck");

        if ($deck->getLength() == 0) {
            $deck = new DeckOfCards;
            $deck->shuffle();
            $session->set("deck", $deck);
        }
        
        $deck->shuffle();

        $data = [
            "session" => $session,
            "deck" => $deck->deck
        ];

        return $this->render("shuffle.html.twig", $data);
    }

    #[Route("card/deck/shuffle/reset", name:"cardShuffleReset", methods: ["GET"])]
    public function resetShuffle(): Response
    {
        if (session_status() != "PHP_SESSION_ACTIVE") {
            $session = new Session();
            $session->start();
        }

        $deck = new DeckOfCards();
        $deck->shuffle();
        $session->set("deck", $deck);

        return $this->redirect("../shuffle");
    }

    #[Route("card/deck/newDeckRedirect", name:"newDeckRedirect", methods:["POST"])]
    public function newDeckRedirect(Request $request): Response
    {
        $checkbox = $request->request->get("shfl");
        $deck = new DeckOfCards;
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
        }
        if (!$session->get("deck")) {
            $deck = new DeckOfCards();
            $session->set("deck", $deck);
        }

        $session = $request->getSession();
        $deck = $session->get("deck");
        $cards = $deck->draw(1);
        $session->set("deck", $deck);
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
        }
        if (!$session->get("deck")) {
            $deck = new DeckOfCards();
            $session->set("deck", $deck);
        }

        $session = $request->getSession();
        $deck = $session->get("deck");

        $cards = $deck->draw($number);
        $session->set("deck", $deck);

        $cardCount = $session->get("deck")->getLength();

        $data = [
            "cards" => $cards,
            "length" => $cardCount,
            "deck" => $deck->deck
        ];

        return $this->render("draw.html.twig", $data);
    }

    #[Route("gamestart", name:"gamestart", methods: ["GET"])]
    public function gamestart(Request $request): Response
    {
        $session = $request->getSession();
        $session->set("ace", false);
        if ($session->get("done")) {
            $session->remove("game");
        }
        $session->set("done", false);
        return $this->render("gamestart.html.twig");
    }

    #[Route("game", name:"game", methods: ["GET", "POST"])]
    public function game(Request $request): Response
    {
        $session = $request->getSession();
        $game = $session->get("game");
        if ($request->isMethod('POST')) {
            $action = $request->request->get("id");
            if ($action == "draw") {
                return $this->redirect("/game");
            } elseif ($action == "fold") {
                $game->fold();
                while ($game->players[1]->SCORE < 19 && $game->turn == 1) {
                    $card = $game->deck->draw();
                    if (str_contains($card[0], "A")) {
                        $ace = true;
                        $cardObj = $game->players[1]->stringToCard($card[0]);
                        $game->players[1]->hand->addCard($cardObj);
                        if ($game->players[1]->SCORE < 6) {
                            $game->players[1]->ace("high");
                        } else {
                            $game->players[1]->ace("low");
                        }
                    } elseif ($game->players[1]->handEval() == "draw") {
                        $cardObj = $game->players[0]->stringToCard($card[0]);
                        $game->players[1]->hand->addCard($cardObj);
                        $game->players[1]->addPoints($cardObj);
                    } else {
                        $game->fold();
                        $session->set("game", $game);
                    }
                }
                $session->set("done", true);
            } elseif ($action = "acehigh") {
                $game->players[0]->ace("high");
                $session->set("ace", true);
            } elseif ($action = "acelow") {
                $game->players[0]->ace("low");
                $session->set("ace", true);
            }
            $session->set("game", $game);
            return $this->redirect("/game");
            
        } else {
            if (session_status() != "PHP_SESSION_ACTIVE") {
                $session = new Session();
                $session->start();
            }
            if (!$session->get("game")) {
                $game = new CardGame();
                $session->set("game", $game);
            }
            
            $session = $request->getSession();
            $game = $session->get("game");
            $card = null;
            $ace = false;
            $done = $session->get("done") || false;
            var_dump($done);

            if (!$session->get("ace")) {
                if ($game->turn == 0) {
                    $card = $game->deck->draw();
                    if (str_contains($card[0], "A")) {
                        $ace = true;
                        $cardObj = $game->players[0]->stringToCard($card[0]);
                        $game->players[0]->hand->addCard($cardObj);
                        $session->set("ace", true);
                    } else {
                        $cardObj = $game->players[0]->stringToCard($card[0]);
                        $game->players[0]->hand->addCard($cardObj);
                        $game->players[0]->addPoints($cardObj);
                    }
                }
            }

            $session->set("ace", false);
            $data = [
                "player1" => $game->players[0]->hand->getCardGraphics(),
                "player1points" => $game->players[0]->getPoints(),
                "bank" => $game->players[1]->hand->getCardGraphics(),
                "bankpoints" => $game->players[1]->getPoints(),
                "turn" => $game->turn,
                "card" => $card,
                "ace" => $ace,
                "done" => $done,
                "victor" => $game->evalVictor()
            ];
            return $this->render("game.html.twig", $data);
        }
    }

    #[Route("gamedocs", name:"gamedocs", methods: ["GET"])]
    public function gamedocs(Request $request): Response
    {
        return $this->render("gamedocs.html.twig");
    }
}
