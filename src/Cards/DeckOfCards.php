<?php

namespace App\Cards;

/**
 * Class to represent a deck of playing cards.
 */
class DeckOfCards
{
    public $deck = [];

    public function __construct()
    {
        $suits = ["♣️", "♦️", "♥️", "♠️"];
        $values = ["A", "2", "3", "4", "5", "6", "7", "8", "9", "10", "J", "Q", "K"];

        for ($a = 0; $a < 4; $a++) {
            for ($i = 0; $i < 13; $i++) {
                $this->deck[] = "[" . $values[$i] . $suits[$a] . "]";
            }
        }
    }

    /**
     * Method to return the deck of cards.
     * 
     * @return array An array of all the contained cards.
     */
    public function returnAllCards()
    {
        return $this->deck;
    }

    /**
     * Method to shuffle all the cards in the deck (randomize indexes).
     */
    public function shuffle()
    {
        shuffle($this->deck);
    }

    /**
     * Draws an amount of cards from the deck and removes it.
     * 
     * @return array An array of the random cards.
     */
    public function draw($number = 1)
    {
        $returns = [];
        for ($i = 0; $i < $number && $i < 53; $i++) {
            $maxIdx = count($this->deck);
            if ($maxIdx > 1) {
                $randomCardIdx = random_int(0, $maxIdx - 1);
                $returns[] = $this->deck[$randomCardIdx];
                unset($this->deck[$randomCardIdx]);
                $this->deck = array_values($this->deck); # Update indexes
            } elseif ($maxIdx == 1) {
                $returns[] = $this->deck[0];
                unset($this->deck[0]);
                $this->deck = array_values($this->deck);
            }
        }
        
        return $returns;
    }

    /**
     * Method to return the amount of cards in the deck.
     * 
     * @return integer The amount of cards in the deck.
     */
    public function getLength()
    {
        return count($this->deck);
    }
}
