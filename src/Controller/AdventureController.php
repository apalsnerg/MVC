<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @codeCoverageIgnore
 * @SuppressWarnings(PHPMD)
 */
class AdventureController extends AbstractController
{
    #[Route("/adventure", name:"adventure", methods: ["GET"])]
    public function adventure(): Response
    {
        return new Response("WIP");
    }
}
