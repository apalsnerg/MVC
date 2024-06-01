<?php

namespace App\Adventure\Item;

/**
 * @codeCoverageIgnore
 * @SuppressWarnings(PHPMD)
 */
class Weapon extends Item
{
    /** @var string $name the name of the weapon */
    public $name;

    /** @var array<int> $damageDice */
    public $damageDice = [];

    /** @var string $prefAttr */
    public $prefAttr;

    /**
     * Constructs the weapon.
     *
     * @param string $name the name of the weapon
     * @param int $value the price of the weapon
     * @param int $diceCount the amount of dice to roll for damage
     * @param int $diceValue the highest value to be able to roll
     * @param string $prefAttr the attribute the weapon will do most damage with
     */
    public function __construct($name, $value, $diceCount, $diceValue, $prefAttr = "")
    {
        $this->name = $name;
        $this->damageDice = [intval($diceCount), intval($diceValue)];
        $this->prefAttr = $prefAttr;
        parent::__construct($name, ["grabbable"], $value);
    }

    public function getDamageNumber(): int
    {
        $dmg = 0;
        for ($i = 1; $i < $this->damageDice[0]; $i++) {
            $dmg += rand(1, $this->damageDice[1]);
        }
        return $dmg;
    }
}
