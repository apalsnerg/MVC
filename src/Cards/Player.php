<?php

namespace App\Cards;

class Player
{
    /** @var CardHand the player's hand of cards */
    public $hand;
    /** @var mixed the player's identifier */
    public $identifier;
    /** @var int how many points the player's hand is worth */
    public $score;

    public function __construct(mixed $identifier = 0)
    {
        $this->hand = new CardHand(0);
        $this->identifier = $identifier;
        $this->score = 0;
    }

    /**
     * Method to return the amount of points the hand is worth.
     */
    public function getPoints(): int
    {
        return $this->score;
    }

    /**
     * Method to add points to $score from a GraphicCard object.
     */
    public function addPoints(GraphicCard $card): void
    {
        $totalPoints = 0;
        $value = $card->getValue();
        $totalPoints += intval($value);
        var_dump($totalPoints);

        if (in_array($card->value, [10, "J", "Q", "K"])) {
            $totalPoints = 10;
        }
        $this->score += $totalPoints;
    }

    /**
     * Method to add points to $score depending on how the player decides to use their ace.
     */
    public function ace(string $option): void
    {
        $score = 1;
        if ($option == "high") {
            $score = 11;
        }
        $this->score += $score;
    }

    /**
     * Method to turn a graphic representation of a card as a string into a GraphicCard object.
     */
    public function stringToCard(String $str): GraphicCard
    {

        $str = trim($str, "[]");
        $value = $str[0];
        $tenSuit = null;
        if (intval($str[0]) == 1 && intval($str[1]) == 0) {
            $value = "10";
            $tenSuit = substr($str, 2);
        }
        $suit = substr($str, 1);
        if (!empty($tenSuit)) {
            $suit = $tenSuit;
        }

        return new GraphicCard($value, $suit);
    }
}
