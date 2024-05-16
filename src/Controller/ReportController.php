<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;

class ReportController extends AbstractController
{
    #[Route("/", name: "home", methods: ['GET', 'HEAD'])]
    public function home(RouterInterface $router): Response
    {
        $routes = $router->getRouteCollection();
        $data = [
            "routes" => $routes
        ];

        return $this->render("home.html.twig", $data);
    }

    #[Route("/about", name: "about", methods: ['GET'])]
    public function about(): Response
    {
        return $this->render("about.html.twig");
    }

    #[Route("/report", name: "report", methods: ['GET'])]
    public function report(): Response
    {
        return $this->render("report.html.twig");
    }

    #[Route("/lucky", name:"lucky", methods: ['GET'])]
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

    #[Route("/session", name:"session", methods: ['GET'])]
    public function sesh(Request $request): Response
    {
        if (session_status() != "PHP_SESSION_ACTIVE") {
            $session = new Session();
            $session->start();
        }
        /** @var Session $session */
        $session = $request->getSession();
        $session->set("test", "Testing if data submits");
        $sessiondata = $session->getBag("attributes");

        $data = [
            "session" => $session,
            "sessiondata" => $sessiondata
        ];

        return $this->render("session.html.twig", $data);
    }

    #[Route("/destroy", name:"destroy", methods: ['GET'])]
    public function seshdestroy(Request $request): Response
    {
        $session = $request->getSession();
        $session->clear();

        $this->addFlash(
            'notice',
            'Session has been cleared!'
        );

        return $this->redirect("session");
    }
}
