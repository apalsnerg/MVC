<?php

namespace App\Controller;

use App\Cards\CardGame;
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
        }
        if (!$session->get("game")) {
            $game = new CardGame();
            $session->set("game", $game);
        }
        $session = $request->getSession();
        $game = $session->get("game");
        $session = $request->getSession();
        $game = $session->get("game");
        $card = null;
        $ace = false;
        $done = $session->get("done") || false;

        if (!$session->get("ace")) {
            if ($game->turn == 0 && $game->players[0]->score < 22) {
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

    #[Route("gameEval", name:"gameEval", methods: ["POST"])]
    public function gameEval(Request $request): Response
    {
        $session = $request->getSession();
        $game = $session->get("game");
        $action = $request->request->get("id");

        if ($action == "draw") {
            return $this->redirect("/game");
        } elseif ($action == "fold") {
            $game->fold();
            while ($game->players[1]->score < 20 && $game->turn == 1) {
                $card = $game->deck->draw();
                if (str_contains($card[0], "A")) {
                    $cardObj = $game->players[1]->stringToCard($card[0]);
                    $game->players[1]->hand->addCard($cardObj);
                    $game->players[1]->evalAce();
                } elseif ($game->players[1]->handEval() == "draw") {
                    $cardObj = $game->players[1]->stringToCard($card[0]);
                    $game->players[1]->hand->addCard($cardObj);
                    $game->players[1]->addPoints($cardObj);
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
    public function gamedocs(Request $request): Response
    {
        return $this->render("gamedocs.html.twig");
    }
}
