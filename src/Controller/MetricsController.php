<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;

/**
 * @codeCoverageIgnore
 * @SuppressWarnings(PHPMD)
 */
class MetricsController extends AbstractController
{
    #[Route("/metrics", name: "metrics", methods: ['GET'])]
    public function metrics(): Response
    {
        return $this->render("metrics.html.twig");
    }
}
