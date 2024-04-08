<?php

namespace App\Controller;

use App\Cards\Card;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
    public function lucky(): Response
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
    public function api(Request $request, RouterInterface $router)
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
    public function sesh()
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


    #[Route("/card", name:"card")]
    public function card() {
        if (session_status() != "PHP_SESSION_ACTIVE") {
            $session = new Session();
            $session->start();
        }

        $card = new Card();

        $data = [
            "card" => $card
        ];

        return $this->render("card.html.twig", $data);
    }

}