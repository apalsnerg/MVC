<?php

namespace App\Adventure\Item;

class Armour extends Item
{
    /** @var int $armour the armour piece's damage reduction value */
    public $armour;

    /**
     * @param int $armour the armour value
     * @param string $name the name of the armour piece
     * @param int $price the price of the armour piece
     */
    public function __construct($armour, $name, $price)
    {
        $this->armour = $armour;
        parent::__construct($name, ["grabbable"], $price);
    }
}
