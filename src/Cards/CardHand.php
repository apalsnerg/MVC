<?php

namespace App\Cards;

/**
 * Class to represent a hand of playing cards.
 */
class CardHand
{
    /** @var array<GraphicCard> a list containing GraphicCard objects */
    public array $hand = [];

    /**
     * Constructs the CardHand object.
     *
     * @param integer $amount the amount of cards to put in the hand
     */
    public function __construct(int $amount = 5)
    {
        for ($i = 0; $i < $amount && $i < 53; $i++) {
            $this->hand[] = new GraphicCard();
        }
    }

    /**
     * Returns the graphic of the cards in the hand.
     *
     * @return array<string> an array of the graphics of the cards in the deck
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
     * Returns the hand.
     *
     * @return array<GraphicCard> the hand array
     */
    public function getCards(): array
    {
        return $this->hand;
    }

    /**
     * Adds a card object to the hand.
     *
     * @param GraphicCard $card the card to be added
     */
    public function addCard(GraphicCard $card): void
    {
        $this->hand[] = $card;
    }
}
