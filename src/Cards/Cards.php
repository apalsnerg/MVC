<?php

namespace App\Cards;

/**
 * Class to represent a playing card with a suit and a value.
 */
class Card
{
    public $suit;
    public $value;
    
    public function __construct($value=null, $suit=null)
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
}
    
/**
 * Class to practice inheritance.
*/
class GraphicCard extends Card {

public function __construct()
{
    parent::__construct(NULL);
}

public function graphic()
{
    return "[" . $this->suit . $this->value . "]";
}
}

/**
 * Class to represent a hand of playing cards.
 */
class CardHand
{

    public $hand = [];
    
    public function __construct($cards = 5)
    {
        for ($i=0; $i < $cards; $i++) {
            $this->hand[] = new GraphicCard();
        }
    }

    public function getCards()
    {
        $return_values = [];
        $hand = $this->hand;
        foreach ($hand as $card) {
            $return_values[] = $card->graphic();
        }
        return $return_values;
    }
}

/**
 * Class to represent a deck of playing cards.
 */
class DeckOfCards
{

    public $deck = [];

    public function __construct()
    {
        $suits = ["♣️", "♦️", "♥️", "♠️"];
        $values = ["A", 1, 2, 3, 4, 5, 6, 7, 8, 9, "J", "Q", "K"];

        for ($a = 0; $a < 4; $a++) {
            for ($i = 0; $i < 13; $i++) {
                $this->deck[] = "[" . $values[$i] . $suits[$a] . "]";
            }
        }
    }

    /**
     * Method to echo all cards with linebreaks in browser. Used for debugging.
     */
    public function echoAll()
    {
        foreach ($this->deck as $card) {
            echo $card;
            echo "<hr>";
        }
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
     */
    public function draw($number = 1)
    {
        $returns = [];
        for ($i = 0; $i < $number && $i < 53; $i++) {
            $max_idx = count($this->deck);
            if ($max_idx > 1) {
                $random_card_idx = random_int(0, $max_idx - 1);
                $returns[] = $this->deck[$random_card_idx];
                unset($this->deck[$random_card_idx]);
                $this->deck = array_values($this->deck);
            } elseif ($max_idx == 1) {
                $returns[] = $this->deck[0];
                unset($this->deck[0]);
                $this->deck = array_values($this->deck);
            }
        }
        
        return $returns;
    }

    /*
     * Draws an amount of cards from the deck and removes it.
     
    public function draw($number = 1)
    {
        $returns = [];
        for ($i = 0; $i < $number && $i <= count($this->deck); $i++) {
            $max_idx = count($this->deck);
            echo $max_idx;
            if ($max_idx == 1) {
                $random_card_idx = 0;
            } else {
                $random_card_idx = random_int(0, $max_idx - 1);
            }
            $returns[] = $this->deck[$random_card_idx];
            $newDeck = $this->deck;
            unset($newDeck[$random_card_idx]);
            $newDeck = array_values($newDeck);
            echo count($newDeck);
            $this->deck = $newDeck;
        }
        echo count($this->deck);
        
        return $returns;
    }
    */

    public function getLength() {
        return count($this->deck);
    }
}
