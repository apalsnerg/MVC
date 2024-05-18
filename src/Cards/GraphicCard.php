<?php

namespace App\Cards;

/**
 * Class to represent a card with a graphic component.
*/
class GraphicCard extends Card
{
    /** @var string $graphic the graphical representation of the card */
    public string $graphic;

    /**
     * Method to construct a GraphicCard object.
     *
     * @param string $value the value of the card
     * @param string $suit the suit of the card
     */
    public function __construct(string $value = null, string $suit = null)
    {
        parent::__construct($value, $suit);
        $this->graphic = "[" . $this->value . $this->suit . "]";
    }

    /**
     * Method to return the graphic representation of the card
     *
     * @return string the graphic
     */
    public function graphic(): string
    {
        return $this->graphic;
    }

    // DEPRECATED
    /*
     * Method to turn a string into a GraphicCard,
     *
     * @return object the resulting GraphicCard object

    public function stringToCard(string $str): object
    {
        $str = trim($str, "[]");
        $suit = $str[0];
        $str = ltrim($str, $str[0]);

        return new GraphicCard($str, $suit);
    }
    */
}
