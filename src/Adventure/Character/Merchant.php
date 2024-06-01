<?php

namespace App\Adventure\Character;

use App\Adventure\Item\Potion;
use App\Adventure\Item\Weapon;
use App\Adventure\Item\Armour;
use App\Adventure\Item\Enchantment;
use App\Adventure\Item\Item;

/**
 * @codeCoverageIgnore
 * @SuppressWarnings(PHPMD)
 */
/**
 * Constructs a Merchant.
 *
 * @param array<mixed> $stats
 */
class Merchant extends Character
{
    /** @var array<mixed> $inventory the merchant's inventory */
    public $inventory = [];

    public function __construct()
    {
        //new HealthPotion(20)
        $stats =
        [
            "str" => 10,
            "dex" => 10,
            "int" => 10,
            "wis" => 10,
            "end" => 10,
            "cha" => 10
        ];
        $this->inventory =
        [
            "Charisma Potion" => new Potion("Charisma Potion", 20, "cha", 3),
            "Health Potion" => 20,
            "Axe of the Ancients" => new Weapon("Axe of the Ancients", 15, 3, 10, "str"),
            "Cuirass of the Colossus" =>
            new Armour(4, "Cuirass of the Colossus", 25)
        ];

        parent::__construct($stats);
    }

    /** @param Item $item the item to sell */
    public function sellItem($item): Item
    {
        $name = $item->name;
        /** @var Item $item */
        $item = $this->inventory[$name];
        unset($this->inventory[$name]);
        return $item;
    }
}
