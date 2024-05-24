<?php

namespace Src\Adventure;
/**
 * @codeCoverageIgnore
 * @SuppressWarnings(PHPMD)
 */
class Adventure {
    public $player;
    public $enemy;
    public $rooms;
    
    public function __construct(Hero $player = null) {
    $this->player = $player ?? "";
    $this->enemy = new Enemy();
    $this->rooms = new RoomManager();
    }

    public function attack($target, $damage) {
        $target->health -= $damage;
    }
}