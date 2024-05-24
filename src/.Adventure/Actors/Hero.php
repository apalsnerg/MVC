<?php

namespace Src\Adventure;
/**
 * @codeCoverageIgnore
 * @SuppressWarnings(PHPMD)
 */
class Hero extends Character {
    public $backpack = [];
    
    /**
     * Constructs a Hero.
     * 
     * @param array<mixed> $stats 
     */
    public function __construct($stats) {
        parent::__construct($stats);
    }
    
    public function takeDamage($dmg) {
        $this->health -= $dmg;
    }
    
    public function getCharDealtDamage(Weapon $weapon) {
        $prefAttr = $weapon->prefAttr;
        $attrModifier = 10;
        $dmgModifier = floor(((($this->stats[$prefAttr] * 10) / 4) / 5));
        if ($this->stats[$prefAttr] === 10) {
            $dmgModifier = 4;
        }
        $dmgRaw = $weapon->getDamageNumber();
        $dmg = $dmgRaw + $dmgModifier;
    }
}