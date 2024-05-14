<?php

namespace App\Cards;

class Player {
    public $hand;
    public $identifier;
    public $score;

    public function __construct($identifier=0) {
        $this->hand = new CardHand(0);
        $this->identifier = $identifier;
        $this->score = 0;
    }

    public function getPoints() {
        return $this->score;
    }

    public function addPoints(GraphicCard $card) {
        $totalPoints = 0;
        $value = $card->getValue();
        $totalPoints += intval($value);
        
        if (in_array($value, [10, "J", "Q", "K"])) {
            $totalPoints = 10;
        }
        $this->score += $totalPoints;
    }

    public function ace($option) {
        $score = 1;
        if ($option == "high") {
            $score = 11;
        }
        $this->score += $score;
    }

    public function stringToCard(String $str) {
        
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