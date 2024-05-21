<?php

namespace Src\Adventure;
/**
 * @codeCoverageIgnore
 * @SuppressWarnings(PHPMD)
 */
class Hero {
    public $backpack = [];
    public $health;
    public $name;
    public $equipped;
    public $stats= [];
    
    public function __construct() {
    }
    
    public function takeDamage($dmg) {
        $this->health -= $dmg;
    }
    
    public function attack(Weapon $weapon) {
        $prefAttr = $weapon->prefAttr;
        $attrModifier = 10;
        $dmg = rand($weapon->damageMin, $weapon->damageMin);
        $dmgModifier = $dmg * (1 + $attrModifier/10);
    }
}