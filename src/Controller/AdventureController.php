<?php

namespace App\Controller;

use App\Adventure\Character\Hero;
use App\Adventure\Character\Enemy;
use App\Adventure\Adventure;
use App\Adventure\CombatHandler;
use App\Adventure\Item\Weapon;
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
        return $this->render("adventure/adventure.html.twig");
    }

    #[Route("/combat", name:"combat", methods: ["GET", "POST"])]
    public function combat(Request $request): Response
    {
        if (session_status() != "PHP_SESSION_ACTIVE") {
            $session = new Session();
            $session->start();
            if (!$session->get("adventure")) {
                $hero = new Hero([
                    "str" => 8,
                    "dex" => 8,
                    "int" => 8,
                    "wis" => 8,
                    "end" => 8,
                    "cha" => 8
                ]);
                $adventure = new Adventure($hero);
                $weapon = new Weapon("Axe of the Ancients", 15, 3, 6, "str");
                $hero->equipWeapon($weapon);
                $enemy = new Enemy();
                $combat = new CombatHandler($hero, $enemy);
                $session->set("adventure", $adventure);
                $session->set("combat", $combat);
            }
        }
        $session = $request->getSession();
        $adventure = $session->get("adventure");
        /** @var CombatHandler $combat */
        $combat = $session->get("combat");
        if ($request->isMethod("POST")) {
            $combat->combatTurn();
        }

        $data = [
            "player" => $combat->characters[0],
            "enemy" => $combat->characters[1]
        ];

        return $this->render("adventure/combat.html.twig", $data);
    }
}
