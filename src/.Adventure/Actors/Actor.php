<?php

namespace Src\Adventure;
/**
 * @codeCoverageIgnore
 * @SuppressWarnings(PHPMD)
 */

class Character {
    /**
     * 
     */
    public $equippedWeapon;

    /**
     * The health of the character.
     */
    public $health;

    /**
     * 
     */
    public $stats = [];

    /**
     * The name of the character.
     */
    public $name;

    public function __construct($stats, $equippedWeapon="") {
        $this->stats = $stats;
        $this->health = 3 * $stats["end"];
        $this->equippedWeapon = $equippedWeapon;
    }

    public function equipWeapon(Weapon $weapon) {
        $this->equippedWeapon = $weapon;
    }

    
}