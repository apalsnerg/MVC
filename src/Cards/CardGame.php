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
    public function __construct($deck=null, $players=[])
    {
        $this->deck = $deck ?? new DeckOfCards();
        $this->players = $players;
        if (count($players) === 0) {
            $this->players[] = new Player();
            $this->players[] = new Bank();
        }
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
        if ($this->players[1]->score >= $this->players[0]->score && $this->players[1]->score < 22) {
            return "bank";
        }
        if ($this->players[0]->score > $this->players[1]->score && $this->players[0]->score < 22) {
            return "player";
        }
        if ($this->players[0]->score < 22 && $this->players[1]->score > 21) {
            return "player";
        }
        if ($this->players[0]->score > 21 && $this->players[1]->score < 22) {
            return "bank";
        }
        return "none";
    }

    /**
     * Take the bank's turn.
     */
    public function bankTurn() {
        /** @var Bank $bank */
        $bank = $this->players[1];
        while (true) {
            /** @var DeckOfCards $deck */
            $deck = $this->deck;
            $card = $deck->draw()[0];
            $bank->hand->addCard($card);
            $res = $bank->evalCard($card);
            if ($res === "fold") {
                break;
            }

            /*
            if ($card->value == "A") {
                $bank->hand->addCard($card);
                $bank->evalAce();
            } else {
                $bank->hand->addCard($card);
                $bank->addPoints($card);
            }
            */
        }
        $this->fold();
    }
}
