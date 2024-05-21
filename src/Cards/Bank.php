<?php

namespace App\Cards;

/**
 * Class to represent the Bank for the card game.
 */
class Bank extends Player
{
    public function __construct()
    {
        parent::__construct("bank");
    }

    /**
     * Method to evaluate whether to draw or to fold.
     * @return string the evaluated option
     */
    public function handEval(): String
    {
        if ($this->score < 18) {
            return "draw";
        }
        return "fold";
    }

    /*      DEPRECATED
    /**
     * Method to evaluate whether to use the ace as 11 or 1 points.
     *</
    public function evalAce(): void
    {
        $score = 1;
        if ($this->score > 6 && $this->score < 11) {
            $score = 11;
        }
        $this->score += $score;
    }
    */

    /**
     * Method to evaluate a given card and its impact on the Bank's hand.
     */
    public function evalCard(GraphicCard $card): string
    {
        $score = $card->value;
        if ($card->value == "A") {
            $score = 1;
            if ($this->score > 6 && $this->score < 11) {
                $score = 11;
            }
        } else if (in_array($card->value, ["J", "Q", "K"])) {
            $score = 10;
        }
        $this->score += $score;
        if ($this->score < 18) {
            return "draw";
        }
        return "fold";
    }
}
