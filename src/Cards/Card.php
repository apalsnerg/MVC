<?php

namespace App\Cards;

/**
 * Class to represent a playing card with a suit and a value.
 */
class Card
{
    public $suit;
    public $value;
    
    public function __construct($value = null, $suit = null)
    {
        $values = ["A", "2", "3", "4", "5", "6", "7", "8", "9", "10", "J", "Q", "K"];
        if (is_null($value)) {
            $value = $values[random_int(0, 12)];
        }
        $this->value = $value;

        $suits = ["♣️", "♦️", "♥️", "♠️"];
        if (is_null($suit)) {
            $suit = $suits[random_int(0, 3)];
        }
        $this->suit = $suit;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getSuit()
    {
        return $this->suit;
    }
}
