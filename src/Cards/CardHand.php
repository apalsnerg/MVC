<?php

namespace App\Cards;

/**
 * Class to represent a hand of playing cards.
 */
class CardHand
{
    public $hand = [];
    
    public function __construct($cards = 5)
    {
        for ($i=0; $i < $cards && $i < 53; $i++) {
            $this->hand[] = new GraphicCard();
        }
    }
    
    /**
     * Method to return the graphic of the cards in the hand.
     * 
     * @return array An array of the graphics of the cards in the deck.
     */
    public function getCardGraphics()
    {
        $returnValues = [];
        $hand = $this->hand;
        foreach ($hand as $card) {
            $returnValues[] = $card->graphic();
        }
        return $returnValues;
    }

    public function addCard($card)
    {
        $this->hand[] = $card;
        var_dump($card);
    }
}
