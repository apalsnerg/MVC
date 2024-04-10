<?php

namespace App\Controller;

use App\Cards\DeckOfCards;
use App\Cards\GraphicCard;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Attribute\AttributeBag;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;


class ReportController extends AbstractController
{

    #[Route("/", name: "home")]
    public function home(): Response
    {
        return $this->render("home.html.twig");
    }

    #[Route("/about", name: "about")]
    public function about(): Response
    {
        return $this->render("about.html.twig");
    }

    #[Route("/report", name: "report")]
    public function report(): Response
    {
        return $this->render("report.html.twig");
    }

    #[Route("/lucky", name:"lucky")]
    public function lucky(Request $request): Response
    {

        $number = random_int(0, 100);
        $randImg = random_int(1, 12);

        $data = [
            "number" => $number,
            "randImg" => $randImg
        ];


        return $this->render("lucky.html.twig", $data);
    }

    #[Route("/api", name: "api")]
    public function api(Request $request, RouterInterface $router): Response
    {
        $routes = $router->getRouteCollection();
        $data = [
            "routes" => $routes
        ];

        return $this->render("api.html.twig", $data);
    }

    #[Route("/api/quote", name: "quote")]
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
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        #return $this->render("a.html.twig", $data);
        return $response;
    }

    #[Route("/session", name:"session")]
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

        return $this->render("session.html.twig", $data);
    }

    #[Route("/destroy", name:"destroy")]
    public function seshdestroy(Request $request): Response {

        $session = $request->getSession();
        $session->clear();

        return $this->redirect("session");
    }


    #[Route("/card", name:"card")]
    public function card(): Response {
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

    #[Route("/card/deck", name:"deck")]
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

        $data = [
            "session" => $session,
            "deck" => $deck
        ];

        return $this->render("deck.html.twig", $data);
    }

    #[Route("/card/deck/shuffle", name:"shuffle")]
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
            "deck" => $deck
        ];

        return $this->render("shuffle.html.twig", $data);
    }

    #[Route("card/deck/shuffle/reset")]
    public function reset_shuffle(): Response {
        if (session_status() != "PHP_SESSION_ACTIVE") {
            $session = new Session();
            $session->start();
        }

        $deck = new DeckOfCards();
        $deck->shuffle();
        $session->set("deck", $deck);

        $data = [
            "session" => $session,
            "deck" => $deck
        ];

        return $this->redirect("../shuffle");
    }

    #[Route("card/deck/newDeckRedirect", name:"newDeckRedirect", methods:["POST"])]
    public function newDeckRedirect(Request $request): Response {
        $checkbox = $request->request->get("shfl");
        if ($checkbox) {
            $deck = new DeckOfCards;
            $session = $request->getSession();
            $session->set("deck", $deck);
            return $this->redirect("shuffle/reset");
        }
        else {
            $deck = new DeckOfCards;
            $session = $request->getSession();
            $session->set("deck", $deck);
            return $this->redirect("../deck");
        }
    }

    #[Route("card/deck/draw", name:"draw")]
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
            "deck" => $deck
        ];

        return $this->render("draw.html.twig", $data);
    }
    
    #[Route("card/deck/draw/{number}", name:"drawnum")]
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

        return $this->render("draw.html.twig", $data);
    }
}