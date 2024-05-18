<?php

namespace App\Cards;

/**
 * Class to represent the card game 21.
 */
class CardGame
{
    /** @var object $deck a DeckOfCards object */
    public object $deck;

    /** @var array<Player> $players a list of Player objects */
    public array $players = [];

    /** @var int $turn which player's turn it is */
    public int $turn;

    /**
     * Constructs the card game.
     */
    public function __construct()
    {
        $this->deck = new DeckOfCards();
        $this->players[] = new Player();
        $this->players[] = new Bank();
        $this->turn = 0;
    }

    /**
     * End the current player's turn.
     */
    public function fold(): void
    {
        $currentTurn = $this->turn;
        $this->turn = intval($currentTurn) + 1;
    }

    /**
     * Evaluate the victor of the game.
     *
     * @return string the victor
     */
    public function evalVictor()
    {
        if ($this->players[0]->score > 21 && $this->players[1]->score > 21) {
            return "none";
        }
        if ($this->players[1]->score >= $this->players[0]->score && $this-> players[1]->score < 22) {
            return "bank";
        }
        return "player";
    }
}
