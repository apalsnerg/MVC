<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
