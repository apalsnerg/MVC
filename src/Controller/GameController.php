<?php

namespace App\Controller;

use App\Cards\CardGame;
use App\Cards\DeckOfCards;
use App\Cards\Bank;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{
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

    #[Route("game", name:"game", methods: ["GET"])]
    public function game(Request $request): Response
    {
        if (session_status() != "PHP_SESSION_ACTIVE") {
            $session = new Session();
            $session->start();
            if (!$session->get("game")) {
                $game = new CardGame();
                $session->set("game", $game);
            }
        }
        $session = $request->getSession();
        /** @var CardGame $game */
        $game = $session->get("game");
        $card = null;
        $ace = false;
        $done = $session->get("done");

        if (!$session->get("ace")) {
            if ($game->turn == 0 && $game->players[0]->score < 22) {
                /** @var DeckOfCards $deck */
                $deck = $game->deck;
                $card = $deck->draw()[0];
                $game->players[0]->hand->addCard($card);
                $ace = true;
                $session->set("ace", true);
                if ($card->value != "A") {
                    $game->players[0]->addPoints($card);
                    $ace = false;
                    $session->set("ace", false);
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

    #[Route("gameEval", name:"gameEval", methods: ["POST"])]
    public function gameEval(Request $request): Response
    {
        $session = $request->getSession();
        /** @var CardGame $game */
        $game = $session->get("game");
        $action = $request->request->get("id");

        if ($action == "draw") {
            return $this->redirect("/game");
        } elseif ($action == "fold") {
            /** @var Bank $bank */
            $bank = $game->players[1];
            $game->fold();
            while ($bank->score < 20 && $game->turn == 1) {
                /** @var DeckOfCards $deck */
                $deck = $game->deck;
                $card = $deck->draw()[0];
                if ($card->value == "A") {
                    $bank->hand->addCard($card);
                    $bank->evalAce();
                } elseif ($bank->handEval() == "draw") {
                    $bank->hand->addCard($card);
                    $bank->addPoints($card);
                }
            }
            $game->fold();
            $session->set("game", $game);
            $session->set("done", true);
        } elseif ($action == "acehigh") {
            $game->players[0]->score += 11;
            $session->set("ace", true);
        } elseif ($action == "acelow") {
            $game->players[0]->score += 1;
            $session->set("ace", true);
        }
        $session->set("game", $game);
        return $this->redirect("/game");
    }

    #[Route("gamedocs", name:"gamedocs", methods: ["GET"])]
    public function gamedocs(): Response
    {
        return $this->render("gamedocs.html.twig");
    }
}
