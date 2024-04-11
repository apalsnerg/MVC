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
        $values = ["A", 1, 2, 3, 4, 5, 6, 7, 8, 9, "J", "Q", "K"];
        if (is_null($value)) {
            $this->value = $values[random_int(0, 12)];
        } else {
            $this->value = $value;
        }

        $suits = ["♣️", "♦️", "♥️", "♠️"];
        if (is_null($suit)) {
            $this->suit = $suits[random_int(0, 3)];
        } else {
            $this->suit = $suit;
        }
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
