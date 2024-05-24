<?php

namespace Src\Adventure;

/**
 * @codeCoverageIgnore
 * @SuppressWarnings(PHPMD)
 */

 class Enemy extends Character {
    public function __construct() {
        
        $weapon = new Weapon("Scarred Battleaxe", 2, 4, "strength");
        $this->stats =
        [
            "str" => rand(4, 8),
            "dex" => rand(4, 8),
            "int" => rand(2, 6),
            "wis" => rand(2, 6),
            "end" => rand(4, 8),
            "cha" => rand(0, 4)
        ];
        $health = rand(3 * $this->stats['end']);
        
        parent::__construct($health, $weapon);
    }
 }