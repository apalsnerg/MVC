<?php

namespace App\Cards;

class Bank extends Player {
    public function __construct()
    {
        parent::__construct("bank");
    }
    
    public function handEval() {
        if ($this->score < 19) {
            return "draw";
        }
        return "fold";
    }
    public function evalAce() {
    if ($this->score < 6 || $this->score == 9 || $this->score == 10) {
        $this->score += 11;
    } else {
        $this->score += 1;
    }
    }
}