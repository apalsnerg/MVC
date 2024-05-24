<?php

namespace Src\Adventure;

use App\Cards\Player;

class CombatHandler {
    public $player;

    public $enemy;

    public $turn;

    public function __construct($player) {
        $this->player = $player || new Player();
        $this->enemy = new Enemy();
        $this->turn = 0;
    }
}