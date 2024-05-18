<?php

namespace App\Cards;

use TypeError;

/**
 * Class to represent a playing card with a suit and a value.
 */
class Card
{
    public string $suit;
    public string $value;

    /**
     * Constructs the class.
     *
     * @param string $value the value of the card
     * @param string $suit the suit of the card
     */
    public function __construct(string $value = null, string $suit = null)
    {
        $values = ["A", "2", "3", "4", "5", "6", "7", "8", "9", "10", "J", "Q", "K"];
        if (!in_array($value, $values) && $value != null) {
            throw new TypeError("Not a valid value!");
        }
        if (is_null($value)) {
            $value = $values[random_int(0, 12)];
        }
        $this->value = $value;

        $suits = ["♣️", "♦️", "♥️", "♠️"];
        if (!in_array($suit, $suits)  && $suit != null) {
            throw new TypeError("Not a valid suit!");
        }
        if (is_null($suit)) {
            $suit = $suits[random_int(0, 3)];
        }
        $this->suit = $suit;
    }

    /**
     * Method to return the value of the card.
     *
     * @return string the value.
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * Method to return the suit of the card.
     *
     * @return string the suit.
     */
    public function getSuit()
    {
        return $this->suit;
    }
}
