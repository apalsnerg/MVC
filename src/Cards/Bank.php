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
     * @return string the evaluated option.
     */
    public function handEval(): String
    {
        if ($this->score < 18) {
            return "draw";
        }
        return "fold";
    }
    /**
     * Method to evaluate whether to use the ace as 11 or 1 points.
     */
    public function evalAce(): void
    {
        $score = 1;
        if ($this->score > 6 && $this->score < 11) {
            $score = 11;
        }
        $this->score += $score;
    }
}
