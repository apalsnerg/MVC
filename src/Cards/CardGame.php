<?php

namespace App\Cards;

class CardGame {
    public $deck;
    public $players = [];
    public $turn;

    public function __construct() {
        $this->deck = new DeckOfCards;
        $this->players[] = new Player;
        $this->players[] = new Bank;
        $this->turn = 0;
    }

    public function fold() {
        $currentTurn = $this->turn;
        $this->turn = intval($currentTurn) + 1;
    }

    public function evalVictor() {
        if ($this->players[0]->score > 21) {
            if ($this->players[1]->score > 21) {
                return "none";
            }
            return "bank";
        }
        if ($this->players[1]->score >= $this->players[0]->score) {
            return "player";
        }
        return "bank";
    }

}