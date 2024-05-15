<?php

namespace App\Cards;

/**
 * Class to represent a hand of playing cards.
 */
class CardHand
{
    /** @var array<GraphicCard> a list containing GraphicCard objects */
    public array $hand = [];

    public function __construct(int $cards = 5)
    {
        for ($i = 0; $i < $cards && $i < 53; $i++) {
            $this->hand[] = new GraphicCard();
        }
    }

    /**
     * Method to return the graphic of the cards in the hand.
     *
     * @return array<string> An array of the graphics of the cards in the deck.
     */
    public function getCardGraphics(): array
    {
        $returnValues = [];
        $hand = $this->hand;
        foreach ($hand as $card) {
            $returnValues[] = $card->graphic();
        }
        return $returnValues;
    }

    /**
     * Method to add a card object to the hand.
     */
    public function addCard(GraphicCard $card): void
    {
        $this->hand[] = $card;
    }
}
