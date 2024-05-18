<?php

namespace App\Cards;

use TypeError;

/**
 * Class to represent a player in the card game.
 */
class Player
{
    /** @var CardHand $hand the player's hand of cards */
    public $hand;

    /** @var mixed $identifier the player's identifier */
    public $identifier;

    /** @var int $score how many points the player's hand is worth */
    public $score;

    /**
     * Constructs the Player.
     *
     * @param mixed $identifier the identifier for the player.
     */
    public function __construct(mixed $identifier = 0)
    {
        $this->hand = new CardHand(0);
        if (!is_string($identifier) && !is_int($identifier)) {
            throw new TypeError("Invalid identifier type!");
        }
        $this->identifier = $identifier;
        $this->score = 0;
    }

    /**
     * Return the amount of points the player has.
     *
     * @return int the score
     */
    public function getPoints(): int
    {
        return $this->score;
    }

    /**
     * Add points to $score from a GraphicCard object.
     *
     * @param GraphicCard $card the GraphicCard to be evaluated
     */
    public function addPoints(GraphicCard $card): void
    {
        $totalPoints = 0;
        $value = $card->getValue();
        $totalPoints += intval($value);

        if (in_array($card->value, [10, "J", "Q", "K"])) {
            $totalPoints = 10;
        }
        $this->score += $totalPoints;
    }

    /**
     * Add points to $this->score depending on how the player decides to use their ace.
     *
     * @param string $option whether to count as 11 or 1.
     */
    public function ace(string $option = "low"): void
    {
        if ($option != "low" && $option != "high") {
            throw new TypeError("Invalid argument type!");
        }
        $score = 1;
        if ($option == "high") {
            $score = 11;
        }
        $this->score += $score;
    }

    //DEPRECATED
    /*
    /**
     * Method to turn a graphic representation of a card as a string into a GraphicCard object.
     *
     * @param string $str the string to be converted.

    public function stringToCard(String $str) : GraphicCard
    {
        $str = trim($str, "[]");
        $value = $str[0];
        $tenSuit = null;
        if (intval($str[0]) == 1 && intval($str[1]) == 0) {
            $value = "10";
            $tenSuit = substr($str, 2);
        }
        if (!in_array($value, ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10"])) {
            throw new TypeError("Invalid argument: invalid value!");
        }

        $suit = substr($str, 1);
        if (!in_array($suit, ["♣️", "♦️", "♥️", "♠️"])) {
            throw new TypeError("Invalid argument: no suit provided!");
        }
        if (!empty($tenSuit)) {
            $suit = $tenSuit;
        }

        return new GraphicCard($value, $suit);
    }
    */
}
