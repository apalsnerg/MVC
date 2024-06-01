<?php

namespace App\Adventure\Character;

use App\Adventure\Item\Weapon;

/**
 * @codeCoverageIgnore
 * @SuppressWarnings(PHPMD)
 */

class Enemy extends Character
{
    public function __construct()
    {

        $weapon = new Weapon("Scarred Battleaxe", 0, 2, 6, "strength");
        $stats =
        [
            "str" => rand(4, 8),
            "dex" => rand(4, 8),
            "int" => rand(2, 6),
            "wis" => rand(2, 6),
            "end" => rand(4, 8),
            "cha" => rand(1, 4)
        ];

        parent::__construct($stats, $weapon);
    }
}
