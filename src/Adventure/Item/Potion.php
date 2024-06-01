<?php

namespace App\Adventure\Item;

class Potion extends Item
{
    /** @var string $affectedStat the stat the potion affects */
    public $affectedStat;

    /** @var int $magnitude how big an effect the potion has */
    public $magnitude;

    /**
     * Creates the potion.
     *
     * @param string $name the name of the potion
     * @param int $value the value of the potion
     * @param string $stat the stat to affect
     * @param int $magnitude how big an effect the potion has
     */
    public function __construct($name, $value, $stat, $magnitude)
    {
        $this->affectedStat = $stat;
        $this->magnitude = $magnitude;
        parent::__construct($name, ["destructible", "grabbable"], $value);
    }
}
