<?php

namespace App\Adventure;

use App\Adventure\Character\Character;
use App\Adventure\Character\Hero;
use App\Adventure\Character\Enemy;

class CombatHandler
{
    /** @var array<Character> $characters the characters in the combat scenario */
    public $characters = [];

    /** @var int $turn whose turn it is to attack */
    public $turn;

    /** @var int $target whose turn it is to be attacked */
    public $target;

    /**
     * @param Hero $hero the hero of the encounter
     * @param Enemy $enemy the opponent of the encounter
     */
    public function __construct($hero, $enemy)
    {
        $this->characters[] = $hero;
        $this->characters[] = $enemy;
        $this->turn = 0;
        $this->target = 1;
    }

    /**
     * Causes a turn of combat to take place.
     *
     * @return string what happened during the turn
     */
    public function combatTurn(): string
    {
        $target = $this->characters[$this->target];
        /** @var Character $attacker */
        $attacker = $this->characters[$this->turn];
        $damage = $attacker->getCharDealtDamage();
        $target->takeDamage($damage);
        $msg = $this->characters[$this->turn]->name . "dealt" . $damage . "damage to" . $this->characters[$this->target]->name . ".";
        if ($this->evalDead($this->characters[$this->target])) {
            $msg = "You defeated" . $this->characters[$this->target]->name . "!";
            $this->changeTurn(); // To reset to default later
            if ($this->characters[$this->target] instanceof Hero) {
                $msg = "You died. Your heroic deeds will be forever remembered>";
            }
        }
        $this->changeTurn();
        return $msg;
    }

    /**
     * Switches the target and attacker.
     */
    public function changeTurn(): void
    {
        if ($this->turn == 0) {
            $this->turn = 1;
            $this->target = 0;
        } elseif ($this->turn == 1) {
            $this->turn = 0;
            $this->target = 1;
        }
    }

    /**
     * Evaluates whether the target is dead.
     *
     * @param Character $target the target to evaluate
     */
    public function evalDead($target): bool
    {
        if ($target->health < 1) {
            return true;
        }
        return false;
    }
}
