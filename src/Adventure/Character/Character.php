<?php

namespace App\Adventure\Character;

use App\Adventure\Item\Weapon;

/**
 * @codeCoverageIgnore
 * @SuppressWarnings(PHPMD)
 */

class Character
{
    /** @var Weapon | null $equippedWeapon the character's equipped weapon.*/
    public $equippedWeapon;

    /** @var float $health the health of the character */
    public $health;

    /** @var array<mixed> $stats The stats of the character. */
    public $stats = [];

    /** @var string $name the name of the character. */
    public $name;

    /**
     * @param array<mixed> $stats the stats of the character
     * @param Weapon | null $equippedWeapon the weapon the character has equipped
     */
    public function __construct($stats, $equippedWeapon = null)
    {
        $this->stats = $stats;
        $this->health = 8 + (2 * $this->stats['end']);
        $this->equippedWeapon = $equippedWeapon;
    }

    /** @param Weapon $weapon the weapon to equip */
    public function equipWeapon(Weapon $weapon): void
    {
        $this->equippedWeapon = $weapon;
    }

    /** @param float $dmg the damage the character takes */
    public function takeDamage($dmg): void
    {
        $this->health -= $dmg;
    }

    /** The damage the character deals given their weapon */
    public function getCharDealtDamage(): float
    {
        /** @var \App\Adventure\Item\Weapon $weapon */
        $weapon = $this->equippedWeapon;
        $prefAttr = $weapon->prefAttr;
        $dmgModifier = floor(((($this->stats[$prefAttr] * 10) / 4) / 5));
        if ($this->stats[$prefAttr] === 10) {
            $dmgModifier = 4;
        }
        $dmgRaw = $weapon->getDamageNumber();
        $dmg = $dmgRaw + $dmgModifier;
        return $dmg;
    }
}
