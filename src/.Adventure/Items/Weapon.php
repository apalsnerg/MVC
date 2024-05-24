<?php

namespace Src\Adventure;

/**
 * @codeCoverageIgnore
 * @SuppressWarnings(PHPMD)
 */
class Weapon extends Item {
    /** @var string $name the name of the weapon */
    public $name;

    public $damageDice = [];

    public $prefAttr;

    public function __construct($name, $diceCount, $diceValue, $prefAttr="") {
        $this->name = $name;
        $this->damageDice = [strval($diceCount), strval($diceValue)];
        $this->prefAttr = $prefAttr;
    }

    public function getDamageNumber() {
        $dmg = 0;
        for ($i = 1; $i < $this->damageDice[0]; $i++) {
            $dmg += rand(1, $this->damageDice[1]);
        }
    }
}
