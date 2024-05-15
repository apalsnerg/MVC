<?php

namespace App\Cards;

/**
 * Class to represent the card game 21.
 */
class CardGame
{
    /** @var object $deck a DeckOfCards object */
    public Object $deck;

    /** @var array<Player> a list of Player objects */
    public array $players = [];

    /** @var int $turn which player's turn it is */
    public int $turn;

    public function __construct()
    {
        $this->deck = new DeckOfCards();
        $this->players[] = new Player();
        $this->players[] = new Bank();
        $this->turn = 0;
    }

    /**
     * Method to end the current player's turn.
     */
    public function fold(): void
    {
        $currentTurn = $this->turn;
        $this->turn = intval($currentTurn) + 1;
    }

    /**
     * Method to evaluate the victor of the game.
     *
     * @return string the victor
     */
    public function evalVictor()
    {
        if ($this->players[0]->score > 21) {
            if ($this->players[1]->score > 21) {
                return "none";
            }
            return "bank";
        }
        if ($this->players[1]->score >= $this->players[0]->score && $this-> players[1]->score < 22) {
            return "bank";
        }
        return "player";
    }

}
