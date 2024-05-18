<?php

namespace Src\Adventure;
/**
 * @codeCoverageIgnore
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
    
    public function attack($weapon) {
        $prefAttr = $weapon->getPrefAttr();
        $modifier = 1;
    }
}