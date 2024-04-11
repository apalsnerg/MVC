<?php

namespace App\Controller;

use App\Cards\{DeckOfCards, GraphicCard};
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Attribute\AttributeBag;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;


class JSONRouteController extends AbstractController
{

    #[Route("/api", name: "api")]
    public function api(Request $request, RouterInterface $router): Response
    {
        $routes = $router->getRouteCollection();
        $data = [
            "routes" => $routes
        ];

        return $this->render("api.html.twig", $data);
    }

    #[Route("/api/quote", name: "api_quote")]
    public function quote(): Response
    {
        $quotes = 
        [
            "If you can't feed a hundred people, then feed just one.",
            "From the moment I understood the weakness of my flesh, it disgusted me. " .
            "I craved the strength and certainty of steel. I aspired to the purity of the Blessed Machine. " .
            "Your kind cling to your flesh, as though it will not decay and fail you. " .
            "One day the crude biomass you call the temple will wither, and you will beg my kind to save you. " .
            "But I am already saved, for the Machine is immortal... Even in death I serve the Omnissiah.",
            "You better cut the pizza in four pieces because I am not hungry enough to eat six.",
            "He was a bold man that first ate an oyster."
        ];
        $number = random_int(0, 3);
        $quote = $quotes[$number];
        $timestamp = date("H:i:s d-m-Y");
        $data = [
            "quote" => $quote,
            "date" => $timestamp
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
        );
        
        return $response;
    }

    #[Route("api/session", name:"api_session")]
    public function sesh(): Response
    {
        if (session_status() != "PHP_SESSION_ACTIVE") {
            $session = new Session();
            $session->start();
        }

        $session->set("test", "Testing if data submits");
        $sessiondata = $session->getBag("attributes");

        $data = [
            "session" => $session,
            "sessiondata" => $sessiondata
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
        );

        return $response;
    }

    #[Route("api/destroy", name:"api_destroy")]
    public function seshdestroy(Request $request): Response {

        $session = $request->getSession();
        $session->clear();

        $this->addFlash(
            'notice',
            'Session has been cleared!'
        );

        return $this->redirect("../api");
    }

    #[Route("api/deck", name:"api_deck")]
    public function deck(): Response {
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
        /*
        $suits = ["♣️", "♦️", "♥️", "♠️"];
        $values = ["A", "1", "2", "3", "4", "5", "6", "7", "8", "9", "J", "Q", "K"];
        foreach ($deck as &$card) {
            for ($a = 0; $a < 4; $a++) {
                for ($i = 0; $i < 13; $i++) {
                    $idx = $suits[$a] . $a . $i;
                    $card[$idx] = $card[$idx];
                }
            }
        }
        */

        $data = [
            "session" => $session,
            "deck" => $deck->deck
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
        );

        return $response;
    }

    #[Route("/api/deck/shuffle", name:"api_shuffle")]
    public function shuffle(): Response {
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

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
        );

        return $response;
    }

    #[Route("api/deck/reset", name:"api_reset")]
    public function reset_shuffle(): JsonResponse {
        if (session_status() != "PHP_SESSION_ACTIVE") {
            $session = new Session();
            $session->start();
        }

        $deck = new DeckOfCards();
        $deck->shuffle();
        $session->set("deck", $deck);

        $data = [
            "deck" => $deck->deck
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
        );

        return $response;
    }

    #[Route("api/deck/draw", name:"api_draw")]
    public function draw(Request $request): Response {

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


        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
        );

        return $response;
    }
    
    #[Route("api/deck/draw/{number}", name:"api_drawnum")]
    public function drawnum(Request $request, int $number=1): Response {

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
            "deck" => $deck
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
        );

        return $response;
    }
}