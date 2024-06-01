<?php

namespace App\Adventure\Character;

use App\Adventure\Item;

/**
 * @codeCoverageIgnore
 * @SuppressWarnings(PHPMD)
 */
class Hero extends Character
{
    /** @var array<mixed> $inventory the player's inventory */
    public $inventory = [];

    /**
     * Constructs a Hero.
     *
     * @param array<mixed> $stats
     */
    public function __construct($stats)
    {
        parent::__construct($stats);
    }

    /**
     * Method to add an item to the inventory.
     *
     * @param Item\Item $item the item to be added
     */
    public function addItem($item): void
    {
        $this->inventory[$item->name] =  $item;
    }
}
